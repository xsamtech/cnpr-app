
                <!-- UPDATE ADMIN-->
                <section class="pt-4 pb-5">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <form method="POST" action="{{ route('role.entity.datas', ['entity' => 'other_admins', 'id' => $admin->id]) }}">
@csrf
                                <input type="hidden" name="user_id" value="{{ $admin->id }}">
                                <div class="d-flex justify-content-between">
                                    <h3 class="h3 fw-bold">@lang('miscellaneous.pages_content.admin.role.admins.edit')</h3>

                                    <!-- Status -->
                                    <div class="form-check form-switch pt-2">
                                        <input type="checkbox" role="switch" name="status_id-{{ $admin->id }}" id="status_id-{{ $admin->id }}" class="form-check-input" value="{{ $admin->status->id }}" onchange="changeStatus('user', this)" data-cnpr-status="{{ $admin->status->status_name }}"{{ $admin->status->status_name == 'Actif' ? ' checked' : '' }}>
                                        <label class="form-check-label align-bottom text-{{ $admin->status->color }}" for="status_id-{{ $admin->id }}" style="margin-top: -7px;"><i class="{{ $admin->status->icon }} me-1 cnpr-align-middle fs-4"></i>{{ $admin->status->status_name }}</label>
                                    </div>
                                </div>

                                <hr class="mt-2 mb-4">

                                <div class="row">
                                    <div class="col-lg-4 col-sm-5 col-10 mx-auto">
                                        <div class="card rounded-4">
                                            <div id="otherUserImageWrapper" class="card-body pb-4 text-center">
                                                <p class="card-text m-0">@lang('miscellaneous.pages_content.account.personal_infos.click_to_change_picture')</p>

                                                <div class="bg-image hover-overlay mt-3">
                                                    <img src="{{ !empty($admin->avatar_url) ? $admin->avatar_url : asset('assets/img/user.png') }}" alt="{{ $admin->firstname . ' ' . $admin->lastname }}" class="other-user-image img-fluid rounded-4">
                                                    <div class="mask rounded-4" style="background-color: rgba(5, 5, 5, 0.5);">
                                                        <label role="button" for="image_other_user" class="d-flex h-100 justify-content-center align-items-center">
                                                            <i class="bi bi-pencil-fill text-white fs-2"></i>
                                                            <input type="file" name="image_other_user" id="image_other_user" class="d-none">
                                                        </label>
                                                        <input type="hidden" name="data_other_user" id="data_other_user">
                                                    </div>
                                                </div>

                                                <p class="d-none mt-2 mb-0 small text-success fst-italic">@lang('miscellaneous.waiting_register')</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8 col-sm-7 col-12">
                                        <div class="card py-2 rounded-4">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-lg-6 mx-auto">
                                                        <!-- Role -->
                                                        <div class="input-group" title="@lang('miscellaneous.pages_content.admin.role.admins.change_role_description', ['administrateur' => ($admin->gender == 'F' ? 'administratrice' : 'administrateur'), 'de_lui' => ($admin->gender == 'F' ? 'd\'elle' : 'de lui'), 'il' => ($admin->gender == 'F' ? 'elle' : 'il'), 'un' => ($admin->gender == 'F' ? 'une' : 'un')])" data-bs-toggle="tooltip" data-bs-placement="top">
                                                            <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.menu.admin.role.title')</label>
                                                            <select role="button" name="role_id" class="form-select ps-2 pe-1 pb-2 border rounded-0">
                                                                <option class="small" disabled>@lang('miscellaneous.choose_role')</option>
@foreach ($roles as $role)
                                                                <option value="{{ $role->id }}"{{ $admin->roles[0]->id == $role->id ? ' selected' : '' }}>
    @if ($role->role_name == 'Administrateur')
                                                                    &#xf8a7; 
    @else
                                                                    &#xf4db; 
    @endif
                                                                    {{ $role->role_name }}
                                                                </option>
@endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6">
                                                        <!-- Number -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_number" id="register_number" class="form-control" placeholder="@lang('miscellaneous.number')" value="{{ $admin->number }}" autofocus />
                                                            <label class="form-label" for="register_number">@lang('miscellaneous.number')</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- First name -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" aria-describedby="firstname_error_message" value="{{ $admin->firstname }}" />
                                                            <label class="form-label" for="register_firstname">@lang('miscellaneous.firstname')</label>
                                                        </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[1])
                                                        <p id="firstname_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6">
                                                        <!-- Last name -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ $admin->lastname }}" />
                                                            <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- Surname -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ $admin->surname }}" />
                                                            <label class="form-label" for="register_surname">@lang('miscellaneous.surname')</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6">
                                                        <!-- Birth city/date -->
                                                        <div class="row g-sm-2 g-2">
                                                            <div class="col-12">
                                                                <p class="mb-0">@lang('miscellaneous.birth_city_date')</p>
                                                            </div>

                                                            <div class="col-sm-7">
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_birth_city" id="register_birth_city" class="form-control" placeholder="@lang('miscellaneous.birth_city')" value="{{ $admin->birth_city }}" />
                                                                    <label class="form-label" for="register_birth_city">@lang('miscellaneous.birth_city')</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-5">
                                                                <div class="form-floating mt-sm-0 mt-2">
                                                                    <input type="text" name="register_birth_date" id="register_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" value="{{ !empty($admin->birth_date) ? str_starts_with(app()->getLocale(), 'fr') ? \Carbon\Carbon::createFromFormat('Y-m-d', $admin->birth_date)->format('d/m/Y') : \Carbon\Carbon::createFromFormat('Y-m-d', $admin->birth_date)->format('m/d/Y') : null }}" />
                                                                    <label class="form-label" for="register_birthdate">@lang('miscellaneous.birth_date.label')</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- Gender -->
                                                        <div class="text-center">
                                                            <p class="mb-lg-1 mb-0">@lang('miscellaneous.gender_title')</p>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="register_gender" id="male" value="M"{{ $admin->gender == 'M' ? ' checked' : '' }}>
                                                                <label class="form-check-label" for="male">@lang('miscellaneous.gender1')</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="register_gender" id="female" value="F"{{ $admin->gender == 'F' ? ' checked' : '' }}>
                                                                <label class="form-check-label" for="female">@lang('miscellaneous.gender2')</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6">
                                                        <!-- Username -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_username" id="register_username" class="form-control" placeholder="@lang('miscellaneous.username.label')" aria-describedby="username_error_message" value="{{ $admin->username }}" />
                                                            <label class="form-label" for="register_username">@lang('miscellaneous.username.label')</label>
                                                        </div>
