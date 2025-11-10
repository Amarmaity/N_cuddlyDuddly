@extends('admin.layouts.admin')
@section('title', 'Wishlists')

@push('styles')
    <style>
        :root {
            --card-bg: #fff;
            --border: #e5e7eb;
            --shadow: 0 2px 8px rgba(0, 0, 0, .05);
            --primary: #0d6efd;
            --danger: #dc3545;
        }

        .compact-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .matrix {
            width: 100%;
            border-collapse: collapse;
        }

        .matrix th {
            background: #f8f9fa;
            font-size: .8rem;
            text-transform: uppercase;
            padding: .6rem;
        }

        .matrix td {
            padding: .5rem .6rem;
            vertical-align: middle;
            border-top: 1px solid var(--border);
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .products-cell {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .thumb {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            transition: transform 0.2s ease;
        }

        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #f1f1f1;
        }

        .thumb:hover {
            transform: scale(1.05);
        }

        .thumb .remove {
            position: absolute;
            inset: 0;
            background: rgba(220, 53, 69, 0.75);
            color: #fff;
            border: none;
            opacity: 0;
            transition: opacity 0.2s;
            border-radius: 50%;
            font-size: .7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumb:hover .remove {
            opacity: 1;
            cursor: pointer;
        }

        .count-badge {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
            border-radius: 30px;
            padding: 3px 10px;
            font-size: .75rem;
            font-weight: 600;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .searchbar {
            display: flex;
            gap: .5rem;
            margin-bottom: 1rem;
        }

        .searchbar input {
            flex: 1;
            border-radius: 8px;
            font-size: .9rem;
        }

        .table-wrapper {
            background: var(--card-bg);
            border-radius: 10px;
            box-shadow: var(--shadow);
        }

        .text-center-middle {
            text-align: center;
            vertical-align: middle !important;
        }

        /* Modal */
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: var(--primary);
            color: #fff;
            border-bottom: none;
        }

        .modal-body table {
            font-size: .9rem;
        }

        .stock-badge {
            border-radius: 30px;
            padding: 2px 8px;
            font-size: .7rem;
            font-weight: 500;
        }

        .stock-in {
            background: #d1e7dd;
            color: #0f5132;
        }

        .stock-out {
            background: #f8d7da;
            color: #842029;
        }

        .product-thumb {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">

        <div class="compact-header">
            <h2 class="mb-0"><i class="bi bi-heart-fill text-danger me-2"></i> Wishlists</h2>
            <span class="text-muted small">Total wishlist items: <strong>{{ $total }}</strong></span>
        </div>
        @canAccess('admin.wishlists.filter')
        <form method="GET" action="{{ route('admin.wishlists.index') }}" class="searchbar">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="🔍 Search customer or product...">
            <button class="btn btn-dark"><i class="bi bi-search"></i> Search</button>
            <a href="{{ route('admin.wishlists.index') }}" class="btn btn-outline-secondary">Reset</a>
        </form>
        @endcanAccess
        <div class="table-wrapper">
            <table class="matrix table align-middle">
                <thead>
                    <tr>
                        <th style="width:3%">#</th>
                        <th style="width:20%">Customer</th>
                        <th class="text-center-middle">Wishlist Products</th>
                        <th style="width:8%" class="text-center-middle">Count</th>
                        <th style="width:10%" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wishlists as $userId => $items)
                        @php $user = $items->first()->user; @endphp
                        <tr data-user="{{ $userId }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-cell">
                                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('storage/images/default-avatar.png') }}"
                                        class="avatar" alt="avatar">
                                    <div>
                                        <strong>{{ $user->first_name }} {{ $user->last_name }}</strong><br>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>
                            </td>

                            <td class="text-center-middle">
                                <div class="products-cell">
                                    @foreach ($items as $wishlist)
                                        <div class="thumb" data-name="{{ $wishlist->product->name ?? '' }}">
                                            <button class="remove" data-id="{{ $wishlist->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            <img src="{{ $wishlist->product && $wishlist->product->primaryImage
                                                ? asset('storage/' . $wishlist->product->primaryImage->image_path)
                                                : asset('images/no-image.png') }}"
                                                alt="product">
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <td class="text-center-middle">
                                <span class="count-badge">
                                    <i class="bi bi-heart"></i> {{ $items->count() }}
                                </span>
                            </td>

                            <td class="text-end">
                                @canAccess('admin.wishlists.show')
                                <button class="btn btn-outline-primary btn-sm viewDetails" data-user="{{ $userId }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @endcanAccess
                                @canAccess('admin.wishlists.delete')
                                <button class="btn btn-outline-danger btn-sm deleteAll" data-user="{{ $userId }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endcanAccess
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-heartbreak me-2"></i> No wishlist data found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-person-heart me-2"></i> Customer Wishlist</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="wishlistDetails" class="table-responsive">
                        <div class="text-center py-4 text-muted">Loading wishlist...</div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a id="fullPageLink" href="#" target="_blank" class="btn btn-outline-secondary">
                        <i class="bi bi-box-arrow-up-right"></i> Open Full Page
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrf = '{{ csrf_token() }}';
            const modal = new bootstrap.Modal(document.getElementById('wishlistModal'));
            const detailsContainer = document.getElementById('wishlistDetails');
            const fullPageLink = document.getElementById('fullPageLink');

            // 🗑️ Remove single wishlist product
            document.querySelectorAll('.remove').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const id = btn.dataset.id;
                    const card = btn.closest('.thumb');
                    if (!confirm('Remove this product from wishlist?')) return;

                    const res = await fetch(`/admin/wishlists/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf
                        }
                    });
                    const data = await res.json();
                    if (data.success) card.remove();
                });
            });

            // 🧹 Delete all wishlist items of a user
            document.querySelectorAll('.deleteAll').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const row = btn.closest('tr');
                    const userId = btn.dataset.user;
                    if (!confirm('Delete all wishlist items for this user?')) return;

                    const ids = [...row.querySelectorAll('.remove')].map(b => b.dataset.id);
                    const res = await fetch("{{ route('admin.wishlists.bulkDelete') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ids
                        })
                    });
                    const data = await res.json();
                    if (data.success) row.remove();
                });
            });

            // 👁️ View wishlist details in modal
            document.querySelectorAll('.viewDetails').forEach(btn => {
                btn.addEventListener('click', async () => {
                    const userId = btn.dataset.user;
                    detailsContainer.innerHTML =
                        `<div class="text-center py-4 text-muted">Loading wishlist...</div>`;
                    fullPageLink.href = `/admin/wishlists/${userId}`;
                    modal.show();

                    const res = await fetch(`/admin/wishlists/${userId}`, {
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json();

                    if (!data.success || !data.wishlist.length) {
                        detailsContainer.innerHTML =
                            `<div class="text-center py-4 text-muted"><i class="bi bi-heartbreak me-2"></i>No wishlist items found for this customer.</div>`;
                        return;
                    }

                    let html = `
              <table class="table table-hover align-middle">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Date Added</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>`;

                    data.wishlist.forEach((item, i) => {
                        html += `
                  <tr>
                    <td>${i + 1}</td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img src="${item.image}" class="product-thumb" alt="Product">
                        <span>${item.name}</span>
                      </div>
                    </td>
                    <td>₹${item.price}</td>
                    <td>
                      <span class="stock-badge ${item.in_stock ? 'stock-in' : 'stock-out'}">
                        ${item.in_stock ? 'In Stock' : 'Out of Stock'}
                      </span>
                    </td>
                    <td>${item.date}</td>
                    <td class="text-end">
                      <button class="btn btn-outline-danger btn-sm removeWishlist" data-id="${item.id}">
                        <i class="bi bi-trash"></i>
                      </button>
                    </td>
                  </tr>`;
                    });

                    html += `</tbody></table>`;
                    detailsContainer.innerHTML = html;
                });
            });
        });
    </script>
@endpush
