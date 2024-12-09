<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'কাঁচাপাকা') }}</title>

        <!-- Scripts -->
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{asset('admin/vendors/mdi/css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/vendors/ti-icons/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('admin/vendors/css/vendor.bundle.base.css')}}">
        <link rel="stylesheet" href="{{asset('admin/vendors/font-awesome/css/font-awesome.min.css')}}" />
        <link rel="stylesheet" href="{{asset('admin/vendors/select2/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">
        <!-- Layout styles -->
        <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
        <!-- Favicon -->
        <link rel="icon" sizes="24x24" href="{{asset('frontend/img/logo/logo-3.png')}}">
    </head>
    <body class="font-sans text-gray-900 antialiased">
    @yield('content')
        <!-- plugins:js -->
        <script src="{{asset('admin/vendors/select2/select2.min.js')}}"></script>
        <script src="{{asset('admin/vendors/js/vendor.bundle.base.js')}}"></script>
        <!-- inject:js -->
        <script src="{{asset('admin/js/off-canvas.js')}}"></script>
        <script src="{{asset('admin/js/misc.js')}}"></script>
        <script src="{{asset('admin/js/settings.js')}}"></script>
        <script src="{{asset('admin/js/todolist.js')}}"></script>
        <script src="{{asset('admin/js/jquery.cookie.js')}}"></script>
        <!-- Custom js for this page -->
        <script src="{{asset('admin/js/dashboard.js')}}"></script>
        <script src="{{asset('admin/js/select2.js')}}"></script>
    </body>
</html>
