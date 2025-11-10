@extends('admin.layouts.admin')

@section('title', 'Manage Categories')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/categories-index.css') }}">
@endpush

@section('content')
<div class="container-fluid py-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h4 mb-0">Manage Categories</h2>
    </div>

    @if ($masterCategories->isEmpty())
        <div class="alert alert-info">No master categories found.</div>
    @else
        {{-- Group Master Categories by the first Department --}}
        @foreach ($masterCategories->groupBy(fn($mc) => optional($mc->departments->first())->name ?? 'No Department') as $departmentName => $categories)
            <div class="mb-4">
                <h5 class="fw-bold border-bottom pb-2 text-primary">{{ $departmentName }}</h5>

                <ul class="category-tree">
                    @foreach ($categories as $masterCategory)
                        <li class="tree-item">
                            <div class="item-content level-0">
                                <i class="bi bi-chevron-right tree-toggler
                                    @if (optional($masterCategory->sectionTypes)->isEmpty()) invisible @endif"
                                    aria-expanded="false"></i>

                                {{-- Master Category Image --}}
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

                                {{-- Master Category Name --}}
                                <span class="item-name">{{ $masterCategory->name }}</span>
                            </div>

                            {{-- Section Types --}}
                            @if ($masterCategory->sectionTypes->isNotEmpty())
                                <ul class="nested">
                                    @foreach ($masterCategory->sectionTypes as $sectionType)
                                        <li class="tree-item @if ($sectionType->categories->isNotEmpty()) no-bottom-border @endif">
                                            <div class="item-content level-1">
                                                <i class="bi bi-chevron-right tree-toggler
                                                    @if ($sectionType->categories->isEmpty()) invisible @endif"
                                                    aria-expanded="false"></i>
                                                <span class="item-name">{{ $sectionType->name }}</span>
                                            </div>

                                            {{-- Categories --}}
                                            @if ($sectionType->categories->isNotEmpty())
                                                <div class="nested category-grid-container">
                                                    <div class="row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xl-5 g-2">
                                                        @foreach ($sectionType->categories as $category)
                                                        @dd($category)
                                                            <div class="col">
                                                                <div class="card category-card h-100">
                                                                    <div class="image-wrapper" data-id="{{ $category->id }}" data-type="category">
                                                                        {{-- <img src="{{ $category->image_url ? asset('storage/' . $category->image_url) : asset('images/placeholder.png') }}"
                                                                             class="preview-{{ $category->id }}"
                                                                             alt="{{ $category->name }}"> --}}
                                                                        <div class="image-overlay">
                                                                            <i class="bi bi-pencil-fill"></i>
                                                                            <input type="file" class="image-input"
                                                                                   data-id="{{ $category->id }}"
                                                                                   data-type="category"
                                                                                   accept="image/*">
                                                                        </div>
                                                                        <div class="upload-progress" id="progress-{{ $category->id }}">0%</div>
                                                                    </div>

                                                                    <div class="card-body">
                                                                        <h6 class="card-title">{{ $category->name }}</h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
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

<div class="card-footer">
    {{ $masterCategories->links('pagination::bootstrap-5') }}
</div>
@endsection

@push('scripts')
<script>
    window.appRoutes = {
        uploadImage: "{{ route('admin.categories.uploadImage') }}"
    };
</script>
<script src="{{ asset('js/categories-index.js') }}" defer></script>
@endpush
