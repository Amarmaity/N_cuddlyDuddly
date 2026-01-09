<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Products;
use App\Models\ProductImage;
use App\Models\MasterCategorySection;
use App\Models\ProductCategorySection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index()
    {
        $seller = Auth::guard('seller')->user();

        $products = Products::where('seller_id')
            ->latest()
            ->paginate(20);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        // Logged-in seller (if you need any seller info for display)
        // $seller = Auth::guard('seller')->user();
        // $authenticSeller = $seller->id;

        // // Fetch category hierarchy
        // $categoryTree = MasterCategorySection::with(['masterCategory', 'sectionType', 'category'])->get();

        return view('seller.products.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'master_category_section_id' => 'required|array|min:1',
            'master_category_section_id.*' => 'exists:master_category_sections,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images' => 'required|array|min:3',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:500', 
        ], [
            'images.*.mimes' => 'Only JPG, JPEG, or PNG formats are allowed.',
            'images.*.max' => 'Each image must be less than 500KB.',
            'images.required' => 'Upload at least 3 product images.',
        ]);

        DB::beginTransaction();

        try {
            // Use logged-in seller ID
            $sellerId = $request->authenticSeller;

            $product = Products::create([
                'seller_id' => $sellerId,
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']) . '-' . uniqid(),
                'description' => $validated['description'] ?? null,
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'featured' => 0,
                'is_approved' => 0, // will need admin approval
            ]);

            // Store product images
            if ($request->hasFile('images')) {
                $isFirst = true;
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => $isFirst ? 1 : 0,
                    ]);

                    $isFirst = false;
                }
            }

            // Attach categories
            foreach ($validated['master_category_section_id'] as $categoryId) {
                ProductCategorySection::create([
                    'product_id' => $product->id,
                    'master_category_section_id' => $categoryId,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('seller.products.index')
                ->with('success', 'Product added successfully and pending for approval.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while saving the product. ' . $e->getMessage());
        }
    }

    // public function edit($id)
    // {
    //     $seller = Auth::guard('seller')->user();
    //     $product = Products::where('seller_id', $seller->id)->findOrFail($id);

    //     return view('seller.products.edit', compact('product'));
    // }

    public function update(Request $request, $id)
    {
        $seller = Auth::guard('seller')->user();
        $product = Products::where('seller_id', $seller->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->only('name', 'price', 'stock'));

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    public function show($id)
    {
        $sellerId = Auth::guard('seller')->id();

        $product = Products::with([
            'images',
            'seller',
            'categorySections.masterCategory',
            'categorySections.sectionType',
            'categorySections.category'
        ])
            ->where('seller_id', $sellerId)
            ->findOrFail($id);

        return view('seller.products.show', compact('product'));
    }

    public function destroy($id)
    {
        $seller = Auth::guard('seller')->user();
        $product = Products::where('seller_id', $seller->id)->findOrFail($id);
        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}
