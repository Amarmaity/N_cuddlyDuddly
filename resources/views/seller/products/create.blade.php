@extends('seller.layouts.seller')

@section('title', 'Add New Product')

@section('content')

    <div class="flex-[unset] sm:flex-1">
        @include('seller.layouts.header')
        <div class="w-full flex gap-6 flex-col justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-10 ">
            <div class="flex items-center gap-6 ">
                <a href="#" class=" flex items-center justify-center bg-black rounded-[50%]">
                    <img class="!w-[10px] !h-[10px]" src="{{asset('storage/images/Frame.svg')}}" alt="">
                </a>
                <div>
                    <h3 class="font-sans font-normal text-3xl sm:text-[40px] leading-tight tracking-1 text-black">
                        @php $seller = Auth::guard('seller')->user(); @endphp
                        @if ($seller)
                            <span class="me-3 w-[765px] h-[87px]">Add new products</span>
                        @endif
                    </h3>
                    <p class="font-sans font-normal text-lg leading-tight tracking-1 text-black">
                        Fill in the details below to list your product on CuddlyDuddly
                    </p>
                </div>
            </div>


            <div class="bg-white rounded-lg border border-black/10 overflow-hidden
                        max-w-[1201px] h-[1221px] w-full mx-auto self-start">
                <!-- SECTION: Basic Information -->
                <div class="border-b border-black/10">
                    <button class="accordion-toggle w-full flex justify-between items-center px-6 py-4 bg-gray-50">
                        <h4 class="font-sans text-lg font-medium text-black">Basic Information</h4>
                        <svg class="accordion-icon w-5 h-5 text-black" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Basic Information -->
                    <div class="px-6 py-6 space-y-6">
                        <!-- Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-black mb-1">
                                    Product Name<span class="text-red-500">*</span>
                                </label>
                                <input type="text" placeholder="e.g. Organic baby blanket"
                                    class="w-full border border-black/20 rounded px-4 py-2 outline-none focus:border-black">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-black mb-1">
                                    Category<span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full border border-black/20 rounded px-4 py-2 outline-none focus:border-black">
                                    <option>Select category</option>
                                </select>
                            </div>
                        </div>
                        <!-- Short Description -->
                        <div>
                            <label class="block text-sm font-medium text-black mb-1">
                                Short Description<span class="text-red-500">*</span>
                            </label>
                            <textarea rows="4" placeholder="Brief description shown under products"
                                class="w-full border border-black/20 rounded px-4 py-2 outline-none focus:border-black"></textarea>
                            <p class="text-xs text-black/50 text-right mt-1">0/100</p>
                        </div>

                    </div>
                </div>

                <!-- SECTION: Pricing & Inventory -->
                <div class="border-b border-black/10">
                    <button class="accordion-toggle w-full flex justify-between items-center px-6 py-4 bg-gray-50">
                        <h4 class="font-sans text-lg font-medium text-black">Pricing & Inventory</h4>
                        <svg class="accordion-icon w-5 h-5 text-black" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="px-6 py-6 hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-[1095px] w-[115px]">
                            <!-- pricing fields -->
                            <div>
                                <label class="block text-sm font-medium text-black mb-1">
                                    Price<span class="text-red-500">*</span>
                                </label>
                                <input type="text" placeholder="0.0"
                                    class="w-full border border-black/20 rounded px-4 py-2 outline-none focus:border-black">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-black mb-1">
                                    Stock Quantity<span class="text-red-500">*</span>
                                </label>
                                <input type="text" placeholder="Enter avaliable units"
                                    class="w-full border border-black/20 rounded px-4 py-2 outline-none focus:border-black">
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <label class="text-sm font-medium text-black">
                                        SKU/Product ID<span class="text-red-500">*</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer">
                                        <div class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                                <input type="text" placeholder="Enter"
                                    class="w-full border border-black/20 rounded px-4 py-2 outline-none focus:border-black">
                            </div>
                        </div>
                    </div>
                </div>

                <!--Product images & Description -->
                <div class="border-b border-black/10">
                    <button class="accordion-toggle w-full flex justify-between items-center px-6 py-4 bg-gray-50">
                        <h4 class="font-sans text-lg font-medium text-black">Product images & Description</h4>
                        <svg class="accordion-icon w-5 h-5 text-black" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="px-6 py-6 hidden">
                        <!-- Media Upload -->
                        <div class="mb-8">
                            <label class="block text-lg font-medium text-black mb-1">
                                Media Upload
                            </label>
                            <p class="text-xs text-black/50 mb-4">Add your documents here, and you can upload up to 5 files max</p>
                            
                            <div class="border-2 border-dashed border-gray-200 rounded-lg p-12 flex flex-col items-center justify-center text-center hover:bg-gray-50 transition-colors cursor-pointer relative">
                                <input type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                <div class="mb-4">
                                    <svg class="w-12 h-12 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-black mb-1">
                                    Drag your file(s) or <span class="text-red-500">browse</span>
                                </p>
                                <p class="text-xs text-gray-500">
                                    Max 20 MB files are allowed
                                </p>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label class="block text-lg font-medium text-black mb-4">
                                Product Description
                            </label>
                            <textarea rows="6" placeholder="Enter product description that is to be placed at the top"
                                class="w-full border border-black/20 rounded-lg px-4 py-3 outline-none focus:border-black resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION: Safety & Compliance -->
                <div class="border-b border-black/10">
                    <button class="accordion-toggle w-full flex justify-between items-center px-6 py-4 bg-gray-50">
                        <h4 class="font-sans text-lg font-medium text-black">Safety & Compliance</h4>
                        <svg class="accordion-icon w-5 h-5 text-black" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="px-6 py-6 hidden"></div>
                </div>

                <!-- SECTION: Shipping Info -->
                <div class="border-b border-black/10">
                    <button class="accordion-toggle w-full flex justify-between items-center px-6 py-4 bg-gray-50">
                        <h4 class="font-sans text-lg font-medium text-black">Shipping Info</h4>
                        <svg class="accordion-icon w-5 h-5 text-black" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="px-6 py-6 hidden"></div>
                </div>

            </div>
        </div>

    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.accordion-toggle').forEach(button => {
                button.addEventListener('click', function () {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.accordion-icon');

                    content.classList.toggle('hidden');
                    icon.classList.toggle('rotate-180');
                });
            });
        });
    </script>
@endpush