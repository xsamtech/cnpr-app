<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="cnpr-url" content="{{ getWebURL() }}">
        <meta name="cnpr-visitor" content="{{ !empty($current_user) ? random_int(10000, 99999) . '-' . $current_user->id : null }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="cnpr-ref" content="{{ getApiToken() }}">

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
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/jquery/jquery-ui/jquery-ui.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/animsition/animsition.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/wow/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/css-hamburgers/hamburgers.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/slick/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/cooladmin/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/dataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/cropper/css/cropper.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/sweetalert2/dist/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/addons/custom/bootstrap/bootstrap-multiselect/css/bootstrap-multiselect.min.css') }}">

        <!-- CoolAdmin CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">

        <title>
@if (Route::is('home'))
            @lang('miscellaneous.app_name')
@endif
@if (Route::is('about'))
            @lang('miscellaneous.menu.about')
@endif
@if (Route::is('search'))
            @lang('miscellaneous.search_result')
@endif
@if (Route::is('message.home') || Route::is('message.datas'))
            @lang('miscellaneous.menu.messages')
@endif
@if (Route::is('message.new'))
            @lang('miscellaneous.pages_content.message.new')
@endif
@if (Route::is('account'))
            @lang('miscellaneous.menu.account_settings')
@endif
@if (Route::is('account.update.password'))
            @lang('miscellaneous.pages_content.account.update_password.title')
@endif
@if (Route::is('notifications'))
            @lang('miscellaneous.menu.notifications')
@endif
@if (Route::is('history'))
            @lang('miscellaneous.menu.activities_history')
@endif
@if (Route::is('communique.home'))
            @lang('miscellaneous.menu.manager.communiques')
@endif
@if (Route::is('communique.datas'))
            @lang('miscellaneous.pages_content.manager.home.communiques.details')
@endif
@if (Route::is('task.home'))
            @lang('miscellaneous.menu.manager.tasks')
@endif
@if (Route::is('task.datas'))
            @lang('miscellaneous.pages_content.manager.home.tasks.details')
@endif
@if (Route::is('province.home'))
            @lang('miscellaneous.menu.admin.province.title')
@endif
@if (Route::is('province.datas'))
            @lang('miscellaneous.pages_content.admin.province.details')
@endif
@if (Route::is('group.home'))
            @lang('miscellaneous.menu.admin.group.title')
@endif
@if (Route::is('group.datas'))
            @lang('miscellaneous.pages_content.admin.group.details')
@endif
@if (Route::is('role.home'))
            @lang('miscellaneous.menu.admin.role.title')
@endif
@if (Route::is('role.datas'))
            @lang('miscellaneous.pages_content.admin.role.details')
@endif
@if (Route::is('vacation.home'))
            @lang('miscellaneous.menu.admin.vacation')
@endif
@if (Route::is('vacation.datas'))
            @lang('miscellaneous.pages_content.admin.vacation.details')
@endif
@if (Route::is('department.home'))
            @lang('miscellaneous.menu.admin.department')
@endif
@if (Route::is('department.datas'))
            @lang('miscellaneous.pages_content.admin.department.details')
@endif
@if (Route::is('branch.home'))
            @lang('miscellaneous.menu.admin.branch')
@endif
@if (Route::is('branch.datas'))
            @lang('miscellaneous.pages_content.admin.branch.details')
@endif
@if (Route::is('employee.home'))
            @lang('miscellaneous.menu.manager.employees.title')
@endif
@if (Route::is('employee.datas'))
            @lang('miscellaneous.pages_content.manager.home.employees.details')
@endif
@if (Route::is('message.entity.home') || Route::is('province.entity.home') || Route::is('group.entity.home') || Route::is('role.entity.home') || Route::is('employee.entity.home'))
            {{ $entity_title }}
@endif
@if (Route::is('message.entity.datas') || Route::is('province.entity.datas') || Route::is('group.entity.datas') || Route::is('role.entity.datas') || Route::is('employee.entity.datas'))
            {{ $entity_details }}
@endif
        </title>
    </head>

    <body class="animsition">
        <!-- MODALS-->
