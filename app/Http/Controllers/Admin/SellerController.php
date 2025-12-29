<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Mail\SellerKycStatusMail;

class SellerController extends Controller
{

    public function index(Request $request)
    {
        $query = Sellers::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('postal_code', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        switch ($request->get('sort')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->orderBy('name');
                break;
            case 'products':
                $query->withCount('products')->orderBy('products_count', 'desc');
                break;
            default:
                $query->latest();
        }

        $sellers = $query->paginate(20)->withQueryString();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('admin.sellers.create');
    }

    public function store(Request $request)
    {
        try {
            // -----------------------------
            // 1. BASIC VALIDATION
            // -----------------------------
            $request->validate([
                'name'              => 'required|string|regex:/^[A-Za-z ]+$/|max:255',
                'contact_person'    => 'required|string|max:255',
                'email'             => 'required|email|unique:sellers,email',
                // Allow flexible phone input (we'll normalise + validate uniqueness below)
                'phone'             => 'required|string|min:6|max:20',
                'country_calling_code' => 'nullable|string|max:10',
                'country_iso' => 'nullable|string|max:5',
                'address'           => 'nullable|string|max:500',
                'city'              => 'nullable|string|max:255',
                'state'             => 'nullable|string|max:255',
                'country'           => 'nullable|string|max:255',
                'postal_code'       => 'nullable|string|max:20',
                'gst_number'        => 'nullable|string|max:50',
                'pan_number'        => 'nullable|string|max:20',
                'bank_account_number' => 'nullable|string|max:50',
                'bank_name'         => 'nullable|string|max:255',
                'ifsc_code'         => 'nullable|string|max:50',
                'upi_id'            => 'nullable|string|max:100',
                'commission_rate'   => 'nullable|numeric|min:0|max:100',
                'logo'              => 'nullable|file|image|mimes:jpg,jpeg,png,svg|max:2048',
                'documents'         => 'nullable',
                'documents.*'       => 'nullable|file|mimes:jpg,jpeg,png,pdf,txt,doc|max:4096',
                'is_active'         => 'nullable|boolean',
            ]);

            // -----------------------------
            // 2. NORMALISE PHONE + UNIQUE CHECK
            // -----------------------------
            $rawPhone = $request->input('phone');
            $digits = preg_replace('/\D+/', '', $rawPhone);
            $callingCode = preg_replace('/\D+/', '', $request->input('country_calling_code', ''));

            // If we have a calling code, use it; otherwise keep digits only
            $normalizedPhone = $callingCode ? ($callingCode . $digits) : $digits;

            // check uniqueness
            if (Sellers::where('phone', $normalizedPhone)->exists()) {
                return redirect()->back()->withErrors(['phone' => 'Phone number already exists.'])->withInput();
            }

            // -----------------------------
            // 3. PREPARE DATA
            // -----------------------------
            $data = $request->except(['logo', 'documents', 'is_active']);
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            $data['compliance_status'] = 'pending';

            // store normalized phone and country meta when possible
            $data['phone'] = $normalizedPhone;
            if ($request->filled('country_calling_code') && Schema::hasColumn('sellers', 'country_calling_code')) {
                $data['country_calling_code'] = $callingCode;
            }
            if ($request->filled('country_iso') && Schema::hasColumn('sellers', 'country_iso')) {
                $data['country_iso'] = strtoupper($request->input('country_iso'));
            }

            // -----------------------------
            // 3. STORE LOGO
            // -----------------------------
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('seller_docs', 'public');
            }

            // -----------------------------
            // 4. STORE DOCUMENTS (single or multiple)
            // -----------------------------
            if ($request->hasFile('documents')) {
                $documentPaths = [];
                $files = $request->file('documents');

                // Convert single file to array
                if (!is_array($files)) {
                    $files = [$files];
                }

                foreach ($files as $doc) {
                    $documentPaths[] = $doc->store('seller_docs', 'public');
                }

                $data['documents'] = json_encode($documentPaths);
            }

            // -----------------------------
            // 5. CREATE SELLER
            // -----------------------------
            Sellers::create($data);

            // -----------------------------
            // 6. SUCCESS RESPONSE
            // -----------------------------
            return redirect()->route('admin.sellers.index')
                ->with('success', 'Seller created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors to front-end
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Catch all other errors
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }






    public function show(Sellers $seller)
    {
        return view('admin.sellers.show', compact('seller'));
    }

    public function edit(Sellers $seller)
    {
        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, Sellers $seller)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'phone' => 'required|string|min:6|max:20',
            'country_calling_code' => 'nullable|string|max:10',
            'country_iso' => 'nullable|string|max:5',
        ]);

