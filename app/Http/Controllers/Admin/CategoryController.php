<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\MasterCategory;
use App\Models\Products;
use App\Models\SectionType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterCategorySection;


class CategoryController extends Controller
{
    public function index()
    {
        // load top-level departments that exist in master_category_sections
        $departments = MasterCategorySection::query()
            ->select('department_id')
            ->distinct()
            ->join('departments', 'departments.id', '=', 'master_category_sections.department_id')
            ->leftJoin('product_category_section', 'product_category_section.master_category_section_id', '=', 'master_category_sections.id')
            ->selectRaw('master_category_sections.department_id, departments.name as department_name, COUNT(product_category_section.id) as product_count')
            ->groupBy('master_category_sections.department_id', 'departments.name')
            ->get();

        // dd($departments);   

        return view('admin.categories.index', compact('departments'));
    }

    // Fetch children for a node (lazy load)
    public function children(Request $request, $level, $id = null)
    {
        // level can be 'department' -> returns master_categories under department
        // level 'master_category' -> section_types under that master category and department pair (pass dept_id)
        // level 'section_type' -> categories (master_category_section rows) for master_category+section_type

        if ($level === 'master_category') {
            // id = department_id
            $deptId = (int) $id;
            $rows = MasterCategorySection::query()
                ->where('department_id', $deptId)
                ->join('master_categories', 'master_categories.id', '=', 'master_category_sections.master_category_id')
                ->leftJoin('product_category_section', 'product_category_section.master_category_section_id', '=', 'master_category_sections.id')
                ->selectRaw('master_category_sections.master_category_id as id, master_categories.name as name, COUNT(product_category_section.id) as product_count')
                ->groupBy('master_category_sections.master_category_id', 'master_categories.name')
                ->get();

            return response()->json($rows);
        }

        if ($level === 'section_type') {
            // id = master_category_id, dept passed via query param ?dept=...
            $masterCategoryId = (int) $id;
            $deptId = (int) $request->query('dept');

            $rows = MasterCategorySection::query()
                ->where('master_category_id', $masterCategoryId)
                ->where('department_id', $deptId)
                ->join('section_types', 'section_types.id', '=', 'master_category_sections.section_type_id')
                ->leftJoin('product_category_section', 'product_category_section.master_category_section_id', '=', 'master_category_sections.id')
                ->selectRaw('master_category_sections.section_type_id as id, section_types.name as name, COUNT(product_category_section.id) as product_count')
                ->groupBy('master_category_sections.section_type_id', 'section_types.name')
                ->get();

            return response()->json($rows);
        }

        if ($level === 'category') {
            // id = section_type_id, dept & master passed via query params ?dept=&mc=
            $sectionTypeId = (int) $id;
            $deptId = (int) $request->query('dept');
            $masterCategoryId = (int) $request->query('mc');

            $rows = MasterCategorySection::query()
                ->where('section_type_id', $sectionTypeId)
                ->where('department_id', $deptId)
                ->where('master_category_id', $masterCategoryId)
                ->join('categories', 'categories.id', '=', 'master_category_sections.category_id')
                ->leftJoin('product_category_section', 'product_category_section.master_category_section_id', '=', 'master_category_sections.id')
                ->selectRaw('master_category_sections.id as id, categories.name as name, COUNT(product_category_section.id) as product_count')
                ->groupBy('master_category_sections.id', 'categories.name')
                ->get();

            return response()->json($rows);
        }
        return response()->json([], 400);
    }

    // public function products(Request $request,$category)
    // {
    //     $perPage = (int) $request->query('per_page', 20);
    //     $search = $request->query('search');
    //     $chainType = $request->query('chain_type');

    //     $query = Products::query()
    //         ->join('product_category_section as pcs', 'pcs.product_id', '=', 'products.id')
    //         ->join('master_category_sections as mcs', 'mcs.id', '=', 'pcs.master_category_section_id')
    //         ->where('mcs.master_category_id', $category)
    //         ->select('products.*')
    //         ->distinct('products.id');   // 🔥 FIX: avoid GROUP BY issues

    //     // 🧩 Apply chain filter
    //     if ($chainType === 'department') {
    //         $query->where('mcs.department_id', $request->query('dept'));
    //     } elseif ($chainType === 'master_category') {
    //         $query->where('mcs.master_category_id', $request->query('mc'))
    //             ->where('mcs.department_id', $request->query('dept'));
    //     } elseif ($chainType === 'section_type') {
    //         $query->where('mcs.section_type_id', $request->query('st'))
    //             ->where('mcs.master_category_id', $request->query('mc'))
    //             ->where('mcs.department_id', $request->query('dept'));
    //     } elseif ($chainType === 'category') {
    //         $query->where('pcs.master_category_section_id', $request->query('mcs_id'));
    //     }