@if (Route::is('branch.home') || Route::is('branch.datas'))
        <!-- ### Add a manager ### -->
        <div class="modal fade" id="registerModalManager" tabindex="-1" aria-labelledby="registerModalManagerLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalManagerLabel">{{ __('miscellaneous.pages_content.admin.role.managers.add') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('role.entity.home', ['entity' => 'managers']) }}">
    @csrf

                            <!-- Number -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_number" id="register_number" class="form-control" placeholder="@lang('miscellaneous.number')" />
                                <label class="form-label" for="register_number">@lang('miscellaneous.number')</label>
                            </div>

                            <!-- First name -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" required />
                                <label class="form-label" for="register_firstname">@lang('miscellaneous.firstname')</label>
                            </div>

                            <!-- Last name -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" />
                                <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                            </div>

                            <!-- Surname -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" />
                                <label class="form-label" for="register_surname">@lang('miscellaneous.surname')</label>
                            </div>

                            <!-- Birth city/date -->
                            <div class="row g-2 mt-sm-3 mt-4">
                                <div class="col-12">
                                    <p class="mb-lg-1 mb-0">@lang('miscellaneous.birth_city_date')</p>
                                </div>

                                <div class="col-sm-7">
                                    <div class="form-floating">
                                        <input type="text" name="register_birth_city" id="register_birth_city" class="form-control" placeholder="@lang('miscellaneous.birth_city')" />
                                        <label class="form-label" for="register_birth_city">@lang('miscellaneous.birth_city')</label>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-floating mt-sm-0 mt-2">
                                        <input type="text" name="register_birth_date" id="register_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" />
                                        <label class="form-label" for="register_birthdate">@lang('miscellaneous.birth_date.label')</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="mt-3 text-center">
                                <p class="mb-lg-1 mb-0">@lang('miscellaneous.gender_title')</p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="register_gender" id="male" value="M">
                                    <label class="form-check-label" for="male">@lang('miscellaneous.gender1')</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="register_gender" id="female" value="F">
                                    <label class="form-check-label" for="female">@lang('miscellaneous.gender2')</label>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_username" id="register_username" class="form-control" placeholder="@lang('miscellaneous.username.label')" required />
                                <label class="form-label" for="register_username">@lang('miscellaneous.username.label')</label>
                            </div>

                            <!-- Phone -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_phone" id="register_phone" class="form-control" placeholder="@lang('miscellaneous.phone')" required />
                                <label class="form-label" for="register_phone">@lang('miscellaneous.phone')</label>
                            </div>

                            <!-- E-mail -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" />
                                <label class="form-label" for="register_email">@lang('miscellaneous.email')</label>
                            </div>

                            <!-- Address line 1 -->
                            <div class="form-floating mt-3">
                                <textarea name="register_address_1" id="register_address_1" class="form-control" placeholder="@lang('miscellaneous.address.line1')"></textarea>
                                <label class="form-label" for="register_address_1">@lang('miscellaneous.address.line1')</label>
                            </div>

                            <!-- Address line 2 -->
                            <div class="form-floating mt-3">
                                <textarea name="register_address_2" id="register_address_2" class="form-control" placeholder="@lang('miscellaneous.address.line2')"></textarea>
                                <label class="form-label" for="register_address_2">@lang('miscellaneous.address.line2')</label>
                            </div>

                            <!-- P.O Box -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.p_o_box')" />
                                <label class="form-label" for="register_p_o_box">@lang('miscellaneous.p_o_box')</label>
                            </div>

                            <!-- Office -->
                            <div class="form-floating mt-3">
                                <input type="text" name="register_office" id="register_office" class="form-control" placeholder="@lang('miscellaneous.office')" />
                                <label class="form-label" for="register_surname">@lang('miscellaneous.office')</label>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mt-3">
                                <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.password.label')" required />
                                <label class="form-label" for="register_password">@lang('miscellaneous.password.label')</label>
                            </div>

                            <!-- Confirm password -->
                            <div class="form-floating mt-3">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="@lang('miscellaneous.confirm_password.label')" required />
                                <label class="form-label" for="confirm_password">@lang('miscellaneous.confirm_password.label')</label>
                            </div>

                            <div id="otherUserImageWrapper" class="row mt-3">
                                <div class="col-sm-7 col-9 mx-auto">
                                    <p class="small mb-1 text-center">@lang('miscellaneous.pages_content.account.personal_infos.click_to_change_picture')</p>

                                    <div class="bg-image hover-overlay">
                                        <img src="{{ asset('assets/img/user.png') }}" alt="" class="other-user-image img-fluid rounded-4">
                                        <div class="mask rounded-4" style="background-color: rgba(5, 5, 5, 0.5);">
                                            <label role="button" for="image_other_user" class="d-flex h-100 justify-content-center align-items-center">
                                                <i class="bi bi-pencil-fill text-white fs-2"></i>
                                                <input type="file" name="image_other_user" id="image_other_user" class="d-none">
                                            </label>
                                            <input type="hidden" name="data_other_user" id="data_other_user">
                                        </div>
                                    </div>

                                    <p class="d-none mt-2 mb-0 small text-center text-success fst-italic">@lang('miscellaneous.waiting_register')</p>
                                </div>
                            </div>

                            <div class="row g-2 mt-3">
                                <div class="col-sm-6">
                                    <button class="btn btn-primary btn-block rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-light btn-block border rounded-pill" data-bs-dismiss="modal">@lang('miscellaneous.cancel')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endif
        <!-- ### Crop user image ### -->
        <div class="modal fade" id="cropModalUser" tabindex="-1" aria-labelledby="cropModalUserLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropModalUserLabel">{{ __('miscellaneous.crop_before_save') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-sm-0 mb-4">
                                    <div class="bg-image">
                                        <img src="" id="retrieved_image" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light border rounded-pill" data-bs-dismiss="modal">@lang('miscellaneous.cancel')</button>
                        <button type="button" id="crop_avatar" class="btn btn-primary rounded-pill"data-bs-dismiss="modal">{{ __('miscellaneous.register') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ### Crop other user image ### -->
        <div class="modal fade" id="cropModalOtherUser" tabindex="-1" aria-labelledby="cropModalOtherUserLabel" aria-hidden="true" data-bs-backdrop="{{ Route::is('branch.home') ? 'static' : 'true' }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropModalOtherUserLabel">{{ __('miscellaneous.crop_before_save') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 mb-sm-0 mb-4">
                                    <div class="bg-image">
                                        <img src="" id="retrieved_image_other_user" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-light border rounded-pill" data-bs-dismiss="modal">@lang('miscellaneous.cancel')</button>
                        <button type="button" id="crop_other_user" class="btn btn-primary rounded-pill" data-bs-dismiss="modal">{{ __('miscellaneous.register') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODALS-->

        <!-- PAGE WRAPPER-->
        <div class="page-wrapper">
@if ($current_user->status->status_name == 'Actif')
    @include('navigation.sidenav')

            <div class="page-container2">
    @if (\Session::has('success_message'))
                <!-- ALERT-->
                <div class="position-relative">
                    <div class="row position-absolute w-100" style="top: 0; opacity: 0.9; z-index: 9999;">
                        <div class="col-lg-5 col-sm-6 mx-auto mt-lg-0 mt-5">
                            <div class="alert alert-success alert-dismissible fade show rounded-0" role="alert">
                                <i class="bi bi-info-circle me-2 fs-4" style="vertical-align: -3px;"></i> {{ \Session::get('success_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ALERT END-->
    @endif

    @if (\Session::has('error_message'))
                <!-- ALERT-->
                <div class="position-relative">
                    <div class="row position-absolute w-100" style="top: 0; opacity: 0.9; z-index: 9999;">
                        <div class="col-lg-5 col-sm-6 mx-auto mt-lg-0 mt-5">
                            <div class="alert alert-danger alert-dismissible fade show rounded-0" role="alert">
                                <i class="bi bi-exclamation-triangle me-2 fs-4" style="vertical-align: -3px;"></i> {{ \Session::get('error_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ALERT END-->
    @endif
    
    @include('navigation.header')

    @include('navigation.mobilenav')

    @include('navigation.breadcrumb')

    @yield('app-content')

@else
    @if ($current_user->status->status_name == 'Bloqué')
            <div class="page-content--bge5">
                <section class="py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="bg-image mb-4 text-center">
                                    <img src="{{ asset('assets/img/logo-text.png') }}" alt="CNPR-APP" width="250">
                                    <div class="mask"></div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-sm-7 mx-auto text-center">
                                <span class="menu-sidebar2__content d-none"></span>

                                <div class="card border border-default rounded-5">
                                    <div class="card-body py-5 text-center">
                                        <h1 class="display-2 mb-2 fw-bold text-{{ $current_user->status->color }}"><i class="{{ $current_user->status->icon }}"></i></h1>
                                        <h1 class="h1 mb-2 fw-bold">@lang('miscellaneous.pages_content.account.locked.title')</h1>
                                        <p class="mb-4">@lang('miscellaneous.pages_content.account.locked.description')</p>
                                        <a href="{{ route('logout') }}" class="btn btn-primary rounded-pill px-5">
                                            @lang('miscellaneous.logout')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

    @else
            <div class="page-content--bge5">
                <section class="py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="bg-image mb-4 text-center">
                                    <img src="{{ asset('assets/img/logo-text.png') }}" alt="CNPR-APP" width="250">
                                    <div class="mask"></div>
                                </div>
                            </div>

                            <div class="col-lg-5 col-sm-7 mx-auto text-center">
                                <span class="menu-sidebar2__content d-none"></span>

                                <div class="card border border-default rounded-5">
                                    <div class="card-body py-5 text-center">
                                        <h1 class="display-2 mb-2 fw-bold text-{{ $current_user->status->color }}"><i class="{{ $current_user->status->icon }}"></i></h1>
                                        <h1 class="h1 mb-2 fw-bold">@lang('miscellaneous.pages_content.account.deactivated.title')</h1>
                                        <p class="mb-4">@lang('miscellaneous.pages_content.account.deactivated.description')</p>
                                        <a role="button" id="accountActivation" class="btn btn-success rounded-pill py-2 px-5" data-cnpr-status="{{ $current_user->status->status_name }}">
                                            @lang('miscellaneous.reactivate')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

    @endif
@endif
                <!-- COPYRIGHT-->
                <section class="bg-white pt-3 pb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-center small">&copy; {{ date('Y') }} CNPR<span class="d-inline-block mx-2"></span>@lang('miscellaneous.all_right_reserved')</p>
                                <p class="text-center small">Designed by <a href="https://www.xsam-tech.com" target="_blank">Xsam Technologies</a></p>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END COPYRIGHT-->
            </div>
        </div>
        <!-- END PAGE WRAPPER-->

        <!-- Button back to top -->
        <button id="btnBackTop" class="btn btn-lg btn-floating btn-warning position-fixed d-none rounded-circle shadow" title="@lang('miscellaneous.back_top')" style="z-index: 9999; bottom: 2rem; right: 2rem; padding: 0.4rem 0.5rem;" onclick="backToTop()" data-bs-toggle="tooltip"><i class="bi bi-chevron-double-up"></i></button> 

        <!-- JavaScript Libraries -->
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/jquery/js/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/mdb/js/mdb.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/slick/slick.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/wow/wow.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/animsition/animsition.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/counter-up/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/counter-up/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/circle-progress/circle-progress.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/chartjs/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/addons/cooladmin/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/autosize/js/autosize.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/dataTables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/cropper/js/cropper.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/addons/custom/jquery/scroll4ever/js/jquery.scroll4ever.js') }}"></script>

        <!-- CoolAdmin Javascript -->
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <!-- Custom Javascript -->
        <script src="{{ asset('assets/js/script.custom.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                /* Bootstrap tree */
                $(".tree li:has(ul)").addClass("parent_li").find(" > span").attr("title", "<?= __('miscellaneous.collapse') ?>");
                $(".tree li.parent_li > span").on("click", function (e) {
                    var children = $(this).parent("li.parent_li").find(" > ul > li");

                    if (children.is(":visible")) {
                        children.hide("fast");
                        $(this).attr("title", "<?= __('miscellaneous.expand') ?>").find(" > i").addClass('icon-plus-sign').removeClass("icon-minus-sign");

                    } else {
                        children.show("fast");
                        $(this).attr("title", "<?= __('miscellaneous.collapse') ?>").find(" > i").addClass("icon-minus-sign").removeClass("icon-plus-sign");
                    }

                    e.stopPropagation();
                });
                $(".tree li.parent_li > span .dropdown").on("click", function (e) {
                    e.stopPropagation();
                });

                /* Activate/Deactivate/lock account */
                $("#accountActivation").on("click", function () {
                    var user_id = parseInt(currentUser.split('-')[1]);
                    var emloyee_id = $(this).attr('data-cnpr-user') != null ? parseInt($(this).attr('data-cnpr-user')) : user_id;
                    var visitor_id = parseInt(currentUser.split('-')[1]);

                    if ($(this).attr('data-cnpr-status') == 'Désactivé' || $(this).attr('data-cnpr-status') == 'Bloqué') {
                        Swal.fire({
                            // title: "<?= __('miscellaneous.alert.attention.account.activate') ?>",
                            text: "<?= __('miscellaneous.alert.confirm.account.activate') ?>",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "<?= __('miscellaneous.alert.yes.account.activate') ?>",
                            cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajax({
                                    headers: headers,
                                    type: "GET",
                                    contentType: "application/json",
                                    url: currentHost + "/api/status/search/Actif",
                                    dataType: "json",
                                    data: JSON.stringify({ "data" : "Actif" }),
                                    success: function (status_result) {
                                        if (!status_result.success) {
                                            Swal.fire({
                                                title: "<?= __('miscellaneous.alert.oups') ?>",
                                                text: status_result.message,
                                                icon: "error"
                                            });

                                        } else {
                                            $.ajax({
                                                headers: headers,
                                                type: "PUT",
                                                contentType: "application/json",
                                                url: currentHost + "/api/user/switch_status/" + ($(this).attr('data-cnpr-status') == 'Désactivé' ? user_id : emloyee_id) + "/" + status_result.data.id + "/" + visitor_id,
                                                dataType: "json",
                                                data: JSON.stringify({ "id" : ($(this).attr('data-cnpr-status') == 'Désactivé' ? user_id : emloyee_id), "status_id" : status_result.data.id, "visitor_id" : visitor_id }),
                                                success: function (user_result) {
                                                    if (!user_result.success) {
                                                        Swal.fire({
                                                            title: "<?= __('miscellaneous.alert.oups') ?>",
                                                            text: user_result.message,
                                                            icon: "error"
                                                        });

                                                    } else {
                                                        Swal.fire({
                                                            title: "<?= __('miscellaneous.alert.perfect') ?>",
                                                            text: user_result.message,
                                                            icon: "success"
                                                        });
                                                        location.reload();
                                                    }
                                                },
                                                error: function (xhr, error, status_description) {
                                                    console.log(xhr.responseJSON);
                                                    console.log(xhr.status);
                                                    console.log(error);
                                                    console.log(status_description);
                                                }
                                            });
                                        }
                                    },
                                    error: function (xhr, error, status_description) {
                                        console.log(xhr.responseJSON);
                                        console.log(xhr.status);
                                        console.log(error);
                                        console.log(status_description);
                                    }
                                });

                            } else {
                                Swal.fire({
                                    title: "<?= __('miscellaneous.cancel') ?>",
                                    text: "<?= __('miscellaneous.alert.canceled.account.activate') ?>",
                                    icon: "error"
                                });
                            }
                        });
                
                    } else {
                        if ($(this).hasClass('employee-locking')) {
                            Swal.fire({
                                title: "<?= __('miscellaneous.alert.attention.lock') ?>",
                                text: "<?= __('miscellaneous.alert.confirm.lock') ?>",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "<?= __('miscellaneous.alert.yes.lock') ?>",
                                cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        headers: headers,
                                        type: "GET",
                                        contentType: "application/json",
                                        url: currentHost + "/api/status/search/Bloqué",
                                        dataType: "json",
                                        data: JSON.stringify({ "data" : "Bloqué" }),
                                        success: function (status_result) {
                                            if (!status_result.success) {
                                                Swal.fire({
                                                    title: "<?= __('miscellaneous.alert.oups') ?>",
                                                    text: status_result.message,
                                                    icon: "error"
                                                });

                                            } else {
                                                $.ajax({
                                                    headers: headers,
                                                    type: "PUT",
                                                    contentType: "application/json",
                                                    url: currentHost + "/api/user/switch_status/" + emloyee_id + "/" + status_result.data.id + "/" + visitor_id,
                                                    dataType: "json",
                                                    data: JSON.stringify({ "id" : emloyee_id, "status_id" : status_result.data.id, "visitor_id" : visitor_id }),
                                                    success: function (user_result) {
                                                        if (!user_result.success) {
                                                            Swal.fire({
                                                                title: "<?= __('miscellaneous.alert.oups') ?>",
                                                                text: user_result.message,
                                                                icon: "error"
                                                            });
                    
                                                        } else {
                                                            Swal.fire({
                                                                title: "<?= __('miscellaneous.alert.perfect') ?>",
                                                                text: user_result.message,
                                                                icon: "success"
                                                            });
                                                            location.reload();
                                                        }
                                                    },
                                                    error: function (xhr, error, status_description) {
                                                        console.log(xhr.responseJSON);
                                                        console.log(xhr.status);
                                                        console.log(error);
                                                        console.log(status_description);
                                                    }
                                                });
                                            }
                                        },
                                        error: function (xhr, error, status_description) {
                                            console.log(xhr.responseJSON);
                                            console.log(xhr.status);
                                            console.log(error);
                                            console.log(status_description);
                                        }
                                    });

                                } else {
                                    Swal.fire({
                                        title: "<?= __('miscellaneous.cancel') ?>",
                                        text: "<?= __('miscellaneous.alert.canceled.lock') ?>",
                                        icon: "error"
                                    });
                                }
                            });            

                        } else {
                            Swal.fire({
                                title: "<?= __('miscellaneous.alert.attention.account.deactivate') ?>",
                                text: "<?= __('miscellaneous.alert.confirm.account.deactivate') ?>",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "<?= __('miscellaneous.alert.yes.account.deactivate') ?>",
                                cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        headers: headers,
                                        type: "GET",
                                        contentType: "application/json",
                                        url: currentHost + "/api/status/search/Désactivé",
                                        dataType: "json",
                                        data: JSON.stringify({ "data" : "Désactivé" }),
                                        success: function (status_result) {
                                            if (!status_result.success) {
                                                Swal.fire({
                                                    title: "<?= __('miscellaneous.alert.oups') ?>",
                                                    text: status_result.message,
                                                    icon: "error"
                                                });

                                            } else {
                                                $.ajax({
                                                    headers: headers,
                                                    type: "PUT",
                                                    contentType: "application/json",
                                                    url: currentHost + "/api/user/switch_status/" + user_id + "/" + status_result.data.id + "/" + visitor_id,
                                                    dataType: "json",
                                                    data: JSON.stringify({ "id" : user_id, "status_id" : status_result.data.id, "visitor_id" : visitor_id }),
                                                    success: function (user_result) {
                                                        if (!user_result.success) {
                                                            Swal.fire({
                                                                title: "<?= __('miscellaneous.alert.oups') ?>",
                                                                text: user_result.message,
                                                                icon: "error"
                                                            });
                    
                                                        } else {
                                                            Swal.fire({
                                                                title: "<?= __('miscellaneous.alert.perfect') ?>",
                                                                text: user_result.message,
                                                                icon: "success"
                                                            });
                                                            location.reload();
                                                        }
                                                    },
                                                    error: function (xhr, error, status_description) {
                                                        console.log(xhr.responseJSON);
                                                        console.log(xhr.status);
                                                        console.log(error);
                                                        console.log(status_description);
                                                    }
                                                });
                                            }
                                        },
                                        error: function (xhr, error, status_description) {
                                            console.log(xhr.responseJSON);
                                            console.log(xhr.status);
                                            console.log(error);
                                            console.log(status_description);
                                        }
                                    });

                                } else {
                                    Swal.fire({
                                        title: "<?= __('miscellaneous.cancel') ?>",
                                        text: "<?= __('miscellaneous.alert.canceled.account.deactivate') ?>",
                                        icon: "error"
                                    });
                                }
                            });            
                        }
                    }
                });
            });

            /* Change status of an entity */
            function changeIs(entity, element) {
                var _this = document.getElementById(element.id);
                var entity_id = parseInt(_this.id.split('-')[1]);
                var visitor_id = parseInt(currentUser.split('-')[1]);
                var dpt_chief_url = currentHost + "/api/user/update_department_chief/" + entity_id + "/" + visitor_id;
                var other_entity_url = currentHost + "/api/" + entity + "/switch_is/" + entity_id;

                Swal.fire({
                    title: "<?= __('miscellaneous.alert.attention.presence_payment') ?>",
                    text: "<?= __('miscellaneous.alert.confirm.presence_payment') ?>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "<?= __('miscellaneous.alert.yes.presence_payment') ?>",
                    cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: headers,
                            type: "PUT",
                            contentType: "application/json",
                            url: (entity == 'department_chief' ? dpt_chief_url : other_entity_url),
                            dataType: "json",
                            data: JSON.stringify({ "id" : entity_id }),
                            success: function (user_result) {
                                if (!user_result.success) {
                                    Swal.fire({
                                        title: "<?= __('miscellaneous.alert.oups') ?>",
                                        text: user_result.message,
                                        icon: "error"
                                    });
                                } else {
                                    Swal.fire({
                                        title: "<?= __('miscellaneous.alert.perfect') ?>",
                                        text: user_result.message,
                                        icon: "success"
                                    });
                                    location.reload();
                                }
                            },
                            error: function (xhr, error, status_description) {
                                console.log(xhr.responseJSON);
                                console.log(xhr.status);
                                console.log(error);
                                console.log(status_description);
                            }
                        });

                    } else {
                        Swal.fire({
                            title: "<?= __('miscellaneous.cancel') ?>",
                            text: "<?= __('miscellaneous.alert.canceled.presence_payment') ?>",
                            icon: "error"
                        });
                    }
                });
            }

            /* Change status of an entity */
            function changeStatus(entity, element) {
                if (entity == "employee") {
                    var _this = document.getElementById(element.id);
                    var element_value = _this.value;
                    var presence_absence_id = parseInt(_this.getAttribute("data-cnpr-presence"));
                    var user_id = parseInt(_this.getAttribute("data-cnpr-user"));
                    var visitor_id = parseInt(currentUser.split('-')[1]);

                    Swal.fire({
                        title: "<?= __('miscellaneous.alert.attention.status') ?>",
                        text: "<?= __('miscellaneous.alert.confirm.status') ?>",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "<?= __('miscellaneous.alert.yes.status') ?>",
                        cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                    }).then(function (result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                headers: headers,
                                type: "PUT",
                                contentType: "application/json",
                                url: currentHost + "/api/presence_absence/" + presence_absence_id,
                                dataType: "json",
                                data: JSON.stringify({ "id" : presence_absence_id, "status_id" : element_value, "user_id" : user_id, "visitor_id" : visitor_id }),
                                success: function (user_result) {
                                    if (!user_result.success) {
                                        Swal.fire({
                                            title: "<?= __('miscellaneous.alert.oups') ?>",
                                            text: user_result.message,
                                            icon: "error"
                                        });

                                    } else {
                                        Swal.fire({
                                            title: "<?= __('miscellaneous.alert.perfect') ?>",
                                            text: user_result.message,
                                            icon: "success"
                                        });
                                        location.reload();
                                    }
                                },
                                error: function (xhr, error, status_description) {
                                    console.log(xhr.responseJSON);
                                    console.log(xhr.status);
                                    console.log(error);
                                    console.log(status_description);
                                }
                            });

                        } else {
                            Swal.fire({
                                title: "<?= __('miscellaneous.cancel') ?>",
                                text: "<?= __('miscellaneous.alert.canceled.status') ?>",
                                icon: "error"
                            });
                        }
                    });
                }

                if (entity == "user") {
                    var _this = document.getElementById(element.id);
                    var user_id = parseInt(element.id.split('-')[1]);
                    var visitor_id = parseInt(currentUser.split('-')[1]);

                    if (_this.getAttribute("data-cnpr-status") == "Bloqué") {
                        Swal.fire({
                            title: "<?= __('miscellaneous.alert.attention.unlock') ?>",
                            text: "<?= __('miscellaneous.alert.confirm.unlock') ?>",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "<?= __('miscellaneous.alert.yes.unlock') ?>",
                            cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajax({
                                    headers: headers,
                                    type: "GET",
                                    contentType: "application/json",
                                    url: currentHost + "/api/status/search/Actif",
                                    dataType: "json",
                                    data: JSON.stringify({ "data" : "Actif" }),
                                    success: function (status_result) {
                                        if (!status_result.success) {
                                            Swal.fire({
                                                title: "<?= __('miscellaneous.alert.oups') ?>",
                                                text: status_result.message,
                                                icon: "error"
                                            });

                                        } else {
                                            $.ajax({
                                                headers: headers,
                                                type: "PUT",
                                                contentType: "application/json",
                                                url: currentHost + "/api/user/switch_status/" + user_id + "/" + status_result.data.id + "/" + visitor_id,
                                                dataType: "json",
                                                data: JSON.stringify({ "id" : user_id, "status_id" : status_result.data.id, "visitor_id" : visitor_id }),
                                                success: function (user_result) {
                                                    if (!user_result.success) {
                                                        Swal.fire({
                                                            title: "<?= __('miscellaneous.alert.oups') ?>",
                                                            text: user_result.message,
                                                            icon: 'error'
                                                        });

                                                    } else {
                                                        Swal.fire({
                                                            title: "<?= __('miscellaneous.alert.perfect') ?>",
                                                            text: user_result.message,
                                                            icon: "success"
                                                        });
                                                        location.reload();
                                                    }
                                                },
                                                error: function (xhr, error, status_description) {
                                                    console.log(xhr.responseJSON);
                                                    console.log(xhr.status);
                                                    console.log(error);
                                                    console.log(status_description);
                                                }
                                            });
                                        }
                                    },
                                    error: function (xhr, error, status_description) {
                                        console.log(xhr.responseJSON);
                                        console.log(xhr.status);
                                        console.log(error);
                                        console.log(status_description);
                                    }
                                });
                
                            } else {
                                Swal.fire({
                                    title: "<?= __('miscellaneous.cancel') ?>",
                                    text: "<?= __('miscellaneous.alert.canceled.status') ?>",
                                    icon: "error"
                                });
                            }
                        });

                    } else {
                        Swal.fire({
                            title: "<?= __('miscellaneous.alert.attention.lock') ?>",
                            text: "<?= __('miscellaneous.alert.confirm.lock') ?>",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "<?= __('miscellaneous.alert.yes.lock') ?>",
                            cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                        }).then(function (result) {
                            if (result.isConfirmed) {
                                $.ajax({
                                    headers: headers,
                                    type: "GET",
                                    contentType: "application/json",
                                    url: currentHost + "/api/status/search/Bloqué",
                                    dataType: "json",
                                    data: JSON.stringify({ "data" : "Bloqué" }),
                                    success: function (status_result) {
                                        if (!status_result.success) {
                                            Swal.fire({
                                                title: "<?= __('miscellaneous.alert.oups') ?>",
                                                text: status_result.message,
                                                icon: "error"
                                            });

                                        } else {
                                            $.ajax({
                                                headers: headers,
                                                type: "PUT",
                                                contentType: "application/json",
                                                url: currentHost + "/api/user/switch_status/" + user_id + "/" + status_result.data.id + "/" + visitor_id,
                                                dataType: "json",
                                                data: JSON.stringify({ "id" : user_id, "status_id" : status_result.data.id, "visitor_id" : visitor_id }),
                                                success: function (user_result) {
                                                    if (!user_result.success) {
                                                        Swal.fire({
                                                            title: "<?= __('miscellaneous.alert.oups') ?>",
                                                            text: user_result.message,
                                                            icon: "error"
                                                        });

                                                    } else {
                                                        Swal.fire({
                                                            title: "<?= __('miscellaneous.alert.perfect') ?>",
                                                            text: user_result.message,
                                                            icon: "success"
                                                        });
                                                        location.reload();
                                                    }
                                                },
                                                error: function (xhr, error, status_description) {
                                                    console.log(xhr.responseJSON);
                                                    console.log(xhr.status);
                                                    console.log(error);
                                                    console.log(status_description);
                                                }
                                            });
                                        }
                                    },
                                    error: function (xhr, error, status_description) {
                                        console.log(xhr.responseJSON);
                                        console.log(xhr.status);
                                        console.log(error);
                                        console.log(status_description);
                                    }
                                });

                            } else {
                                Swal.fire({
                                    title: "<?= __('miscellaneous.cancel') ?>",
                                    text: "<?= __('miscellaneous.alert.canceled.status') ?>",
                                    icon: "error"
                                });
                            }
                        });
                    }
                }
            }

            /* delete an entity */
            function removeFromBranch(user_id, branch_id) {
                var userId = parseInt(user_id.id.split('-')[1]);
                var branch_id = parseInt(branch_id);
                var visitor_id = parseInt(currentUser.split('-')[1]);

                Swal.fire({
                    title: "<?= __('miscellaneous.alert.attention.delete') ?>",
                    text: "<?= __('miscellaneous.alert.confirm.delete') ?>",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "<?= __('miscellaneous.alert.yes.delete') ?>",
                    cancelButtonText: "<?= __('miscellaneous.cancel') ?>"

                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: headers,
                            type: "PUT",
                            contentType: "application/json",
                            url: currentHost + "/api/branch/remove_users/" + branch_id + '/' + visitor_id,
                            dataType: "json",
                            data: JSON.stringify({ "id" : branch_id, "visitor_id" : visitor_id, "user_id" : userId }),
                            success: function (result) {
                                if (!result.success) {
                                    Swal.fire({
                                        title: "<?= __('miscellaneous.alert.oups') ?>",
                                        text: result.message,
                                        icon: "error"
                                    });

                                } else {
                                    Swal.fire({
                                        title: "<?= __('miscellaneous.alert.perfect') ?>",
                                        text: result.message,
                                        icon: "success"
                                    });
                                    location.reload();
                                }
                            },
                            error: function (xhr, error, status_description) {
                                console.log(xhr.responseJSON);
                                console.log(xhr.status);
                                console.log(error);
                                console.log(status_description);
                            }
                        });

                    } else {
                        Swal.fire({
                            title: "<?= __('miscellaneous.cancel') ?>",
                            text: "<?= __('miscellaneous.alert.canceled.delete') ?>",
                            icon: "error"
                        });
                    }
                });
            }
        </script>
    </body>
</html>
