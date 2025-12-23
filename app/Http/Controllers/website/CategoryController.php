<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Models\HomeCategoryGroup;
use App\Models\Products;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get products for a category by slug or category ID
     */
    public function products(Request $request, $category = null)
    {
        $perPage = (int) $request->query('per_page', 20);
        $search = $request->query('search');

        $query = Products::query()
            ->join('product_category_section as pcs', 'pcs.product_id', '=', 'products.id')
            ->join('master_category_sections as mcs', 'mcs.id', '=', 'pcs.master_category_section_id')
            ->select('products.*')
            ->distinct('products.id')
            ->where('products.is_approved', 1);

        // Check if category is a slug (from HomeCategoryGroup) or an ID (from admin categories)
        if (is_numeric($category)) {
            // Category ID from admin system
            $query->where('mcs.category_id', $category);
        } else {
            // Category slug from HomeCategoryGroup system
            $categoryGroup = HomeCategoryGroup::where('slug', $category)->firstOrFail();
            $query->join('home_category_group_master_category as hcgmc', 'hcgmc.master_category_id', '=', 'mcs.master_category_id')
                ->where('hcgmc.home_category_group_id', $categoryGroup->id);
        }

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                    ->orWhere('products.description', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($request->query('sort') === 'price_asc') {
            $query->orderBy('products.price', 'asc');
        } elseif ($request->query('sort') === 'price_desc') {
            $query->orderBy('products.price', 'desc');
        } else {
            $query->orderBy('products.created_at', 'desc');
        }

        // Eager load
        $query->with(['images', 'seller']);

        // Pagination
        $products = $query->paginate($perPage)->withQueryString();

        return ProductListResource::collection($products);
    }
}
