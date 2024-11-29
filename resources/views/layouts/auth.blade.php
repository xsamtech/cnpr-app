<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="cnpr-data" content="{{ getWebURL() }}">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">

        <!-- Font Icons Files -->
        <link rel="stylesheet" href="{{ asset('assets/css/font-face.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap-icons/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fonts/mdi-font/css/material-design-iconic-font.min.css') }}">

        <!-- Addons CSS Files -->
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/jquery/css/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/animsition/animsition.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/wow/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/css-hamburgers/hamburgers.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/slick/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/perfect-scrollbar/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/dataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/cropper/css/cropper.min.css') }}">

        <!-- CoolAdmin CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

        <title>
@if (Route::is('register') || Route::is('update') || Route::is('register.check_token'))
            @lang('auth.register')
@endif

@if (Route::is('login'))
            @lang('auth.login')
@endif

@if (Route::is('password.request') || Route::is('password.reset'))
            @lang('auth.reset-password')
@endif
        </title>
    </head>

    <body class="animsition">
        <div class="page-wrapper">
@if (\Session::has('error_message'))
            <!-- Alert Start -->
            <div class="position-relative">
                <div class="row position-absolute w-100" style="opacity: 0.9; z-index: 999;">
                    <div class="col-lg-5 col-sm-6 mx-auto">
                        <div class="alert alert-danger alert-dismissible fade show rounded-0 cnpr-line-height-1_1" role="alert">
                            <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {{ \Session::get('error_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Alert End -->

@endif
            <div class="page-content--bge5">
                <div class="container">
                    <div class="row p-lg-5 pt-4 pb-5">
                        <div class="col-lg-8 col-12 d-lg-inline-block d-none mx-auto">
                            <div class="card border border-default rounded-5 overflow-hidden">
                                <div class="card-body p-4">
                                    <div class="bg-image">
                                        <img src="{{ asset('assets/img/logo-text.png') }}" alt="CNPR-APP" width="300">
                                        <div class="mask"></div>
                                    </div>
                                </div>

                                <div class="card-body pt-4 px-4">
                                    <h4 class="h4 mb-0">@lang('miscellaneous.login_description')</h4>
                                </div>

                                <img src="{{ asset('assets/img/pubs/p01.png') }}" alt="" class="card-image">
                            </div>
                        </div>

                        <div class="col-12 d-lg-none d-inline-block">
                            <div class="bg-image mb-4 text-center">
                                <img src="{{ asset('assets/img/logo-text.png') }}" alt="CNPR-APP" width="250">
                                <div class="mask"></div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-7 col-sm-7 mx-auto">

@yield('auth-content')


                            <div class="d-flex justify-content-between">
                                <p class="text-center small">&copy; {{ date('Y') }} CNPR</p>
                                <p class="text-center small">Designed by <a href="https://www.xsam-tech.com" target="_blank">Xsam Technologies</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript Libraries -->
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/mdb/js/mdb.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/slick/slick.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/wow/wow.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/animsition/animsition.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/counter-up/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/counter-up/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/circle-progress/circle-progress.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/chartjs/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/autosize/js/autosize.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/dataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/cropper/js/cropper.min.js') }}"></script>

        <!-- CoolAdmin Javascript -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- Custom Javascript -->
        <script src="{{ asset('assets/js/script.custom.js') }}"></script>
    </body>
</html>
