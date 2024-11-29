@extends('layouts.auth')

@section('auth-content')

                            <div class="card border border-default rounded-5">
                                <div class="card-body py-5">
                                    <form method="POST" action="{{ route('login') }}">
    @csrf
                                        <h3 class="h3 mb-sm-5 mb-4 text-center fw-bold">@lang('miscellaneous.login_title2')</h3>

                                        <!-- User name -->
                                        <div class="form-floating">
                                            <input type="text" name="username" id="username" class="form-control" placeholder="@lang('miscellaneous.login_username')" aria-describedby="username_error_message" value="{{ \Session::has('response_error') ? explode('-', \Session::get('response_error'))[0] : '' }}" {{ \Session::has('response_error') && !empty(explode('-', \Session::get('response_error'))[0])  ? '' : 'autofocus' }} />
                                            <label class="form-label" for="username">@lang('miscellaneous.login_username')</label>
                                        </div>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[2] == explode('-', \Session::get('response_error'))[0])
                                        <p id="username_error_message" class="text-center text-danger small">{{ explode('-', \Session::get('response_error'))[3] }}</p>
    @endif

                                        <!-- Password -->
                                        <div class="form-floating mt-3">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('miscellaneous.password.label')" aria-describedby="password_error_message" {{ \Session::has('response_error') && !empty(explode('-', \Session::get('response_error'))[0]) ? 'autofocus' : '' }} />
                                            <label class="form-label" for="password">@lang('miscellaneous.password.label')</label>
                                        </div>
    @if (\Session::has('response_error') && explode('-', \Session::get('response_error'))[2] == explode('-', \Session::get('response_error'))[1])
                                        <p id="password_error_message" class="text-center text-danger small">{{ explode('-', \Session::get('response_error'))[3] }}</p>
    @endif

                                        {{-- <!-- Remember me -->
                                        <div class="row mt-3"> --}}
                                            {{-- <div class="col d-flex justify-content-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me" />
                                                    <label class="form-check-label" for="remember_me">@lang('miscellaneous.remember_me')</label>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <!-- Run login -->
                                        <button type="submit" class="btn btn-primary btn-block rounded-pill py-3 my-4 shadow-0">@lang('miscellaneous.connection')</button>

                                        <!-- Register or recover account -->
                                        <div class="row text-center">
                                            {{-- <div class="col-lg-6 mb-lg-0 mb-2 mx-auto">
                                                <a class="small" href="{{ route('password.request') }}">@lang('miscellaneous.forgotten_password')</a>
                                            </div> --}}
    @if (count($admins) == 0)
                                            <div class="col-lg-6 mx-auto">
                                                <a class="small" href="{{ route('register') }}">@lang('miscellaneous.go_register')</a>
                                            </div>
    @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

@endsection

