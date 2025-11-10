<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class SellerOrderController extends Controller
{
    public function index(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        // Only orders that include this seller’s products
        $query = Order::with(['user', 'shippingAddress', 'items.product'])
            ->whereHas('items.product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            });

        // 🔍 Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // 💳 Payment Status
        if ($paymentStatus = $request->input('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }

        // 🚚 Order Status
        if ($orderStatus = $request->input('order_status')) {
            $query->where('order_status', $orderStatus);
        }

        // 🕓 Sorting
        switch ($request->input('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'amount_high_low':
                $query->orderBy('total_amount', 'desc');
                break;
            case 'amount_low_high':
                $query->orderBy('total_amount', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('seller.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $seller = Auth::guard('seller')->user();

        // Load order only if it includes this seller’s products
        $order = Order::with(['user', 'shippingAddress', 'items.product'])
            ->whereHas('items.product', function ($q) use ($seller) {
                $q->where('seller_id', $seller->id);
            })
            ->findOrFail($id);

        // Filter only this seller’s items for display
        $sellerItems = $order->items->filter(function ($item) use ($seller) {
            return $item->product->seller_id == $seller->id;
        });

        return view('seller.orders.show', compact('order', 'sellerItems'));
    }

    public function update(Request $request, $id)
    {
        $seller = Auth::guard('seller')->user();
        $order = Order::where('seller_id', $seller->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|string',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('seller.orders.index')->with('success', 'Order updated successfully.');
    }
}
