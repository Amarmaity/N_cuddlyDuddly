@extends('admin.layouts.admin')

@section('title', 'Reviews')

@push('styles')
    <style>
        /* ---------- Table & Layout ---------- */
        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table tbody tr:hover {
            background-color: #f3f6fb;
            transition: 0.2s;
        }

        .customer-img,
        .review-img {
            object-fit: cover;
            border-radius: 6px;
        }

        .rating-badge {
            font-weight: 600;
            border-radius: 6px;
        }

        .compact-filters {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: .7rem 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .compact-filters select,
        .compact-filters input {
            border-radius: 8px;
            font-size: 0.9rem;
        }

        /* ---------- Modal Styling ---------- */
        .modal-header {
            background: linear-gradient(90deg, #0d6efd, #6610f2);
            color: #fff;
        }

        .review-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .review-card .product-section {
            background: linear-gradient(135deg, #f3f7ff, #ffffff);
            border-bottom: 1px solid #e9ecef;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .review-card .product-img {
            width: 90px;
            height: 90px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        .star {
            color: #ffc107;
            font-size: 1rem;
        }

        .review-card .customer-section {
            padding: 1.2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .customer-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #dee2e6;
        }

        .review-text {
            margin-top: .8rem;
            font-size: .95rem;
            line-height: 1.5;
        }

        .review-meta {
            padding: .8rem 1.2rem;
            background: #f1f3f5;
            border-top: 1px solid #e9ecef;
            font-size: .85rem;
            color: #6c757d;
            display: flex;
            justify-content: space-between;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-3">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0"><i class="bi bi-star me-2 text-warning"></i> Customer Reviews</h2>
            @canAccess('admin.reviews.create')
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add Review
            </a>
            @endcanAccess
        </div>

        @canAccess('admin.reviews.filter')
        <form method="GET" action="{{ route('admin.reviews.index') }}"
            class="compact-filters d-flex flex-wrap align-items-center gap-2">
            <div class="flex-grow-1">
                <input type="text" name="product" value="{{ request('product') }}" class="form-control"
                    placeholder="🔍 Search product name...">
            </div>
            <select name="rating" class="form-select w-auto">
                <option value="">All Ratings</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }}
                        Stars</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-dark"><i class="bi bi-funnel me-1"></i> Filter</button>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Reset</a>
        </form>
        @endcanAccess
        <!-- Reviews Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">

                <div class="p-3 d-flex justify-content-between align-items-center">
                    @canAccess('admin.reviews.deleteselected')
                    <button type="button" id="deleteSelectedBtn" class="btn btn-danger btn-sm" disabled>
                        <i class="bi bi-trash me-1"></i> Delete Selected
                    </button>
                    @endcanAccess
                    <div class="text-muted small">
                        Showing {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} of {{ $reviews->total() }} reviews
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                <tr data-id="{{ $review->id }}">
                                    <td><input type="checkbox" name="selected[]" value="{{ $review->id }}"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="d-flex align-items-center">
                                        <img src="{{ $review->customer->profile_image
                                            ? asset('storage/' . $review->customer->profile_image)
                                            : asset('storage/images/default-avatar.png') }}"
                                            width="40" height="40" class="me-2 customer-img" alt="Customer">
                                        <div>
                                            <strong>{{ $review->customer->first_name }}
                                                {{ $review->customer->last_name }}</strong>
                                            <div class="text-muted small">{{ $review->customer->phone ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $review->customer->email }}</td>
                                    <td>{{ $review->product->name ?? '-' }}</td>
                                    <td>
                                        <img src="{{ $review->product && $review->product->primaryImage
                                            ? asset('storage/' . $review->product->primaryImage->image_path)
                                            : asset('images/no-image.png') }}"
                                            width="50" height="50" class="review-img" alt="Product">
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark rating-badge">
                                            {{ $review->rating }} <i class="bi bi-star-fill"></i>
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($review->comment, 40) ?? '-' }}</td>
                                    <td>{{ $review->created_at->format('d M Y') }}</td>
                                    <td class="text-end">
                                        @canAccess('admin.reviews.show')
                                        <button class="btn btn-outline-info btn-sm viewReviewBtn"
                                            data-review='@json($review)'>
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        @endcanAccess
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="bi bi-exclamation-circle me-2"></i> No reviews found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end align-items-center p-3 border-top">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- ---------- Modal: Rich Review Details ---------- -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content review-card">
                <div class="product-section">
                    <img id="modalProductImage" src="/images/no-image.png" class="product-img" alt="Product">
                    <div class="product-info">
                        <h5 id="modalProductName">Product Name</h5>
                        <div id="modalStars" class="mb-1"></div>
                        <p class="text-muted small mb-0" id="modalReviewDate"></p>
                    </div>
                </div>
                <div class="customer-section">
                    <img id="modalCustomerAvatar" src="/storage/images/default-avatar.png" class="customer-avatar"
                        alt="Customer">
                    <div class="customer-info">
                        <h6 id="modalCustomerName"></h6>
                        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                        <div class="review-text mt-2" id="modalComment"></div>
                    </div>
                </div>
                <div class="review-meta">
                    <span><i class="bi bi-calendar"></i> <span id="modalCreatedAt"></span></span>
                    <span><i class="bi bi-star-fill text-warning"></i> <span id="modalRatingValue"></span></span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrf = '{{ csrf_token() }}';
            const selectAll = document.querySelector('#selectAll');
            const deleteBtn = document.querySelector('#deleteSelectedBtn');
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');

            const updateButton = () => deleteBtn.disabled = ![...checkboxes].some(cb => cb.checked);
            selectAll?.addEventListener('change', e => {
                checkboxes.forEach(cb => cb.checked = e.target.checked);
                updateButton();
            });
            checkboxes.forEach(cb => cb.addEventListener('change', updateButton));

            deleteBtn?.addEventListener('click', async () => {
                const ids = [...checkboxes].filter(cb => cb.checked).map(cb => cb.value);
                if (!ids.length || !confirm(`Delete ${ids.length} review(s)?`)) return;
                const res = await fetch("{{ route('admin.reviews.bulkDelete') }}", {
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
                if (data.success) {
                    ids.forEach(id => document.querySelector(`tr[data-id="${id}"]`)?.remove());
                    deleteBtn.disabled = true;
                } else alert(data.message || 'Failed to delete reviews.');
            });

            // View modal with stars
            document.querySelectorAll('.viewReviewBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const r = JSON.parse(btn.dataset.review);
                    const stars = document.getElementById('modalStars');
                    stars.innerHTML = '';
                    for (let i = 1; i <= 5; i++) {
                        stars.innerHTML +=
                            `<i class="bi ${i <= r.rating ? 'bi-star-fill star' : 'bi-star text-muted'}"></i>`;
                    }
                    document.getElementById('modalProductImage').src = r.product?.primary_image
                        ?.image_path ?
                        `/storage/${r.product.primary_image.image_path}` :
                        '/images/no-image.png';
                    document.getElementById('modalProductName').innerText = r.product?.name || '-';
                    document.getElementById('modalReviewDate').innerText = new Date(r.created_at)
                        .toLocaleString();
                    document.getElementById('modalCustomerAvatar').src = r.customer?.profile_image ?
                        `/storage/${r.customer.profile_image}` :
                        '/storage/images/default-avatar.png';
                    document.getElementById('modalCustomerName').innerText =
                        `${r.customer.first_name} ${r.customer.last_name}`;
                    document.getElementById('modalEmail').innerText = r.customer.email;
                    document.getElementById('modalPhone').innerText = r.customer.phone || '-';
                    document.getElementById('modalComment').innerText = r.comment || '-';
                    document.getElementById('modalCreatedAt').innerText = new Date(r.created_at)
                        .toLocaleDateString();
                    document.getElementById('modalRatingValue').innerText = `${r.rating}/5`;
                    new bootstrap.Modal(document.getElementById('reviewModal')).show();
                });
            });
        });
    </script>
@endpush
