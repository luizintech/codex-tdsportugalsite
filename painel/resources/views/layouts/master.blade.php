<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Painel de Administração</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/flag-icon-css/css/flag-icons.min.css">
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{url('')}}/dist/assets/vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{url('')}}/dist/assets/css/vertical-light-layout/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{url('')}}/dist/assets/images/favicon.png" />
    @yield('styles')
    <link rel="stylesheet" href="{{url('')}}/dist/assets/css/custom.css">
</head>

<body>
    <div class="container-scroller">
        @include('shared/topbar')
        <div class="container-fluid page-body-wrapper">
            @include('shared/sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                @include('shared/footer')
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script>
        var base_url = '{{url('')}}';
    </script>
    <script src="{{url('')}}/dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{url('')}}/dist/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/moment/moment.min.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/daterangepicker/daterangepicker.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/chartist/chartist.min.js"></script>
    <script src="{{url('')}}/dist/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="{{url('')}}/dist/assets/js/jquery.cookie.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{url('')}}/dist/assets/js/off-canvas.js"></script>
    <script src="{{url('')}}/dist/assets/js/hoverable-collapse.js"></script>
    <script src="{{url('')}}/dist/assets/js/misc.js"></script>
    <script src="{{url('')}}/dist/assets/js/settings.js"></script>
    <script src="{{url('')}}/dist/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{url('')}}/dist/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    @yield('scripts')
    
</body>
