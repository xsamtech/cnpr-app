@extends('layouts.auth')

@section('auth-content')

                            <div class="card border border-default rounded-5">
                                <div class="card-body py-5">
                                    <form method="POST" action="{{ route('register') }}">
    @csrf
                                        <h3 class="h3 mb-sm-5 mb-4 text-center fw-bold">{{ __('miscellaneous.register_title2') }}</h3>

                                        <!-- First name -->
                                        <div class="form-floating">
                                            <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" aria-describedby="firstname_error_message" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[0] : '' }}" {{ \Session::has('response_error') ? (explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[0]  ? 'autofocus' : '') : 'autofocus' }} />
                                            <label class="form-label" for="register_firstname">@lang('miscellaneous.firstname')</label>
                                        </div>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[0])
                                        <p id="firstname_error_message" class="text-center text-danger small">{{ explode('-', \Session::get('response_error'))[8] }}</p>
    @endif

                                        <!-- Last name -->
                                        <div class="form-floating mt-3">
                                            <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[1] : '' }}" />
                                            <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                                        </div>

                                        <!-- Surname -->
                                        <div class="form-floating mt-3">
                                            <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[2] : '' }}" />
                                            <label class="form-label" for="register_surname">@lang('miscellaneous.surname')</label>
                                        </div>

                                        <!-- Phone -->
                                        <div class="form-floating mt-3">
                                            <input type="text" name="register_phone" id="register_phone" class="form-control" placeholder="@lang('miscellaneous.phone')" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[3] : '' }}" {{ \Session::has('response_error') && explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[3] ? 'autofocus' : '' }} />
                                            <label class="form-label" for="register_phone">@lang('miscellaneous.phone')</label>
                                        </div>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[3])
                                        <p id="phone_error_message" class="text-center text-danger small">{{ explode('-', \Session::get('response_error'))[8] }}</p>
    @else
    @endif

                                        <!-- E-mail -->
                                        <div class="form-floating mt-3">
                                            <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[4] : '' }}" />
                                            <label class="form-label" for="register_email">@lang('miscellaneous.email')</label>
                                        </div>

                                        <!-- Password -->
                                        <div class="form-floating mt-3">
                                            <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.password.label')" aria-describedby="password_error_message" {{ \Session::has('response_error') ? (explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[5] || explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[6] ? 'autofocus' : '' ) : '' }} />
                                            <label class="form-label" for="register_password">@lang('miscellaneous.password.label')</label>
                                        </div>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[5])
                                        <p id="password_error_message" class="text-center text-danger small">{{ explode('-', \Session::get('response_error'))[8] }}</p>
    @endif

                                        <!-- Confirm password -->
                                        <div class="form-floating mt-3">
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="@lang('miscellaneous.confirm_password.label')" aria-describedby="confirm_password_error_message" />
                                            <label class="form-label" for="confirm_password">@lang('miscellaneous.confirm_password.label')</label>
                                        </div>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[7] == explode('-', \Session::get('response_error'))[6])
                                        <p id="confirm_password_error_message" class="text-center text-danger small">{{ explode('-', \Session::get('response_error'))[8] }}</p>
    @endif
    
                                        <div class="col-12 text-center">
                                            <button class="btn btn-warning btn-block rounded-pill mt-4 py-3 px-5 shadow-0" type="submit">@lang('miscellaneous.register')</button>

                                            <a href="{{ route('login') }}">@lang('miscellaneous.go_login')</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
@endsection

