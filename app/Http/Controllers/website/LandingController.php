<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Services\CategoryTreeService;

class LandingController extends Controller
{
    public function home()
    {
        $departments = CategoryTreeService::build();

        // dd($departments);
        return view('website/index', compact('departments'));

    }
}
