<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>MyHub</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css">
        <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/flag-icon-css/css/flag-icons.min.css">
        <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/css/vendor.bundle.base.css">
        <!-- Layout styles -->
        <link rel="stylesheet" href="{{url('')}}/dist/assets/css/vertical-light-layout/style.css">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{url('')}}/dist/assets/images/favicon.png" />
    </head>
    <body>
        @yield('content')

        {{-- <script src="{{url('')}}/dist/scripts-site.min.js?v={{env("APP_VERSION")}}"></script> --}}
        <!-- plugins:js -->
        <script src="{{url('')}}/dist/assets/vendors/js/vendor.bundle.base.js"></script>
        <script src="{{url('')}}/dist/assets/js/off-canvas.js"></script>
        <script src="{{url('')}}/dist/assets/js/hoverable-collapse.js"></script>
        <script src="{{url('')}}/dist/assets/js/misc.js"></script>
        <script src="{{url('')}}/dist/assets/js/settings.js"></script>
        <script src="{{url('')}}/dist/assets/js/todolist.js"></script>

        @yield('scripts')
    </body>
</html>