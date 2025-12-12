<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
</head>

<body>
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
    <div class="hidden relative z-10 lg:block w-full">
        <div class="container max-w-full 2xl:mx-auto">
            <div class="w-full border-t border-b border-black/20 bg-white">
                <div class="slider w-full h-full cursor-pointer p-4 lg:pl-8 lg:py-6 ">
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Strollers</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)]">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Car seats</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Furniture</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Bedding</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Bath & diapering</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Apparel</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Nursing & feeding</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Safety & wellness</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:grid grid-cols-3 absolute left-0 min-w-xl mt-2 p-5 gap-8 bg-white rounded-block shadow-[0_20px_50px_rgba(0,0,0,0.15)] hover:grid">
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">POPULAR</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">MENU</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <span class="dropdown-title">OTHER</span>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Jacket</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>GirlFashion</span>
                                            </a>
                                        </li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Trouser</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Leggings</span>
                                            </a></li>
                                        <li><a href="" class="inline-flex gap-4">
                                                <img src="{{ asset('storage/WebsiteImages/home/home.png') }}" alt=""
                                                    class="max-w-icon">
                                                <span>Hand Gloves</span>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Apparel</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:block absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl">
                                <a href="#">Item 1</a>
                                <a href="#">Item 2</a>
                            </div>
                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Gear & Toys</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:block absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl">
                                <a href="#">Item 1</a>
                                <a href="#">Item 2</a>
                            </div>
                        </div>

                    </div>
                    <div class="slide">
                        <div class="group relative inline-block">
                            <button class="menu-btn">Boutiques</button>
                            <div id="my-dropdown"
                                class="dropdown hidden group-hover:block absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-xl">
                                <a href="#">Item 1</a>
                                <a href="#">Item 2</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="relative z-0 w-full pb-6 lg:pb-0">
        <div class="container max-w-container mx-auto">
            <div class="relative flex flex-col gap-2 mb-lg px-5">
                <h1 class="font-nature font-medium heading leading-tight tracking-1 text-center md:text-left">
                    Discovering
                    parenthood made
                    easier</h1>
                <p
                    class="relative max-w-(--max-w-search) mx-auto md:mx-0 text-block mt-2.5 mb-3 font-medium text-center md:text-left hero-text">
                    Shop 10,000+
                    Curated, Safe & Reliable Baby and Mother Products.</p>
                <a href="#!"
                    class="inline-flex max-w-max max-h-(--max-h-review) mx-auto md:mx-0 btn-wrapper lg:py-5 cursor-pointer"><span
                        class="text-block font-medium">100+
                        trusted customers</span>
                    <div class="flex justify-center items-center cursor-pointer">
                        <div class="max-w-24 h-14 overflow-hidden rounded-4xl">
                            <img src="{{ asset('storage/WebsiteImages/home/reviewicon1.png') }}" alt="">
                        </div>
                        <div class="max-w-24 h-14 -ml-14 overflow-hidden rounded-4xl">
                            <img src="{{ asset('storage/WebsiteImages/home/reviewicon2.png') }}" alt="">
                        </div>
                        <div class="max-w-24 h-14 -ml-14 overflow-hidden rounded-4xl">
                            <img src="{{ asset('storage/WebsiteImages/home/reviewicon3.png') }}" alt="">
                        </div>
                    </div>
                </a>
            </div>
            <div class="relative pt-20 lg:pt-20 xl:pt-0">
                <div
                    class="top block absolute z-[31] top-0 lg:top-[52%] left-1/2 -translate-x-1/2 z-10 w-[60%] md:w-[80%] lg:w-[74%] h-[3%] rotate-350 lg:rotate-330">

                </div>
                <div
                    class="bottom hidden lg:block absolute z-[31] top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 z-20 w-[80%] lg:w-[96%] h-[3%] lg:h-[48%] rotate-15 xl:rotate-9">
                </div>
                <img src="{{ asset('storage/WebsiteImages/home/motherchild2.webp') }}" alt="mother and child"
                    class="relative z-10 mx-auto -mt-32 xl:-mt-[181px] max-w-2xs md:max-w-xs lg:max-w-md xl:max-w-xl">
                <div
                    class="w-full absolute z-30 inset-x-0 bottom-0 h-[30%] bg-[linear-gradient(0deg,rgba(255,255,255,0)_-10.42%,#fff_0.33%,#fff_12.41%,rgba(255,255,255,0)_101.94%)]">
                </div>
            </div>
        </div>
        <img src="{{ asset('storage/WebsiteImages/home/background-pattern.png') }}" alt="background image"
            class="absolute top-[61%] md:top-[54%] max-h-64">
    </div>
    <div class="w-full px-5 overflow-hidden mt-lg">
        <div class="container max-w-container mx-auto">
            <div class="relative w-full mb-10 rounded-block overflow-hidden">
                <div
                    class="absolute left-6 top-5 min-w-(--min-w-4xs) p-2.5 md:px-2.5 md:py-4 flex-box rounded-label bg-pink-transparent/30 border-t-[0.5px] border-b-[0.5px] border-[#ffc0cb3b]">
                    <div><img src="{{ asset('storage/WebsiteImages/home/labelicon.png') }}" alt="label icon"
                            class="max-w-6"></div> <span class="label">Our
                        story</span>
                </div>
                <div class="invisible md:visible absolute -top-14 -right-[88px] max-w-md overflow-hidden z-10">
                    <img src="{{ asset('storage/WebsiteImages/home/flower-pattern.png') }}" alt="flower design">
                </div>
                <img src="{{ asset('storage/WebsiteImages/home/ourstory.jpg') }}" alt="mother holding child"
                    class="min-h-[445px] md:min-h-auto md:max-h-(--max-h-story)">
                <p class="absolute z-10 left-6 bottom-6 max-w-(--max-w-text) text-info"><span class="text-gray-text">We
                        are your
                        trusted online source for </span>10,000+
                    100% safety-compliant and innovative baby and mother
                    essentials.<span class="text-gray-text">Our mission is to support every stage of your family's
                        journey with
                    </span>unwavering quality, expertise,
                    and seamless care.</p>
                <div class="absolute w-full h-full inset-0 bg-linear-to-b from-transparent to-black/70"></div>
            </div>
            <div class="w-full grid gap-x-4 gap-y-4 grid-cols-1 md:grid-cols-3">
                <div class="flex-box bg-pink-transparent/13 p-12 rounded-card"><img
                        src="{{ asset('storage/WebsiteImages/home/icon1.png') }}" alt=""
                        class="max-w-icon max-w-(--max-w-xl) object-contain"><span class="text-block">100% Safety
                        Guaranteed</span>
                </div>
                <div class="flex-box bg-pink-transparent/13 p-12 rounded-card"><img
                        src="{{ asset('storage/WebsiteImages/home/icon2.png') }}" alt=""
                        class="max-w-icon max-w-(--max-w-xl) object-contain"><span class="text-block">Nationwide Fast
                        Shipping</span></div>
                <div class="flex-box bg-pink-transparent/13 p-12 rounded-card"><img
                        src="{{ asset('storage/WebsiteImages/home/icon3.png') }}" alt=""
                        class="max-w-icon max-w-(--max-w-xl) object-contain"><span class="text-block">Exceptional
                        Customer
                        Care</span></div>
            </div>

        </div>
    </div>
    <div class="wrapper px-5 mt-lg">
        <div class="container max-w-container mx-auto">
            <div class="title flex-box mt-lg mb-sm">
                <div><img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                        class="max-w-6"></div> <span class="label text-black">Shop by category</span>
            </div>

            <div class="relative grid gap-4">
                <div class="absolute -top-40 -right-[179px]"><img
                        src="{{ asset('storage/WebsiteImages/home/flowerpatter.png') }}" alt="flower design">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/categoryimg1.jpg') }}" alt="" class="h-400 transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        <div class="absolute top-6 left-3.5 label-wrapper"><span class="label text-black">Pregnancy
                                &
                                Mom</span></div>
                        <div class="absolute left-0 right-0 bottom-0 z-0 h-2/5 flex justify-end items-end blur-div">
                        </div>
                        <a class="group collection-btn flex-box gap-0 lg:pl-6">
                            <span class="label text-black font-medium group-hover:text-white">View
                                collection</span><span>
                                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-6 max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                </span>
                        </a>
                    </div>
                    <div class="relative rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/categoryimg6.jpg') }}" alt="" class="h-400 transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        <div class="absolute top-6 left-3.5 label-wrapper"><span class="label text-black">Infant &
                                new born
                                Essentials</span></div>
                        <div class="absolute left-0 right-0 bottom-0 z-0 h-2/5 flex justify-end items-end blur-div">
                        </div>
                        <a class="group collection-btn flex-box gap-0 lg:pl-6"><span class="label text-black font-medium group-hover:text-white">View
                                collection</span><span>
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-6 max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="relative h-81 rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/categoryimg5.jpg') }}" alt="" class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        <div class="absolute top-6 inset-x-auto w-full text-center"><span
                                class="label label-wrapper text-black">Baby gear
                                & travels</span></div>
                        <div class="absolute left-0 right-0 bottom-0 z-0 h-2/5 flex justify-end items-end blur-div">
                        </div>
                        <a
                            class="group w-[50px] h-[50px] md:w-[70px] md:h-[70px] absolute right-3.5 bottom-3.5 z-10 flex-box inline-flex p-6 bg-white/32 border border-black/22 rounded-full backdrop-blur hover:bg-black">
                            <span>
                               <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-[unset] max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                </span>
                        </a>
                    </div>
                    <div class="relative h-81 rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/categoryimg4.jpg') }}" alt="" class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        <div class="absolute top-6 inset-x-auto w-full text-center"><span
                                class="label label-wrapper text-black">Fashion (0-10+ years)</span></div>
                        <div class="absolute left-0 right-0 bottom-0 z-0 h-2/5 flex justify-end items-end blur-div">
                        </div>
                        <a
                            class="group w-[50px] h-[50px] md:w-[70px] md:h-[70px] absolute right-3.5 bottom-3.5 z-10 flex-box inline-flex p-6 bg-white/32 border border-black/22 rounded-full backdrop-blur hover:bg-black">
                            <span>
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-[unset] max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                </span>
                        </a>
                    </div>
                    <div class="relative h-81 rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/categoryimg3.jpg') }}" alt="" class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        <div class="absolute top-6 inset-x-auto w-full text-center"><span
                                class="label label-wrapper text-black">
                               Nursery & room decor</span></div>
                        <div class="absolute left-0 right-0 bottom-0 z-0 h-2/5 flex justify-end items-end blur-div">
                        </div>
                        <a
                            class="group w-[50px] h-[50px] md:w-[70px] md:h-[70px] absolute right-3.5 bottom-3.5 z-10 flex-box inline-flex p-6 bg-white/32 border border-black/22 rounded-full backdrop-blur hover:bg-black">
                            <span>
                               <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-[unset] max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                </span>
                        </a>
                    </div>
                    <div class="relative h-81 rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/categoryimg2.jpg') }}" alt="" class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                        <div class="absolute top-6 inset-x-auto w-full text-center"><span
                                class="label label-wrapper text-black">
                                Toys, Books & Learning</span></div>
                        <div class="absolute left-0 right-0 bottom-0 z-0 h-2/5 flex justify-end items-end blur-div">
                        </div>
                        <a
                            class="group w-[50px] h-[50px] md:w-[70px] md:h-[70px] absolute right-3.5 bottom-3.5 z-10 flex-box inline-flex p-6 bg-white/32 border border-black/22 rounded-full backdrop-blur hover:bg-black">
                            <span>
                               <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-[unset] max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative wrapper px-5">
        <div class="container relative z-10 max-w-container mx-auto">
            <div class="title flex-box mt-lg mb-sm lg:mb-[200px]">
                <div><img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                        class="max-w-6"></div> <span class="label text-black">Shop by customer favourites</span>
            </div>
            <div class="relative">
                <div class="max-w-4xl m-auto flex flex-col justify-center">
                    <div class="w-full flex justify-center items-end -mb-[74px] md:-mb-[132px]"><a href=""
                            class="max-w-(--max-w-lg) md:max-w-[250px] max-[460px]:z-10 relative inline-block w-sm h-auto scale rotate-344">
                            <img src="{{ asset('storage/WebsiteImages/home/button1.png') }}" alt="">
                            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center"
                                bis_skin_checked="1">
                                <span class="font-sans text-lg font-semibold leading-tight tracking-1">under</span>
                                <span class="font-sans text-3xl font-bold leading-tight tracking-1">₹399</span>
                                <span class="font-sans text-xs font-normal leading-tight tracking-1 text-center">Infant
                                    &amp; New Born
                                    Essentials</span>
                            </div>
                        </a></div>
                    <div class="w-full flex flex-wrap gap-0 md:gap-11">
                        <div class="flex-1 flex justify-end"><a href=""
                                class="max-w-[250px] md:max-w-[320px] relative inline-block w-sm h-auto scale">
                                <img src="{{ asset('storage/WebsiteImages/home/button3.png') }}" alt=""
                                    class="object-contain" />
                                <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center"
                                    bis_skin_checked="1">
                                    <span
                                        class="font-sans text-lg font-semibold leading-tight tracking-1 text-white">under</span>
                                    <span
                                        class="font-sans text-3xl lg:text-5xl font-bold leading-tight tracking-1 text-white">₹799</span>
                                    <span
                                        class="font-sans text-xs font-normal leading-tight tracking-1 text-white text-center">Infant
                                        &amp;
                                        New Born
                                        Essentials</span>
                                </div>
                            </a></div>
                        <div class="flex-1 flex justify-start"><a href=""
                                class="max-w-[260px] md:max-w-[480px] max-[460px]:-mt-[37px] relative inline-block w-sm h-auto scale">
                                <img src="{{ asset('storage/WebsiteImages/home/button4.png') }}" alt="">
                                <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center"
                                    bis_skin_checked="1">
                                    <span
                                        class="font-sans text-xl lg:text-(length:--font-para) font-semibold leading-tight tracking-1">under</span>
                                    <span
                                        class="font-sans text-3xl lg:text-6xl font-bold leading-tight tracking-1">₹1,299</span>
                                    <span
                                        class="font-sans text-base font-normal leading-tight tracking-1 text-center">Pregnancy
                                        &amp; mom
                                        care
                                    </span>
                                </div>
                            </a></div>
                    </div>
                    <div class="w-full flex justify-center items-start -mt-[104px] md:-mt-[162px] max-[460px]:-mt-20">
                        <a href=""
                            class="max-w-(--max-w-lg) md:max-w-[250px] col-span-2 relative inline-block w-sm h-auto scale -rotate-344"><img
                                src="{{ asset('storage/WebsiteImages/home/button2.png') }}" alt="">
                            <div class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 flex flex-col items-center"
                                bis_skin_checked="1">
                                <span class="font-sans text-lg font-semibold leading-tight tracking-1">under</span>
                                <span class="font-sans text-3xl font-bold leading-tight tracking-1">₹399</span>
                                <span class="font-sans text-xs font-normal leading-tight tracking-1 text-center">Infant
                                    &amp; New Born
                                    Essentials</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block absolute top-0 right-0"><img
                    src="{{ asset('storage/WebsiteImages/home/customerfav-icon2.png') }}" alt="holding hands image"
                    class="max-w-(--max-w-favouriteicon)">
                <div class="absolute -bottom-[125px] left-1/2 translate-x-1/2 rotate-314">
                    <img src="{{ asset('storage/WebsiteImages/home/star.png') }}" alt="star image"
                        class="max-w-(--max-w-star)">
                </div>
            </div>
            <div class="hidden lg:block absolute bottom-0 left-0"><img
                    src="{{ asset('storage/WebsiteImages/home/customerfav-icon1.png') }}" alt="mother and child"
                    class="max-w-(--max-w-favouriteicon)">
                <div class="absolute -top-24 left-[13px] rotate-314">
                    <img src="{{ asset('storage/WebsiteImages/home/star.png') }}" alt="star image"
                        class="max-w-(--max-w-star)">
                </div>
            </div>
        </div>
        <div class="w-[122%] absolute top-[60%] -translate-y-1/2 left-1/2 -translate-x-1/2 -rotate-[159.93deg]">
            <img src="{{ asset('storage/WebsiteImages/home/pattern2.png') }}" alt="">
        </div>
    </div>
    <div class="wrapper px-5 mt-lg">
        <div class="container max-w-container mx-auto">
            <div class="title flex-box mb-sm">
                <div><img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                        class="max-w-6"></div> <span class="label text-black">Featured bestsellers</span>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-y-(--margin-sm) gap-3 md:gap-5 addtocart">
                <div class="flex flex-col">
                    <a href="#!" class="inline-block cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/travelsystem.png') }}" alt=""></a>
                    <p class="cart-text">Maxi Cosi Zelia Luxe 5-in-1 Modular Travel System</p>
                    <span class="cart-span">No Recline, blue</span>
                    <div class="cart-rating"><span class="max-w-icon"><img
                                src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" alt=""
                                class="max-w-(--max-w-xl) object-contain"></span><span
                            class="cart-span text-white">4.5</span></div>
                    <div class="flex-box justify-start items-end gap-3 mt-2"><span
                            class="cart-price line-through decoration-1">₹2395</span>
                        <span class="cart-discount">₹995</span>
                    </div>
                    <button class="group flex-box mt-4 p-2 sm:p-3 md:p-5 rounded-xxl border border-black/20">
                        <div>
                            <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="group-hover:text-white max-h-4 sm:max-h-[unset]">
                                <path
                                    d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div><span class="addcart">Add to
                            cart</span>
                    </button>
                </div>
                <div class="flex flex-col">
                    <a href="#!" class="inline-block cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/babycloth.png') }}" alt=""></a>
                    <p class="cart-text">Friends Baby Cotton Snap Sleep and Play 2pk</p>
                    <span class="cart-span">Brand: Luvable Friends</span>
                    <div class="cart-rating"><span class="max-w-icon"><img
                                src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" alt=""
                                class="max-w-(--max-w-xl) object-contain"></span><span
                            class="cart-span text-white">4.5</span></div>
                    <div class="flex-box justify-start items-end gap-3 mt-2"><span
                            class="cart-price line-through decoration-1">₹2395</span>
                        <span class="cart-discount">₹1,995</span>
                    </div>
                    <button class="group flex-box mt-4 p-2 sm:p-3 md:p-5 rounded-xxl border border-black/20">
                        <div>
                            <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="group-hover:text-white max-h-4 sm:max-h-[unset]">
                                <path
                                    d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div><span class="addcart">Add to
                            cart</span>
                    </button>
                </div>
                <div class="flex flex-col">
                    <a href="#!" class="inline-block cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/carseat.png') }}" alt=""></a>
                    <p class="cart-text">Baby Trend Cover Me 4-In-1 Convertible Car Seat
                    </p>
                    <span class="cart-span">Brand: Baby Trend</span>
                    <div class="cart-rating"><span class="max-w-icon"><img
                                src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" alt=""
                                class="max-w-(--max-w-xl) object-contain"></span><span
                            class="cart-span text-white">4.5</span></div>
                    <div class="flex-box justify-start items-end gap-3 mt-2"><span
                            class="cart-price line-through decoration-1">₹2395</span>
                        <span class="cart-discount">₹995</span>
                    </div>
                    <button class="group flex-box mt-4 p-2 sm:p-3 md:p-5 rounded-xxl border border-black/20">
                        <div>
                            <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="group-hover:text-white max-h-4 sm:max-h-[unset]">
                                <path
                                    d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div><span class="addcart">Add to
                            cart</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="wrapper px-5 mt-lg">
        <div class="container max-w-container mx-auto">
            <div class="title flex-box mb-sm">
                <div><img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                        class="max-w-6"></div> <span class="label text-black">Shop by customer favourite Brands</span>
            </div>
            <div class="w-full block border border-black/20 rounded-brand p-6 md:px-12 md:py-10 mb-sm">
                <div class="w-full grid grid-cols-2 lg:grid-cols-3 gap-6 m-auto">
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset('storage/WebsiteImages/home/brandicon4.png') }}" alt=""
                            class="max-w-(--max-w-xl) object-contain">
                    </a>
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset('storage/WebsiteImages/home/brandicon6.png') }}" alt=""
                            class="max-w-(--max-w-xl) object-contain">
                    </a>
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset('storage/WebsiteImages/home/brandicon1.png') }}" alt=""
                            class="max-w-(--max-w-xl) object-contain">
                    </a>
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset('storage/WebsiteImages/home/brandicon5.png') }}" alt=""
                            class="max-w-(--max-w-xl) object-contain">
                    </a>
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset('storage/WebsiteImages/home/brandicon3.png') }}" alt=""
                            class="max-w-(--max-w-xl) object-contain">
                    </a>
                    <a href="#!" class="inline-block cursor-pointer">
                        <img src="{{ asset('storage/WebsiteImages/home/brandicon2.png') }}" alt=""
                            class="max-w-20 md:max-w-(--max-w-brand) object-contain">
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="wrapper px-5">
        <div class="container max-w-container mx-auto">
            <div class="title flex-box mb-sm">
                <div><img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                        class="max-w-6"></div> <span class="label text-black">Brands we love</span>
            </div>
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-5 m-auto">
                <a href="#!"
                    class="inline-block border border-black/30 rounded-brandsm overflow-hidden max-h-(--max-h-brand)">
                    <img src="{{ asset('storage/WebsiteImages/home/brandimage1.png') }}" alt=""
                        class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                </a>
                <a href="#!"
                    class="inline-block border border-black/30 rounded-brandsm overflow-hidden max-h-(--max-h-brand)">
                    <img src="{{ asset('storage/WebsiteImages/home/brandimage2.png') }}" alt=""
                        class="transform transition-transform duration-300 hover:scale-110 cursor-pointer">
                </a>
            </div>
        </div>
    </div>
    <div class="wrapper px-5 mt-lg">
        <div class="container max-w-container mx-auto">
            <div class="flex justify-between items-center mb-sm">
                <div class="title flex-box">
                    <div><img src="{{ asset('storage/WebsiteImages/home/labelicon2.png') }}" alt="label icon"
                            class="max-w-6"></div> <span class="label text-black">New Arrivals</span>
                </div>
                <button class="group flex-box py-5 px-6 rounded-xxl border border-black/20 hover:bg-black">
                    <span class="addcart group-hover:text-white">View all</span>
                    <span class="max-w-icon">
                         <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="max-w-5 md:max-w-[unset] max-h-(--max-h-arrow) object-contain group-hover:text-white">
                                    <path d="M13.5 27L22.5 18L13.5 9" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
