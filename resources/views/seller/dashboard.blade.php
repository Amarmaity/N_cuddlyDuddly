@extends('seller.layouts.seller')
@section('title', 'Seller Dashboard')

@section('content')

    <div class="flex-[unset] sm:flex-1">
        @include('seller.layouts.header')
        <div class="w-full flex flex-col md:flex-row justify-between pt-6 px-6 md:pl-14 md:pr-9 pb-10">
            <div class="">
                <h3 class="font-sans font-normal text-3xl sm:text-[40px] leading-tight tracking-1 text-black">
                    @php $seller = Auth::guard('seller')->user(); @endphp
                    @if ($seller)
                        <span class="me-3">Hello, {{ $seller->contact_person }}</span>
                    @endif
                </h3>
                <p class="font-sans font-normal text-lg leading-tight tracking-1 text-black">Let's get your
                    store moving!</p>
            </div>
            <button
                class="w-[145px] h-[45px] sm:w-[180px] sm:h-[62px] rounded-[10px] bg-[#1C1C1C] border-[1.18px] self-start mt-3 md:mt-0 md:self-end border-black/20"><span
                    class="font-sans font-medium text-base leading-tight tracking-1 text-white">Add
                    Listing</span></button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 px-6 md:pl-14 md:pr-9 pb-4">
            <a href="#!" class="dashboard-card">
                <div class="flex justify-between items-center">
                    <span class="dashboard-icon"><img src="{{ asset('storage/images/dashboardicon2.png') }}" alt=""
                            class=""></span>
                    <span class="dashboard-link"><img src="{{ asset('storage/images/dashboardarrow.png') }}" alt=""
                            class=""></span>
                </div>
                <p class="dashboard-title">My products</p>
                <span class="dashboard-count">{{ $totalProducts }}</span>
                <p class="dashboard-detail">+2.5% than last month</p>

            </a>
            <a href="#!" class="dashboard-card bg-white">
                <div class="flex justify-between items-center">
                    <span class="dashboard-icon"><img src="{{ asset('storage/images/dashboardicon3.png') }}" alt=""
                            class=""></span>
                    <span class="dashboard-link"> <img src="{{ asset('storage/images/dashboardarrow.png') }}" alt=""
                            class=""></span>
                </div>
                <p class="dashboard-title">My orders</p>
                <span class="dashboard-count">{{$totalOrders}}</span>
                <p class="dashboard-detail">+3.5% than last month</p>

            </a>
            <a href="#!" class="dashboard-card bg-[#ECFBF2]">
                <div class="flex justify-between items-center">
                    <span class="dashboard-icon"><img src="{{asset('storage/images/dashboardicon3.png')}}" alt=""
                            class=""></span>
                    <span class="dashboard-link"><img src="{{asset('storage/images/dashboardarrow.png')}}" alt=""
                            class=""></span>
                </div>
                <p class="dashboard-title">My earnings</p>
                <span class="dashboard-count">{{$totalEarning}}</span>
                <p class="dashboard-detail">+3.5% than last month</p>

            </a>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 px-6 md:pl-14 md:pr-9">
            <div class="rounded-[10px] border border-black/20 bg-white">
                <div class="flex-box p-5 justify-between border-b border-black/20">
                    <span class="dashboard-title">Recent Transactions</span>
                    <button type="button" class="cursor-pointer"><img
                            src="{{asset('storage/images/dashboard-popup.png')}}" alt="" class="max-h-9"></button>
                </div>
                <ul class="dashboard-list overflow-x-scroll sm:overflow-x-hidden px-5 pt-5 pb-9">
                    <li class="flex justify-between items-center gap-x-4 sm:gap-x-10 md:gap-x-0">
                        <span class="dashboard-listicon">1</span>
                        <div>
                            <h6 class="dashboard-title m-0">Baby Blanket</h6>
                            <span class="order-detail">Order #1453,</span>
                        </div>
                        <span class="payment-details">Payment Received</span>
                        <span class="font-sans font-medium text-sm leading-tight tracking-1 text-black">+₹1,200</span>
                    </li>
                    <li class="flex justify-between items-center  gap-x-4 sm:gap-x-10 md:gap-x-0">
                        <span class="dashboard-listicon">2</span>
                        <div>
                            <h6 class="dashboard-title m-0">Baby Blanket</h6>
                            <span class="order-detail">Order #1453,</span>
                        </div>
                        <span class="payment-details">Payment Received</span>
                        <span class="font-sans font-medium text-sm leading-tight tracking-1 text-black">+₹1,200</span>
                    </li>
                    <li class="flex justify-between items-center  gap-x-4 sm:gap-x-10 md:gap-x-0">
                        <span class="dashboard-listicon">3</span>
                        <div>
                            <h6 class="dashboard-title m-0">Baby Blanket</h6>
                            <span class="order-detail">Order #1453,</span>
                        </div>
                        <span class="payment-details">Payment Received</span>
                        <span class="font-sans font-medium text-sm leading-tight tracking-1 text-black">+₹999</span>
                    </li>
                    <li class="flex justify-between items-center  gap-x-4 sm:gap-x-10 md:gap-x-0">
                        <span class="dashboard-listicon">4</span>
                        <div>
                            <h6 class="dashboard-title m-0">Baby Blanket</h6>
                            <span class="order-detail">Order #1453,</span>
                        </div>
                        <span class="payment-details">Payment Received</span>
                        <span class="font-sans font-medium text-sm leading-tight tracking-1 text-black">-</span>
                    </li>
                </ul>
            </div>
            <div class="rounded-[10px] border border-black/20 bg-white">
                <div class="flex-box p-5 justify-between border-b border-black/20">
                    <span class="dashboard-title">Revenue Summary</span>
                    <button type="button"
                        class="flex justify-center items-center gap-4 border border-black/20 rounded-[5px] px-2.5 py-2 cursor-pointer font-sans font-medium text-sm leading-tight tracking-1 text-silver"><img
                            src="{{ asset('storage/images/dashboard-filter.png') }}" alt=""
                            class="max-w-3"><span>Filter</span></button>
                </div>
                <div class="flex justify-start items-center px-5 pt-5 pb-9 gap-4">
                    <!-- Tab Buttons -->
                    <button class="tab-btn bg-white border-[1.18px] border-black/20 p-2 md:p-4 rounded-[5px]"
                        data-tab="tab1">Gross Revenue</button>
                    <button class="tab-btn bg-white border-[1.18px] border-black/20 p-2 md:p-4 rounded-[5px]"
                        data-tab="tab2">Gross Units Sold</button>
                    <button class="tab-btn bg-white border-[1.18px] border-black/20 p-2 md:p-4 rounded-[5px]"
                        data-tab="tab3">Return Units</button>
                </div>

                <!-- Content Div -->
                <div class="tab-content px-5 pb-2.5">
                    <div id="tab1" class="tab-item">
                        <canvas id="wavyChart" width="683" height="341"
                            style="display: block; box-sizing: border-box; height: 341.8px; width: 683px;"></canvas>

                    </div>
                    <div id="tab2" class="tab-item hidden">
                        <canvas id="myChart" height="0"
                            style="display: block; box-sizing: border-box; height: 0px; width: 0px;" width="0"></canvas>

                    </div>
                    <div id="tab3" class="tab-item hidden">Lorem ipsum dolor sit amet, consectetur
                        adipisicing
                        elit. Qui reiciendis, alias veritatis magnam sunt rerum doloribus molestias sequi illo
                        quibusdam a minus quos recusandae modi eligendi, aut id saepe nisi?</div>
                </div>

            </div>
        </div>

        <div class="w-full mt-4 px-6 md:pl-14 md:pr-9">
            <div class="container w-full max-w-full">
                <div class="dashboard-card w-full bg-white p-0">
                    <div class="flex-box p-5 justify-between border-b border-black/20">
                        <h6 class="dashboard-title m-0">Recent Orders
                        </h6>
                        <button type="button"
                            class="flex justify-center items-center gap-4 border border-black/20 rounded-[5px] px-2.5 py-2 cursor-pointer font-sans font-medium text-sm leading-tight tracking-1 text-silver"><img
                                src="{{asset('storage/images/dashboard-filter.png')}}" alt=""
                                class="max-w-3"><span>Filter</span></button>
                    </div>
                    <div class="overflow-x-auto w-full p-0">
                        <table class="table-auto w-full sm:w-full seller-table">
                            <thead>
                                <tr class="border-b border-black/20">
                                    <th class="pl-5">Order ID</th>
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#12337</td>
                                    <td>Baby Blanket</td>
                                    <td>29 Apr 2025</td>
                                    <td><span class="deliver-btn">Delivered</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="cancelled">Cancelled</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="processing">Processing</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="refund">Delivered</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="refund">Refund</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="deliver-btn">Delivered</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 May 2025</td>
                                    <td><span class="processing">processing</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="refund">refund</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#12387</td>
                                    <td>Bottle Set</td>
                                    <td>12 Mar 2025</td>
                                    <td><span class="cancelled">cancelled</span></td>
                                    <td><span class="popup"><img src="{{asset('storage/images/table-popup.png')}}"
                                                alt=""></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection