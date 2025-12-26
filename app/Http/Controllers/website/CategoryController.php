<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Models\HomeCategoryGroup;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function products(Request $request, $category = null)
    {
        $perPage = (int) $request->query('per_page', 30);
        $search = $request->query('search');

        $query = Products::query()
            ->where('products.is_approved', 1);

        // Check if category is a slug (from HomeCategoryGroup) or an ID (from admin categories)
        if (is_numeric($category)) {
            // Category ID from admin system - use whereExists to avoid duplicate rows and GROUP BY issues
            $categoryId = (int) $category;

            $query->whereExists(function ($q) use ($categoryId) {
                $q->select(DB::raw(1))
                    ->from('product_category_section as pcs')
                    ->join('master_category_sections as mcs', 'mcs.id', '=', 'pcs.master_category_section_id')
                    ->whereRaw('pcs.product_id = products.id')
                    ->where('mcs.category_id', $categoryId);
            });
        } else {
            // Category slug from HomeCategoryGroup system
            $categoryGroup = HomeCategoryGroup::where('slug', $category)->with('masterCategories')->firstOrFail();

            // get master category ids attached to this home group
            $masterIds = $categoryGroup->masterCategories->pluck('id')->toArray();

            // Log for debugging (remove in production)
            \Illuminate\Support\Facades\Log::debug('HomeCategoryGroup master IDs', ['slug' => $category, 'group_id' => $categoryGroup->id, 'master_ids' => $masterIds]);

            // Use whereExists with master IDs to avoid grouping
            $query->whereExists(function ($q) use ($masterIds) {
                $q->select(DB::raw(1))
                    ->from('product_category_section as pcs')
                    ->join('master_category_sections as mcs', 'mcs.id', '=', 'pcs.master_category_section_id')
                    ->whereRaw('pcs.product_id = products.id')
                    ->whereIn('mcs.master_category_id', $masterIds ?: [-1]);
            });
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