@if (\Session::has('response_error') && !empty(explode('~', \Session::get('response_error'))[14]) && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[11])
                                                        <p id="username_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@else
                                                        <p id="username_error_message" class="text-end fst-italic text-muted small">@lang('miscellaneous.username.description')</p>
@endif
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- Phone -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_phone" id="register_phone" class="form-control" placeholder="@lang('miscellaneous.phone')" aria-describedby="phone_error_message" value="{{ $admin->phone }}" />
                                                            <label class="form-label" for="register_phone">@lang('miscellaneous.phone')</label>
                                                        </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[9])
                                                        <p id="phone_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6">
                                                        <!-- E-mail -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ $admin->email }}" />
                                                            <label class="form-label" for="register_email">@lang('miscellaneous.email')</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- P.O Box -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.p_o_box')" value="{{ $admin->p_o_box }}" />
                                                            <label class="form-label" for="register_p_o_box">@lang('miscellaneous.p_o_box')</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6 mx-auto">
                                                        <!-- Office -->
                                                        <div class="form-floating">
                                                            <input type="text" name="register_office" id="register_office" class="form-control" placeholder="@lang('miscellaneous.office')" value="{{ $admin->office }}" />
                                                            <label class="form-label" for="register_surname">@lang('miscellaneous.office')</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mb-3">
                                                    <div class="col-lg-6">
                                                        <!-- Address line 1 -->
                                                        <div class="form-floating">
                                                            <textarea name="register_address_1" id="register_address_1" class="form-control" placeholder="@lang('miscellaneous.address.line1')">{{ $admin->address_1 }}</textarea>
                                                            <label class="form-label" for="register_address_1">@lang('miscellaneous.address.line1')</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- Address line 2 -->
                                                        <div class="form-floating">
                                                            <textarea name="register_address_2" id="register_address_2" class="form-control" placeholder="@lang('miscellaneous.address.line2')">{{ $admin->address_2 }}</textarea>
                                                            <label class="form-label" for="register_address_2">@lang('miscellaneous.address.line2')</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3">
                                                    <div class="col-lg-6">
                                                        <!-- Password -->
                                                        <div class="form-floating">
                                                            <input type="password" name="register_password" id="register_password" class="form-control" placeholder="@lang('miscellaneous.password.label')" aria-describedby="password_error_message" {{ \Session::has('response_error') ? (explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[12] || explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[13] ? 'autofocus' : '' ) : '' }} />
                                                            <label class="form-label" for="register_password">@lang('miscellaneous.password.label')</label>
                                                        </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[12] && explode('~', \Session::get('response_error'))[12] != explode('~', \Session::get('response_error'))[9])
                                                        <p id="password_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <!-- Confirm password -->
                                                        <div class="form-floating">
                                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="@lang('miscellaneous.confirm_password.label')" aria-describedby="confirm_password_error_message" />
                                                            <label class="form-label" for="confirm_password">@lang('miscellaneous.confirm_password.label')</label>
                                                        </div>
@if (\Session::has('response_error') && explode('~', \Session::get('response_error'))[14] == explode('~', \Session::get('response_error'))[13] && explode('~', \Session::get('response_error'))[13] != explode('~', \Session::get('response_error'))[9])
                                                        <p id="confirm_password_error_message" class="text-center text-danger small">{{ explode('~', \Session::get('response_error'))[15] }}</p>
@endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-sm-3 g-2">
                                    <div class="col-lg-4 col-sm-5 ms-sm-auto">
                                        <button class="btn btn-primary btn-block rounded-pill" type="submit">@lang('miscellaneous.pages_content.account.personal_infos.link')</button>
                                    </div>

                                    <div class="col-lg-3 col-sm-4 me-sm-auto">
                                        <a href="{{ route('role.entity.home', ['entity' => 'other_admins']) }}" class="btn btn-light btn-block border rounded-pill">@lang('miscellaneous.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE ADMIN-->
