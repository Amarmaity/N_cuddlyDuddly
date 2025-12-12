<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Products;
use App\Models\Sellers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerDashboardController extends Controller
{
    /**
     * Display the seller dashboard.
     */
    public function index(Request $request)
    {
        // Logged-in Seller
        $seller = Auth::guard('seller')->user();

        $totalProducts = Products::where('seller_id', $seller->id)->count();

        $totalOrders = OrderItem::whereHas('product', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->count();

        $totalEarning = OrderItem::whereHas('product', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })->sum('price');

        return view('seller.dashboard', compact(
            'seller',
            'totalProducts',
            'totalOrders',
            'totalEarning'
        ));
    }

    //  public function test2()
    // {
    //     // You can later add seller stats, payouts summary, etc.
    //     return view('seller.test');
    // }
}