    //     // 🔍 Search filter
    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('products.name', 'like', "%{$search}%")
    //                 ->orWhere('products.description', 'like', "%{$search}%");
    //         });
    //     }

    //     // 📌 Sorting
    //     if ($request->query('sort') === 'price_asc') {
    //         $query->orderBy('products.price', 'asc');
    //     } else {
    //         $query->orderBy('products.created_at', 'desc');
    //     }

    //     // 🐎 Eager load
    //     $query->with(['images', 'seller']);

    //     // 📄 Pagination
    //     $products = $query->paginate($perPage)->withQueryString();

    //     return response()->json($products);
    // }

    public function products(Request $request, $category = null)
    {
        $perPage   = (int) $request->query('per_page', 20);
        $search    = $request->query('search');
        $chainType = $request->query('chain_type');

        $query = Products::query()
            ->join('product_category_section as pcs', 'pcs.product_id', '=', 'products.id')
            ->join('master_category_sections as mcs', 'mcs.id', '=', 'pcs.master_category_section_id')
            ->select('products.*')
            ->distinct('products.id')
            ->where('products.is_approved', 1)
            ->where('products.featured', 1);

        /*
    |--------------------------------------------------------------------------
    | ✅ CATEGORY FILTER (FIXED)
    |--------------------------------------------------------------------------
    | $category coming from menu = categories.id
    */
        if (!empty($category)) {
            $query->where('mcs.category_id', $category);
        }

        /*
    |--------------------------------------------------------------------------
    | Chain-based filters (Admin Explorer)
    |--------------------------------------------------------------------------
    */
        if ($chainType === 'department') {
            $query->where('mcs.department_id', $request->query('dept'));
        } elseif ($chainType === 'master_category') {
            $query->where('mcs.master_category_id', $request->query('mc'))
                ->where('mcs.department_id', $request->query('dept'));
        } elseif ($chainType === 'section_type') {
            $query->where('mcs.section_type_id', $request->query('st'))
                ->where('mcs.master_category_id', $request->query('mc'))
                ->where('mcs.department_id', $request->query('dept'));
        } elseif ($chainType === 'category') {
            $query->where('pcs.master_category_section_id', $request->query('mcs_id'));
        }

        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                    ->orWhere('products.description', 'like', "%{$search}%");
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */
        if ($request->query('sort') === 'price_asc') {
            $query->orderBy('products.price', 'asc');
        } else {
            $query->orderBy('products.created_at', 'desc');
        }

        /*
    |--------------------------------------------------------------------------
    | Eager Load
    |--------------------------------------------------------------------------
    */
        $query->with(['images', 'seller']);

        /*
    |--------------------------------------------------------------------------
    | Pagination & Response
    |--------------------------------------------------------------------------
    */
        $products = $query->paginate($perPage)->withQueryString();

        if (Auth::guard('admin')->check()) {
            return response()->json($products);
        }

        return ProductListResource::collection($products);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:master,section,category',
        ]);

        $slug = Str::slug($validated['name']);

        switch ($validated['type']) {
            case 'master':
                MasterCategory::where('id', $id)->update(['name' => $validated['name'], 'slug' => $slug]);
                break;
            case 'section':
                SectionType::where('id', $id)->update(['name' => $validated['name'], 'slug' => $slug]);
                break;
            case 'category':
                Category::where('id', $id)->update(['name' => $validated['name'], 'slug' => $slug]);
                break;
        }

        return $request->ajax()
            ? response()->json(['success' => true, 'message' => ucfirst($validated['type']) . ' updated successfully.'])
            : back()->with('success', ucfirst($validated['type']) . ' updated successfully.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:master,category',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $item = $request->type === 'master'
            ? MasterCategory::findOrFail($request->id)
            : Category::findOrFail($request->id);

        $folder = $request->type === 'master'
            ? 'images/master_category_banners'
            : 'images/category_banners';

        $slug = Str::slug($item->name);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $slug . '.' . $extension;
        $dbPath = "$folder/$filename";

        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }

        $request->file('image')->storeAs($folder, $filename, 'public');

        $item->update(['image_url' => $dbPath]);

        return response()->json([
            'success' => true,
            'url' => asset('storage/' . $dbPath),
            'message' => 'Image uploaded successfully!',
        ]);
    }
}
