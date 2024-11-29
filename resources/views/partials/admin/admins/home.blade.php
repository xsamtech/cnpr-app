
                <!-- ADMINS LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('role.entity.home', ['entity' => 'other_admins']) }}">
@csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.role.admins.add')</h4>

                                                <!-- Number -->
                                                <div class="form-floating mb-3">
                                                    <input type="text" name="register_number" id="register_number" class="form-control" placeholder="@lang('miscellaneous.number')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_number">@lang('miscellaneous.number')</label>
                                                </div>

                                                <!-- First name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" aria-describedby="firstname_error_message" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[1] : '' }}" />
                                                    <label class="form-label" for="register_firstname">@lang('miscellaneous.firstname')</label>
                                                </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[1])
                                                <p id="firstname_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif

                                                <!-- Last name -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[2] : '' }}" />
                                                    <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                                                </div>

                                                <!-- Surname -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[3] : '' }}" />
                                                    <label class="form-label" for="register_surname">@lang('miscellaneous.surname')</label>
                                                </div>

                                                <!-- Birth city/date -->
                                                <div class="row g-2 mt-sm-3 mt-4">
                                                    <div class="col-12">
                                                        <p class="mb-lg-1 mb-0">@lang('miscellaneous.birth_city_date')</p>
                                                    </div>

                                                    <div class="col-sm-7">
                                                        <div class="form-floating">
                                                            <input type="text" name="register_birth_city" id="register_birth_city" class="form-control" placeholder="@lang('miscellaneous.birth_city')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[4] : '' }}" />
                                                            <label class="form-label" for="register_birth_city">@lang('miscellaneous.birth_city')</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-5">
                                                        <div class="form-floating mt-sm-0 mt-2">
                                                            <input type="text" name="register_birth_date" id="register_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[5] : '' }}" />
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
                                                    <input type="text" name="register_username" id="register_username" class="form-control" placeholder="@lang('miscellaneous.username.label')" aria-describedby="username_error_message" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[11] : '' }}" />
                                                    <label class="form-label" for="register_username">@lang('miscellaneous.username.label')</label>
                                                </div>
@if (\Session::has('response_error') && !empty(explode('~', \Session::get('response_error'))[14]) && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[11])
                                                <p id="username_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@else
                                                <p id="username_error_message" class="text-end fst-italic text-muted small">@lang('miscellaneous.username.description')</p>
@endif

                                                <!-- Phone -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_phone" id="register_phone" class="form-control" placeholder="@lang('miscellaneous.phone')" aria-describedby="phone_error_message" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[9] : '' }}" />
                                                    <label class="form-label" for="register_phone">@lang('miscellaneous.phone')</label>
                                                </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[9])
                                                <p id="phone_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif

                                                <!-- E-mail -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[10] : '' }}" />
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
                                                    <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.p_o_box')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[8] : '' }}" />
                                                    <label class="form-label" for="register_p_o_box">@lang('miscellaneous.p_o_box')</label>
                                                </div>

                                                <!-- Office -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_office" id="register_office" class="form-control" placeholder="@lang('miscellaneous.office')" />
                                                    <label class="form-label" for="register_surname">@lang('miscellaneous.office')</label>
                                                </div>

                                                <!-- Password -->
                                                <div class="form-floating mt-3">
                                                    <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.password.label')" aria-describedby="password_error_message" {{ \Session::has('response_error') ? (explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[12] || explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[13] ? 'autofocus' : '' ) : '' }} />
                                                    <label class="form-label" for="register_password">@lang('miscellaneous.password.label')</label>
                                                </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[12] && explode('~', \Session::get('response_error'))[12] != explode('~', \Session::get('response_error'))[9])
                                                <p id="password_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif

                                                <!-- Confirm password -->
                                                <div class="form-floating mt-3">
                                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="@lang('miscellaneous.confirm_password.label')" aria-describedby="confirm_password_error_message" />
                                                    <label class="form-label" for="confirm_password">@lang('miscellaneous.confirm_password.label')</label>
                                                </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[13] && explode('~', \Session::get('response_error'))[13] != explode('~', \Session::get('response_error'))[9])
                                                <p id="confirm_password_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif

                                                <button class="btn btn-primary btn-block mt-4 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.role.admins.list')</h5>
                                        </div>

                                        <ul class="list-group list-group-flush rounded-4">
@if (count($admins) > 1)
    @foreach ($admins as $admin)
        @if ($admin->id != $current_user->id)
                                            <li class="list-group-item ps-1">
                                                <div class="dropdown show float-end">
                                                    <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dataLink">
                                                        <a class="dropdown-item" href="{{ route('role.entity.datas', ['entity' => 'other_admins', 'id' => $admin->id]) }}">@lang('miscellaneous.change')</a>
                                                        <a class="dropdown-item" href="{{ route('delete', ['entity' => 'user', 'id' => $admin->id]) }}">@lang('miscellaneous.delete')</a>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-2 col-3">
                                                        <div class="bg-image">
                                                            <img src="{{ !empty($admin->avatar_url) ? $admin->avatar_url : asset('assets/img/user.png') }}" alt="" width="70" class="rounded-4">
                                                            <div class="mask"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-10 col-9 d-flex justify-content-start align-items-center">
                                                        <span>
                                                            <h5 class="h5 m-0">{{ $admin->firstname . ' ' . $admin->lastname }}</h5>
                                                            <p class="small text-muted">{{ !empty($admin->username) ? '@' . $admin->username : (!empty($admin->email) ? $admin->email : $admin->phone) }}</p>
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
        @endif
    @endforeach
@else
                                            <li class="list-group-item">
                                                <p class="m-0 text-center text-muted">@lang('miscellaneous.pages_content.admin.role.admins.nobody_else', ['vous' => $current_user->firstname ])</p>
                                            </li>
@endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END ADMINS LIST-->
