<?php

namespace App\Http\Controllers\website;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        // Fetch all departments (customize query if needed, e.g. only active ones)
        $departments = Department::where('status', 1)->get();

        // Pass departments to view (e.g. resources/views/departments/index.blade.php)
        return view('index', compact('departments'));
    }
}