</span>
                </button>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-y-(--margin-sm) gap-3 md:gap-5 addtocart">
                <div class="flex flex-col">
                    <a href="#!" class="inline-block cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/travelsystem.png') }}" alt=""></a>
                    <p class="cart-text">Maxi Cosi Zelia Luxe 5-in-1 Modular Travel System</p>
                    <span class="cart-span">No Recline, blue</span>
                    <div class="cart-rating"><span class="max-w-icon"><img
                                src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" alt=""
                                class="max-w-(--max-w-xl) object-contain"></span><span
                            class="cart-span text-white">4.5</span></div>
                    <div class="flex-box justify-start items-end gap-3 mt-2">
                        <span class="cart-price line-through decoration-1">₹2395</span>
                        <span class="cart-discount">₹995</span>
                    </div>
                    <button class="group flex-box mt-4 p-2 sm:p-3 md:p-5 rounded-xxl border border-black/20">
                        <div>
                            <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="group-hover:text-white max-h-4 sm:max-h-[unset]">
                                <path
                                    d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div><span class="addcart">Add to
                            cart</span>
                    </button>
                </div>
                <div class="flex flex-col">
                    <a href="#!" class="inline-block cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/babycloth.png') }}" alt=""></a>
                    <p class="cart-text">Friends Baby Cotton Snap Sleep and Play 2pk</p>
                    <span class="cart-span">Brand: Luvable Friends</span>
                    <div class="cart-rating"><span class="max-w-icon"><img
                                src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" alt=""
                                class="max-w-(--max-w-xl) object-contain"></span><span
                            class="cart-span text-white">4.5</span></div>
                    <div class="flex-box justify-start items-end gap-3 mt-2"><span
                            class="cart-price line-through decoration-1">₹2395</span>
                        <span class="cart-discount">₹1,995</span>
                    </div>
                    <button class="group flex-box mt-4 p-2 sm:p-3 md:p-5 rounded-xxl border border-black/20">
                        <div>
                            <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="group-hover:text-white max-h-4 sm:max-h-[unset]">
                                <path
                                    d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div><span class="addcart">Add to
                            cart</span>
                    </button>
                </div>
                <div class="flex flex-col">
                    <a href="#!" class="inline-block cart border border-black/30 rounded-[18px] md:rounded-block overflow-hidden"><img
                            src="{{ asset('storage/WebsiteImages/home/carseat.png') }}" alt=""></a>
                    <p class="cart-text">Baby Trend Cover Me 4-In-1 Convertible Car Seat
                    </p>
                    <span class="cart-span">Brand: Baby Trend</span>
                    <div class="cart-rating"><span class="max-w-icon"><img
                                src="{{ asset('storage/WebsiteImages/home/staricon.png') }}" alt=""
                                class="max-w-(--max-w-xl) object-contain"></span><span
                            class="cart-span text-white">4.5</span></div>
                    <div class="flex-box justify-start items-end gap-3 mt-2">
                        <span class="cart-price line-through decoration-1">₹2395</span>
                        <span class="cart-discount">₹995</span>
                    </div>
                    <button class="group flex-box mt-4 p-2 sm:p-3 md:p-5 rounded-xxl border border-black/20">
                        <div>
                            <svg width="23" height="23" viewBox="0 0 29 29" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="group-hover:text-white max-h-4 sm:max-h-[unset]">
                                <path
                                    d="M9.66634 26.5832C10.3337 26.5832 10.8747 26.0422 10.8747 25.3748C10.8747 24.7075 10.3337 24.1665 9.66634 24.1665C8.999 24.1665 8.45801 24.7075 8.45801 25.3748C8.45801 26.0422 8.999 26.5832 9.66634 26.5832Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M22.9583 26.5834C23.6257 26.5834 24.1667 26.0424 24.1667 25.3751C24.1667 24.7077 23.6257 24.1667 22.9583 24.1667C22.291 24.1667 21.75 24.7077 21.75 25.3751C21.75 26.0424 22.291 26.5834 22.9583 26.5834Z"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M2.47656 2.47705H4.89323L8.1074 17.4846C8.2253 18.0342 8.53112 18.5255 8.97221 18.874C9.4133 19.2224 9.96207 19.4062 10.5241 19.3937H22.3416C22.8916 19.3928 23.4248 19.2044 23.8532 18.8594C24.2816 18.5145 24.5796 18.0338 24.6978 17.4966L26.6916 8.51872H6.18615"
                                    stroke="currentColor" stroke-width="2.41667" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div><span class="addcart">Add to
                            cart</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
    <div class="wrapper px-5 mt-lg">
        <div class="container max-w-container mx-auto">
            <div class="relative w-full block border border-black/30 rounded-block p-5 mb-sm overflow-hidden">
                <img src="{{ asset('storage/WebsiteImages/home/backgroundpattern3.png') }}" alt="background-pattern"
                    class="absolute inset-0 w-full h-full object-cover z-0">
                <div class="relative z-10 w-full grid grid-cols-1 md:grid-cols-2 gap-6 m-auto">
                    <div class="relative block">
                        <div class="absolute -bottom-[55px] -right-[90px]"><img
                                src="{{ asset('storage/WebsiteImages/home/flower.png') }}" alt="flower"></div>
                        <img src="{{ asset('storage/WebsiteImages/home/babyroom.png') }}" alt="baby room">
                    </div>
                    <div class="flex flex-col justify-center items-center">
                        <h3
                            class="mb-3.5 font-sans font-semibold text-2xl md:text-3xl lg:text-4xl text-center leading-tight tracking-1 text-black">
                            The Baby shop</h3>
                        <p
                            class="mb-3.5 font-sans font-normal text-base md:text-xl lg:text-(length:--font-para) text-center leading-tight tracking-1 text-black">
                            Curated and seasoned finds for your little ones</p>
                        <a href="" class="btn-primary">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper px-5 mt-lg">
        <div class="container max-w-container mx-auto">
            <div
                class="relative h-[472px] border border-black/30 rounded-block overflow-hidden p-6 bg-[url('/storage/WebsiteImages/home/background-bottom.png')] bg-cover bg-no-repeat">
                <div
                    class="relative z-10 max-w-(--max-w-block) mx-auto w-full h-full flex flex-col justify-center items-center rounded-block overflow-hidden backdrop-blur-lg">
                    <h3
                        class="relative z-10 max-w-(--max-w-label) md:max-w-[unset] mb-3.5 font-sans font-semibold text-2xl md:text-3xl lg:text-4xl text-center leading-tight tracking-1 text-black">
                        Enjoy 10% Off Your
                        First Order</h3>
                    <p
                        class="relative z-10 mb-3.5 font-sans font-normal text-base md:text-xl lg:text-(length:--font-para) text-center leading-tight tracking-1 text-black">
                        free shipping* on orders above $49.</p>
                    <a href="" class="relative z-10 btn-primary">Join today</a>
                    <div class="absolute top-0 bottom-0 left-0 right-0 rounded-[15px] bg-white/53"><img
                            src="{{ asset('storage/WebsiteImages/home/border.png') }}" alt="border image"
                            class="object-fill"></div>
                </div>
            </div>
        </div>
    </div>
    <footer class="wrapper mt-lg px-5 pb-10">
        <div class="container max-w-container mx-auto">
            <div
                class="flex flex-col justify-start gap-y-9 md:gap-y-5 lg:gap-0 lg:flex-row lg:justify-between lg:items-center">
                <div class="flex flex-col">
                    <a href="./index.html"><img src="{{ asset('storage/WebsiteImages/home/footerlogo.png') }}"
                            alt="logo" class="max-w-(--min-w-s) mb-3.5"></a>
                    <p class="footer-text">Ecommerce is a free UI Kit from Paperpillar that you can use for your
                        personal or
                        commercial project.</p>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="border-[1.05px] border/black rounded-email email-text">
                            <input type="text" placeholder="Type your email address"
                                class="placeholder:font-sans placeholder:font-normal placeholder:text-(length:--font-2sm) placeholder:leading-tight placeholder:tracking-1 placeholder:text-black">
                        </div>
                        <button class="max-w-(--max-w-lg) min-w-(--min-w-5xs) flex-box p-3.5 rounded-email bg-black">
                            <span
                                class="font-sans font-semibold text-(length:--font-2sm) leading-tight tracking-1 text-white cursor-pointer">Submit</span>
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-9 md:grid-cols-3 md:gap-28">
                    <div class="flex flex-col gap-4">
                        <span class="footer-title">POPULAR</span>
                        <ul class="footer-list">
                            <li><a href="">Shoes</a></li>
                            <li><a href="">T-Shirt</a></li>
                            <li><a href="">Jackets</a></li>
                            <li><a href="">Hat</a></li>
                            <li><a href="">Accessories</a></li>
                        </ul>
                    </div>
                    <div class="flex flex-col gap-4">
                        <span class="footer-title">MENU</span>
                        <ul class="footer-list">
                            <li><a href="">All Category</a></li>
                            <li><a href="">Gift Cards</a></li>
                            <li><a href="">Special Events</a></li>
                            <li><a href="">Testimonial</a></li>
                            <li><a href="">Blog</a></li>
                        </ul>
                    </div>
                    <div class="flex flex-col gap-4">
                        <span class="footer-title">OTHER</span>
                        <ul class="footer-list">
                            <li><a href="">Tracking Package</a></li>
                            <li><a href="">FAQ</a></li>
                            <li><a href="">About Us</a></li>
                            <li><a href="">Contact Us</a></li>
                            <li><a href="">Terms and Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.slider').slick({
                slidesToShow: 7,
                slidesToScroll: 7,
                autoplay: true,
                autoplaySpeed: 1,
                speed: 3000,
                cssEase: 'linear',
                centerPadding: '40px',
                pauseOnHover: true,        
                pauseOnFocus: true,
                swipeToSlide: true,        
                touchMove: true,
                infinite: true,
                arrows: false,
                dots: false,
                prevArrow: '<button type="button" class="slick-prev hidden"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg></button>',
                nextArrow: '<button type="button" class="slick-next"><svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.1875 12.375L10.3125 8.25L6.1875 4.125" stroke="white" stroke-width="1.375" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
                responsive: [{
                    breakpoint: 1536,
                    settings: {
                        slidesToShow: 7,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
                ]
            });

            $('.slider').on('afterChange', function (event, slick, currentSlide) {
                if (currentSlide > 0) {
                    $('.slick-prev').removeClass('hidden');
                } else {
                    $('.slick-prev').addClass('hidden');
                }
            });
        });
    </script>
</body>

</html>
