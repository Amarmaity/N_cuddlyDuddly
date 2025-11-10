<header>
    <button class="btn btn-outline-dark d-md-none" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>
    <h5 class="m-0">Seller Dashboard</h5>

    <div>
        @php $seller = Auth::guard('seller')->user(); @endphp
        @if ($seller)
            <span class="me-3">Hello👋, {{ $seller->name }}</span>
        @endif

        <form method="POST" action="{{ route('seller.logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</header>
