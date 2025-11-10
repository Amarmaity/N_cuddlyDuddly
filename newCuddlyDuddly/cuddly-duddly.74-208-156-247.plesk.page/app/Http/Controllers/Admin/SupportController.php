<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerSupport;
use App\Models\CustomerSupportMessage;
use App\Models\SellerSupport;
use App\Models\SellerSupportMessage;
use App\Models\Review;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function customer(Request $request)
    {
        $query = CustomerSupport::with('customer');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('ticket_id', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    })
                    ->orWhere('order_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $supports = $query->orderByDesc('updated_at')->paginate(10);

        return view('admin.supports.customerSupport', compact('supports'));
    }

    public function getMessagesforCustomer(CustomerSupport $support)
    {
        $messages = $support->messages()
            ->orderBy('created_at', 'asc')->get();
        return response()->json(['messages' => $messages]);
    }

    public function storeMessageforCustomer(Request $request, CustomerSupport $support)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|max:5120',
        ]);

        $paths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $paths[] = $file->store('support_attachments', 'public');
            }
        }

        // ✅ Determine sender based on guard
        if (Auth::guard('admin')->check()) {
            $senderId = Auth::guard('admin')->id();
            $senderType = 'admin';
        } else {
            $senderId = Auth::guard('web')->id(); // regular customer
            $senderType = 'customer';
        }

        CustomerSupportMessage::create([
            'support_id' => $support->id,
            'sender_id' => $senderId,
            'sender_type' => $senderType,
            'message' => $request->message,
            'attachments' => $paths ? json_encode($paths) : null,
        ]);

        $support->touch();

        return response()->json(['success' => true]);
    }

    public function seller(Request $request)
    {
        $query = SellerSupport::with(['seller', 'admin', 'product.primaryImage', 'product.images', 'product.reviews'])
            ->latest();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhereHas('seller', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('product', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $supports = $query->paginate(15);
        // dd($supports);

        return view('admin.supports.sellerSupport', compact('supports'));
    }

    public function getMessagesforSeller($id)
    {
        $messages = SellerSupportMessage::where('seller_support_id', $id)
            ->with(['seller', 'admin'])
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function storeMessageforSeller(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'attachment.*' => 'nullable|file|max:5120', // allow multiple files
        ]);

        // 🔍 Find related ticket
        $ticket = SellerSupport::findOrFail($id);

        // 📡 Define sender (admin)
        $senderType = 'admin';
        $senderId   = $ticket->admin_id ?? auth()->id();

        if (!$senderId) {
            return response()->json([
                'success' => false,
                'error' => 'No admin assigned to this ticket'
            ], 400);
        }

        // 📎 Handle multiple attachments
        $attachments = [];
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $path = $file->store('support-attachments', 'public');
                $attachments[] = asset('storage/' . $path);
            }
        }

        // 💬 Create the support message
        $message = SellerSupportMessage::create([
            'seller_support_id' => $ticket->id,
            'sender_type'       => $senderType,
            'sender_id'         => $senderId,
            'message'           => $request->message,
            'attachment'        => $attachments ?: null, // stored as JSON automatically
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function searchReview($productId)
    { 
        $reviews = Review::where('product_id', $productId)
            ->with(['customer:id,first_name,last_name,email', 'product.primaryImage'])
            ->get()
            ->map(function ($r) {
                $r->customer_name = trim(($r->customer->first_name ?? '') . ' ' . ($r->customer->last_name ?? '')) ?: 'Anonymous';
                $r->customer_email = $r->customer->email ?? 'No email';
                $r->product_image = $r->product?->primaryImage?->image_path;

                $image = $r->product?->primaryImage?->image_path;
                $r->product_image = $image ? "images/products/" . basename($image) : null;
                return $r;
            });
        return response()->json(['reviews' => $reviews]);
    }

    public function showSupport($id)
    {
        $support = SellerSupport::with(['seller', 'admin'])->findOrFail($id);
        return view('admin.support.show', compact('support'));
    }

     public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|string']);
        $support = SellerSupport::findOrFail($id);

        $adminId = auth()->guard('admin')->id();

        switch ($request->status) {
            case 'closed':
                $support->update([
                    'status' => 'closed',
                    'closed_by' => $adminId,
                    'closed_at' => now(),
                ]);
                break;

            case 'reopen':
            case 'reopened':
                $support->update([
                    'status' => 'reopened',
                    'reopened_by' => $adminId,
                    'reopened_at' => now(),
                ]);
                break;

            case 'processing':
            case 'pending':
            case 'open':
                $support->update([
                    'status' => $request->status,
                    'admin_id' => $adminId, // assign current admin
                ]);
                break;
        }

        return response()->json([
            'success' => true,
            'status' => $support->status,
            'closed_by' => $support->closedBy?->name,
            'reopened_by' => $support->reopenedBy?->name,
        ]);
    }

    public function updateBankInfo(Request $request, Sellers $seller)
    {
        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:50',
            'upi_id' => 'nullable|string|max:100',
        ]);

        $seller->update($validated);

        return response()->json(['message' => 'Bank info updated successfully.']);
    }
}
