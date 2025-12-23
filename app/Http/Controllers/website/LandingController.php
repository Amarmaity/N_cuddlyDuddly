<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\HomeCategoryGroup;
use App\Models\MasterCategory;
use App\Services\CategoryTreeService;

class LandingController extends Controller
{
    public function home()
    {
        $departments = CategoryTreeService::build();
        $masterCategories = MasterCategory::where('status', 1)->get();
        $homeCategoryGroups = HomeCategoryGroup::where('status', 1)
            ->orderBy('display_order')
            ->get();

        // dd($departments, $masterCategories, $homeCategoryGroups);
        return view('website/index', compact('departments', 'masterCategories', 'homeCategoryGroups'));
    }

}
