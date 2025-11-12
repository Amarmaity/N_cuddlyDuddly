@extends('admin.layouts.admin')

@section('title', 'Manage Categories')

@push('styles')
<style>
.tree-container {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
}

.item-content {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}

.item-content:hover {
    background: #f2f4f7;
}

.item-name {
    font-weight: 500;
    color: #333;
}

.level-0 .item-name { font-size: 1.1rem; font-weight: 600; }
.level-1 .item-name { margin-left: 10px; }
.level-2 .item-name { margin-left: 20px; }
.level-3 .item-name { margin-left: 30px; }

.image-wrapper {
    position: relative;
    width: 40px;
    height: 40px;
    border-radius: 6px;
    overflow: hidden;
    margin-right: 10px;
    flex-shrink: 0;
}

.image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
}

.image-wrapper:hover .image-overlay {
    opacity: 1;
}

.image-input {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
}

.upload-progress {
    font-size: 10px;
    color: #007bff;
    margin-top: 3px;
    text-align: center;
}

.nested {
    display: none;
    margin-left: 20px;
}

.nested.active {
    display: block;
}

.bi-chevron-right,
.bi-chevron-down {
    font-size: 0.9rem;
    color: #777;
}
</style>
@endpush

@section('content')
<div class="container-fluid py-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Manage Categories</h2>
    </div>

    @if ($masterCategories->isEmpty())
        <div class="alert alert-info">No master categories found.</div>
    @else
        {{-- Group Master Categories by Department --}}
        @foreach ($masterCategories->groupBy(fn($mc) => optional($mc->departments->first())->name ?? 'No Department') as $departmentName => $categories)
            <div class="mb-4 tree-container">
                <h5 class="fw-bold border-bottom pb-2 text-primary">{{ $departmentName }}</h5>

                <ul class="category-tree list-unstyled">
                    @foreach ($categories as $masterCategory)
                        <li class="tree-item">
                            {{-- Master Category --}}
                            <div class="item-content level-0">
                                <i class="bi bi-chevron-right tree-toggler
                                    @if (optional($masterCategory->sectionTypes)->isEmpty()) invisible @endif"
                                    aria-expanded="false"></i>

                                {{-- Master Category Image Upload --}}
                                <div class="image-wrapper" data-id="{{ $masterCategory->id }}" data-type="master">
                                    <img src="{{ $masterCategory->image_url ? asset('storage/' . $masterCategory->image_url) : asset('images/placeholder.png') }}"
                                         class="preview-{{ $masterCategory->id }}" alt="{{ $masterCategory->name }}">
                                    <div class="image-overlay">
                                        <i class="bi bi-pencil-fill"></i>
                                        <input type="file" class="image-input"
                                               data-id="{{ $masterCategory->id }}"
                                               data-type="master"
                                               accept="image/*">
                                    </div>
                                    <div class="upload-progress" id="progress-{{ $masterCategory->id }}">0%</div>
                                </div>

                                <span class="item-name">{{ $masterCategory->name }}</span>
                            </div>

                            {{-- Section Types --}}
                            @if ($masterCategory->sectionTypes->isNotEmpty())
                                <ul class="nested list-unstyled">
                                    @foreach ($masterCategory->sectionTypes as $sectionType)
                                        <li class="tree-item">
                                            <div class="item-content level-1">
                                                <i class="bi bi-chevron-right tree-toggler
                                                    @if ($sectionType->categories->isEmpty()) invisible @endif"
                                                    aria-expanded="false"></i>
                                                <span class="item-name">{{ $sectionType->name }}</span>
                                            </div>

                                            {{-- Categories --}}
                                            @if ($sectionType->categories->isNotEmpty())
                                                <ul class="nested list-unstyled">
                                                    @foreach ($sectionType->categories as $category)
                                                        <li class="tree-item">
                                                            <div class="item-content level-2">
                                                                <i class="bi bi-chevron-right tree-toggler invisible"></i>
                                                                <span class="item-name">{{ $category->name }}</span>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif
</div>

{{-- Pagination --}}
<div class="card-footer">
    {{ $masterCategories->links('pagination::bootstrap-5') }}
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Dropdown toggle
    document.querySelectorAll(".tree-toggler").forEach(toggle => {
        toggle.addEventListener("click", function () {
            const nested = this.closest('.item-content').nextElementSibling;
            if (nested) {
                nested.classList.toggle("active");
                this.classList.toggle("bi-chevron-down");
                this.classList.toggle("bi-chevron-right");
            }
        });
    });

    // Image upload (only for master categories)
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', async e => {
            const file = e.target.files[0];
            if (!file) return;
            const id = e.target.dataset.id;
            const type = e.target.dataset.type;
            const progress = document.getElementById(`progress-${id}`);
            const preview = document.querySelector(`.preview-${id}`);

            const formData = new FormData();
            formData.append('id', id);
            formData.append('type', type);
            formData.append('image', file);

            progress.textContent = 'Uploading...';

            try {
                const res = await fetch("{{ route('admin.categories.uploadImage') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                });

                const data = await res.json();
                if (data.success) {
                    preview.src = data.url;
                    progress.textContent = 'Done';
                } else {
                    progress.textContent = 'Failed';
                }
            } catch {
                progress.textContent = 'Error';
            }
        });
    });
});
</script>
@endpush
