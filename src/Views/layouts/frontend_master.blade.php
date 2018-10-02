<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title','Laravel UserManagement')</title>

    <!-- global stylesheets -->
    <link href="{{asset('vendor/laravel_user_management/fonts/IranSans/style.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/laravel_user_management/frontend/css/build/init_core.min.css') }}" rel="stylesheet" rel="stylesheet">
    <link href="{{ asset('vendor/laravel_user_management/frontend/css/custom.css') }}" rel="stylesheet" rel="stylesheet">
    @yield('custom_plugin_style')
    <script type="text/javascript" src="{{asset('vendor/laravel_user_management/frontend/js/build/init_core.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('vendor/laravel_user_management/frontend/js/build/init_function.min.js')}}"></script>
    @yield('custom_plugin_js')
<!-- /theme JS files -->
    @yield('inline_style')
</head>

<body class="login-container  pace-done">
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">
            @yield('content')
            </div>
        </div>
    </div>
</div>
    <!-- /content area -->
</div>
<div id="all_modals"></div>
@yield('inline_js')
</body>
</body>
</html>
