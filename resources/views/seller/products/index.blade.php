@extends('seller.layouts.seller')

@section('title', 'My Products')

@section('content')

    <div class="flex-[unset] sm:flex-1">
        @include('seller.layouts.header')
        <div class="w-full flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-10">
            <div>
                <h3 class="font-sans font-normal text-3xl sm:text-[40px] leading-tight tracking-1 text-black">
                    @php $seller = Auth::guard('seller')->user(); @endphp
                    @if ($seller)
                        <span class="me-3">Welcome! {{ $seller->name }}</span>
                    @endif
                </h3>
                <p class="font-sans font-normal text-lg leading-tight tracking-1 text-black">
                    Let's get your store moving!
                </p>
            </div>
            @if ($seller)
                <a
                    href="{{ route('seller.add.products', $seller->id) }}"
                    class="inline-flex items-center justify-center w-[145px] h-[45px] sm:w-[180px] sm:h-[62px]
                        rounded-[10px] bg-[#1C1C1C] border border-black/20
                        self-start mt-3 md:mt-0 md:self-end
                        font-sans font-medium text-base tracking-1 text-white">
                    Add Products
                </a>
            @endif
        </div>
        <div class="w-full mt-4 px-6 md:pl-14 md:pr-9">
            <div class="container w-full max-w-full">
                <div class="dashboard-card w-full bg-white p-0">
                    <div class="flex-box p-5 justify-between border-b border-black/20">
                        <h6 class="dashboard-title m-0">My Products</h6>
                        <div class="flex flex-wrap gap-4">
                             <div class="flex items-center gap-3 w-[376px] h-[46px] border rounded-[5px] border-black/20 rounded-md px-4">
                            <img 
                                src="http://127.0.0.1:8000/storage/images/dahboard-search.png"
                                alt=""
                                class="w-5 h-5 object-contain"
                            >
                            <input
                                type="text"
                                placeholder="Search"
                                class="w-full bg-transparent outline-none font-sans text-sm placeholder:text-black/60"
                            >
                        </div>
                           <button type="button"
                            class="flex justify-center items-center gap-4 border w-[376px] h-[46px] border-black/20 rounded-[5px] px-2.5 py-2 cursor-pointer font-sans font-medium text-sm leading-tight tracking-1 text-silver"><img
                                src="{{asset('storage/images/dashboard-filter.png')}}" alt=""
                                class="max-w-3"><span>Filter</span></button></div>
                    </div>
                    <div class="overflow-x-auto w-full p-0">
                        <table class="table-auto w-full sm:w-full seller-table">
                            <thead>
                                <tr class="border-b border-black/20">
                                    <th class="pl-5">Serial No</th>
                                    {{-- <th>Seller Id</th> --}}
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection