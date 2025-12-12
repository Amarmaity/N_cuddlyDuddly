<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:ital,wght@0,400..800;1,400..800&display=swap" rel="stylesheet">
</head>

<body class="font-sans text-gray-800 bg-[#F5F6FA]">

    {{-- HEADER --}}
    @include('website.layouts.header')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('website.layouts.footer')

    @stack('styles')
    @stack('scripts')
</body>
</html>
