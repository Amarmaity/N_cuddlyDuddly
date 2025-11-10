<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerDashboardController extends Controller
{
    /**
     * Display the seller dashboard.
     */
    public function index()
    {
        // You can later add seller stats, payouts summary, etc.
        return view('seller.dashboard');
    }
}
