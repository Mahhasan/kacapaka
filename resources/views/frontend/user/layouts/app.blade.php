<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name', 'কাঁচাপাকা') }}</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('frontend/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet">
        <link rel="icon" sizes="24x24" href="{{asset('frontend/img/logo/logo-3.png')}}">

        <style>
            .sidebar {
                min-height: 100%;
                background: #f8f9fa;
                padding: 10px;
            }

            /* .sidebar .nav-link {
                font-size: 1.1rem;
                color: #333;
                margin-bottom: 15px;
            } */

            .sidebar .nav-link:hover {
                color: #007bff;
            }

            @media (max-width: 768px) {
                .sidebar {
                    height: 100%;
                    width: 100%;
                    padding: 10px 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Single Page Header start -->
            <div class="row">
                <div class="container-fluid page-header py-5">
                    <h1 class="text-center text-white display-6">My Profile</h1>
                </div>
            </div>
            <!-- Single Page Header End -->
            <div class="row" style="padding-top:50px; padding-bottom:100px;">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                    <div class="position-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.orders') }}">
                                    <i class="fas fa-box"></i> Orders
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @include('frontend.layouts.header')

                @yield('content')

                @extends('frontend.layouts.footer')
                </main>
            </div>
        </div>

        <!-- Back to Top Button -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>
        <script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('frontend/js/main.js') }}"></script>
        <script src="{{ asset('frontend/js/custom.js') }}"></script>
    </body>
</html>