        // Normalize phone
        $rawPhone = $request->input('phone');
        $digits = preg_replace('/\D+/', '', $rawPhone);
        $callingCode = preg_replace('/\D+/', '', $request->input('country_calling_code', ''));
        $normalizedPhone = $callingCode ? ($callingCode . $digits) : $digits;

        // uniqueness check excluding current seller
        if (Sellers::where('phone', $normalizedPhone)->where('id', '<>', $seller->id)->exists()) {
            return redirect()->back()->withErrors(['phone' => 'Phone number already exists.'])->withInput();
        }

        $data = $request->except(['country_calling_code', 'country_iso']);
        $data['phone'] = $normalizedPhone;
        if ($request->filled('country_calling_code') && Schema::hasColumn('sellers', 'country_calling_code')) {
            $data['country_calling_code'] = $callingCode;
        }
        if ($request->filled('country_iso') && Schema::hasColumn('sellers', 'country_iso')) {
            $data['country_iso'] = strtoupper($request->input('country_iso'));
        }

        $seller->update($data);

        return redirect()->route('admin.sellers.index')
            ->with('success', 'Seller updated successfully');
    }

    public function destroy(Sellers $seller)
    {
        $seller->delete();

        return redirect()->route('admin.sellers.index')
            ->with('success', 'Seller deleted successfully');
    }



    public function viewDocs(Sellers $seller)
    {
        $docs = json_decode($seller->documents, true);

        if (empty($docs) || !is_array($docs)) {
            return back()->with('error', 'Documents not found for this seller.');
        }

        $filePath = $docs[0];

        if (!Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'Documents not found for this seller.');
        }

        $fullPath = Storage::disk('public')->path($filePath);

        return response()->file($fullPath);
    }


    public function compliance()
    {
        // Pending applications
        $pendingKyc = Sellers::where('compliance_status', 'pending')->paginate(20, ['*'], 'pending_page');

        // Rejected applications
        $rejectedKyc = Sellers::where('compliance_status', 'rejected')
            ->paginate(20, ['*'], 'rejected_page');

        return view('admin.sellers.compliance', compact('pendingKyc', 'rejectedKyc'));
    }

    public function KYCaccept($id)
    {
        $seller = Sellers::findOrFail($id);

        $seller->update([
            'compliance_status' => 'verified',
        ]);

        Mail::to($seller->email)->send(new SellerKycStatusMail($seller, 'verified'));

        return back()->with('success', 'Seller KYC verified successfully and email sent.');
    }

    public function KYCreject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $seller = Sellers::findOrFail($id);

        $seller->update([
            'compliance_status' => 'rejected',
        ]);

        Mail::to($seller->email)->send(new SellerKycStatusMail(
            $seller,
            'rejected',
            $request->rejection_reason
        ));

        return back()->with('success', 'Seller KYC rejected successfully and email sent.');
    }

    public function bankDetails(Sellers $seller)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'name' => $seller->bank_holder_name ?? $seller->name,
                'account' => $seller->bank_account_number,
                'ifsc' => $seller->ifsc_code,
                'upi' => $seller->upi_id,
                'verified' => (bool) $seller->bank_verified
            ]
        ]);
    }
}
