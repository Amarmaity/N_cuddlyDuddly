<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\MasterCategory;
use \App\Models\Department;
use App\Models\SectionType;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
   
     public function index()
    {
        // Eager load full hierarchy: Departments → MasterCategories → SectionTypes → Categories
        $masterCategories = MasterCategory::with([
            'departments',          // Many-to-many departments
            'sectionTypes.categories'       // Nested eager load of section types → categories
        ])->paginate(10); // Pagination

        // dd($masterCategories);

        return view('admin.categories.index', compact('masterCategories'));
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
