 <header
      class="
        relative w-full bg-white text-white px-5">
        <div class="container max-w-container mx-auto">
            <div class="flex flex-wrap flex-row-reverse lg:flex-row items-center gap-6 pt-5 pb-2 md:pb-3.5">
                <a href="./index.html" class="hidden lg:inline-flex items-center">
                    <img src="{{ asset('storage/WebsiteImages/home/cuddlyduddlylogo1.png') }}" alt="Logo"
                        class="lg:max-w-(--max-w-lg) xl:max-w-(--max-w-xl)">
                </a>
                <nav
                    class="flex-none lg:flex-5 xl:flex-1 w-full lg:w-auto flex items-center justify-between gap-6 order-3 lg:order-0">
                    <div
                        class="relative w-full transform origin-top lg:w-auto lg:flex-1 flex lg:flex flex-row items-start lg:justify-end lg:items-center gap-6 lg:opacity-100 pt-0 pb-4 px-4 lg:p-0">
                        <div
                            class="w-full md:max-w-[700px] lg:w-full xl:max-w-(--max-w-search) lg:flex-3 md:mx-auto lg:mx-0 btn-wrapper text-black bg-white">
                            <img src="{{ asset('storage/WebsiteImages/home/magnifying-glass.png') }}" alt=""
                                class="max-w-icon">
                            <input type="text" placeholder="Find baby products & beyond"
                                class="max-w-input placeholder:text-block placeholder:text-black pointer-events-auto">
                        </div>

                        <a
                            class="w-full hidden xl:max-w-(--max-w-vendor) lg:flex-2 lg:flex justify-center items-center gap-2 btn-wrapper rounded-xxl border border-black/20 cursor-pointer hover:bg-black/20!">
                            <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt="" class="max-w-icon">
                            <span class="text-block">Become a Vendor</span>
                        </a>
                    </div>
                </nav>
                <div
                    class="relative z-50 flex-1 lg:flex-none xl:flex-none flex justify-end items-center gap-2 md:gap-6">
                    <a href="#!"
                        class="w-full max-w-[90px] min-[480px]:max-w-(--min-w-5xs) md:max-w-[135px] max-h-10 lg:max-h-[unset] xl:min-w-(--min-w-xs) lg:flex-1 btn-wrapper  bg-pink-transparent cursor-pointer hover:bg-black">
                        <img src="{{ asset('storage/WebsiteImages/home/loginicon.png') }}" alt="login icon"
                            class="max-w-icon">
                        <span class="text-block text-white">Login</span>
                    </a>

                    <button class="btn cursor-pointer flex justify-center items-center">
                        <img src="{{ asset('storage/WebsiteImages/home/cart.png') }}" class="max-h-[15px] sm:max-h-(--max-h-icon) object-contain" alt="">
                    </button>
                </div>
                <div class="flex-1 flex lg:shrink lg:justify-end xl:flex-none gap-2 md:gap-6">
                    <button id="hamburger"
                        class="btn cursor-pointer text-lg text-black border-0 lg:border lg:border-black/20">
                        <i class="fa-solid fa-ellipsis-vertical hidden! lg:block! m-auto"></i>
                        <i class="fa-solid fa-bars block lg:hidden! m-auto"></i>
                    </button>
                    <a href="#" class="block lg:hidden">
                        <img src="{{ asset('storage/WebsiteImages/home/cuddlyduddlylogo.png') }}" alt="Logo"
                            class="min-w-(--min-w-logo) md:max-w-(--max-w-xl) object-contain -ml-2 md:ml-0">
                    </a>
                    <div class="z-50 w-3/5 lg:w-[500px] h-full lg:origin-top lg:flex-1 flex lg:flex flex-col lg:flex-row items-start gap-6 lg:opacity-100 p-5  bg-white"
                        id="navbar">
                        <ul
                            class="w-full lg:rounded-block lg:shadow-[0_20px_50px_rgba(0,0,0,0.15)] lg:p-3.5 lg:pb-4 bg-white">
                            <li>
                                <div class="w-full flex flex-col gap-4" bis_skin_checked="1">
                                    <span class="megadown-title">POPULAR</span>
                                    <ul class="megadown-list">
                                        <li class="relative megadown-items">
                                            <a href="#!" class="w-full megalink inline-flex justify-between gap-4"
                                                tabindex="0">
                                                <span>Jacket</span>
                                                <i class="fa-solid fa-angle-down"></i>
                                            </a>
                                            <div class="megadropdown">
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">POPULAR</span>
                                                    <ul class="dropdown-list">
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Jacket</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>GirlFashion</span>
                                                            </a>
                                                        </li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Trouser</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Leggings</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Hand Gloves</span>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">MENU</span>
                                                    <ul class="dropdown-list">
                                                        <li><a href="">All Category</a></li>
                                                        <li><a href="">Gift Cards</a></li>
                                                        <li><a href="">Special Events</a></li>
                                                        <li><a href="">Testimonial</a></li>
                                                        <li><a href="">Blog</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="relative megadown-items">
                                            <a href="" class="w-full megalink inline-flex justify-between gap-4"
                                                tabindex="0">
                                                <span>Girl Fashion</span>
                                                <i class="fa-solid fa-angle-down"></i>
                                            </a>
                                            <div class="megadropdown">
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">POPULAR</span>
                                                    <ul class="dropdown-list">
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Jacket</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>GirlFashion</span>
                                                            </a>
                                                        </li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Trouser</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Leggings</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Hand Gloves</span>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">MENU</span>
                                                    <ul class="dropdown-list">
                                                        <li><a href="">All Category</a></li>
                                                        <li><a href="">Gift Cards</a></li>
                                                        <li><a href="">Special Events</a></li>
                                                        <li><a href="">Testimonial</a></li>
                                                        <li><a href="">Blog</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="relative megadown-items">
                                            <a href="" class="w-full megalink inline-flex justify-between gap-4"
                                                tabindex="0">
                                                <span>Boy Fashion</span>
                                                <i class="fa-solid fa-angle-down"></i>
                                            </a>
                                            <div class="megadropdown">
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">POPULAR</span>
                                                    <ul class="dropdown-list">
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Jacket</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>GirlFashion</span>
                                                            </a>
                                                        </li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Trouser</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Leggings</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Hand Gloves</span>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">MENU</span>
                                                    <ul class="dropdown-list">
                                                        <li><a href="">All Category</a></li>
                                                        <li><a href="">Gift Cards</a></li>
                                                        <li><a href="">Special Events</a></li>
                                                        <li><a href="">Testimonial</a></li>
                                                        <li><a href="">Blog</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="relative megadown-items">
                                            <a href="" class="w-full megalink inline-flex justify-between gap-4"
                                                tabindex="0">
                                                <span>Baby Cloth</span>
                                                <i class="fa-solid fa-angle-down"></i>
                                            </a>
                                            <div class="megadropdown">
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">POPULAR</span>
                                                    <ul class="dropdown-list">
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Jacket</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>GirlFashion</span>
                                                            </a>
                                                        </li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Trouser</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Leggings</span>
                                                            </a></li>
                                                        <li><a href="" class="inline-flex gap-4">
                                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}"
                                                                    alt="" class="max-w-icon">
                                                                <span>Hand Gloves</span>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                                <div class="flex flex-col gap-4">
                                                    <span class="dropdown-title text-black">MENU</span>
                                                    <ul class="dropdown-list">
                                                        <li><a href="">All Category</a></li>
                                                        <li><a href="">Gift Cards</a></li>
                                                        <li><a href="">Special Events</a></li>
                                                        <li><a href="">Testimonial</a></li>
                                                        <li><a href="">Blog</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>