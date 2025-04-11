<!DOCTYPE html>
<html lang="en">
<head>
    @include('headerFooter.header') <!-- Include Header -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/evaluation-form.css') }}?v={{ time() }}" rel="stylesheet">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Sat, 01 Jan 2000 00:00:00 GMT">

</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <span class="d-none d-md-inline">{{ auth()->user()->fname ?? '' }} {{ auth()->user()->lname ?? '' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <img src="{{ asset('/images/Ellipse 2.png') }}" class="rounded-circle shadow" alt="User Image">
                                <p>
                                    {{ auth()->user()->fname ?? '' }} {{ auth()->user()->lname ?? '' }}
                                    <small>{{ auth()->user()->role ?? 'User' }}</small>
                                </p>
                            </li>
                            <li class="user-footer">
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        @include('headerFooter.sidebar')

        <!-- Breadcrumb -->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item">
                                <b><u>{{ isset($title) ? trim(explode('|', $title)[1]) : 'Dashboard' }}</u></b>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                @yield('breadcrumb', 'Dashboard')
                            </li>
                        </ol>
                    </div>
                </div>
            </div>                      

            <!-- Page Content -->
            <div class="container">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        @include('headerFooter.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
<script>
    // window.onpageshow = function(event) {
    //     if (event.persisted || window.performance && window.performance.navigation.type === 2) {
    //         window.location.href='/';
    //     }
    // };

   
    // document.addEventListener("DOMContentLoaded", function () {
    //     // Check if user is logged in from Laravel session
    //     var isGuest = {{ session()->has('user_email') ? 'false' : 'true' }};

    //     window.onpageshow = function(event) {
    //         if (isGuest && (event.persisted || window.performance && window.performance.navigation.type === 2)) {
    //             window.location.href = '/'; // Redirect only if user is NOT logged in
    //         }
    //     };
    // });

//     document.addEventListener("DOMContentLoaded", function () {
//     // Check if user is logged in from Laravel session
//     var isGuest = {{ session()->has('user_email') ? 'false' : 'true' }};

//     window.onpageshow = function(event) {
//         if (isGuest) {
//             if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
//                 window.location.href = '/'; // Redirect only if user is NOT logged in
//             } else {
//                 window.location.reload(true); // Force a hard refresh
//             }
//         }
//     };
// });

document.addEventListener("DOMContentLoaded", function () {
    // Check if user is logged out (no session user_email)
    var isGuest = {{ session()->has('user_email') ? 'false' : 'true' }};

    if (isGuest) {
        // Prevent back navigation by pushing a new state into the browser history
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            // Keep the user from navigating backward by pushing a new state
            history.pushState(null, null, location.href);
        };

        // Force hard refresh and strict redirect to "/"
        window.onpageshow = function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                // If the page was loaded from cache, redirect strictly to "/"
                window.location.href = '/';  // This ensures the user is strictly sent to the home page
            } else {
                // Force a hard refresh and strictly redirect to "/"
                window.location.replace('/'); // This avoids allowing navigation to the current page
            }
        };
    }
});



</script>
</html>