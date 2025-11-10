@php
    use Illuminate\Support\Facades\Auth;
    $seller = Auth::guard('seller')->user();
@endphp

<div class="sidebar">
    <div class="sidebar-header d-flex align-items-center p-3 border-bottom">
        <img src="{{ asset('logo/cuddlyduddly_logo.png') }}" alt="Logo" style="height: 32px;" class="me-2">
        <h4 class="m-0">Seller Panel</h4>
    </div>

    <a href="{{ route('seller.dashboard') }}" class="{{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('seller.products.index') }}"
        class="{{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
        <i class="bi bi-box"></i> My Products
    </a>

    <a href="{{ route('seller.orders.index') }}" class="{{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
        <i class="bi bi-cart-check"></i> My Orders
    </a>

    <a href="{{ route('seller.payouts.index') }}" class="{{ request()->routeIs('seller.payouts.*') ? 'active' : '' }}">
        <i class="bi bi-wallet2"></i> Payouts
    </a>

    <a href="{{ route('seller.support.index') }}" class="{{ request()->routeIs('seller.support.*') ? 'active' : '' }}">
        <i class="bi bi-headset"></i> Support
    </a>

    <a href="{{ route('seller.profile') }}" class="{{ request()->routeIs('seller.profile') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Profile
    </a>
</div>
