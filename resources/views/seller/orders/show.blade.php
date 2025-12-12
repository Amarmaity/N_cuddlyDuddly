@extends('seller.layouts.seller')

@section('title', 'Order Details')

@section('content')
    @php
        // Calculate seller-only totals
        $sellerSubtotal = $sellerItems->reduce(function ($carry, $item) {
            return $carry + $item->quantity * $item->price;
        }, 0);

        $sellerItemCount = $sellerItems->sum('quantity');
    @endphp

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Order #{{ $order->order_number }}</h5>
            <span class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : 'info' }}">
                {{ ucfirst($order->order_status) }}
            </span>
        </div>

        <div class="card-body">
            <h6 class="fw-bold mb-3"><i class="bi bi-person-circle me-2"></i>Customer Information</h6>
            <p class="mb-1"><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $order->shippingAddress->full_address ?? 'N/A' }}</p>

            <hr>

            <h6 class="fw-bold mb-3"><i class="bi bi-box-seam me-2"></i>Your Products in This Order</h6>
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sellerItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₹{{ number_format($item->price, 2) }}</td>
                                <td>₹{{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No items found for you in this order.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1"><strong>Payment Status (order):</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p class="mb-1"><strong>Payment Method (order):</strong> {{ ucfirst($order->payment_method) }}</p>
                </div>

                <div class="text-end">
                    <p class="mb-1"><strong>Your items:</strong> {{ $sellerItemCount }}</p>
                    <p class="fw-bold mb-1">Your Subtotal: ₹{{ number_format($sellerSubtotal, 2) }}</p>
                    <p class="small text-muted">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Back to Orders
    </a>
@endsection
