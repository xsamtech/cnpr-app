
                <!-- EMPLOYEES LIST-->
                <section class="py-4">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-2 fw-bold text-center">@lang('miscellaneous.pages_content.manager.home.employees.list')</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present_current')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid_current')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
    
                                                    <tbody>
@forelse ($all_employees as $employee)
                                                        <tr>
                                                            <td>
                                                                <div class="d-sm-flex h-100 align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->user->firstname . ' ' . $employee->user->lastname }}
                                                                </div>
                                                            </td>
                                                            <td>
    @if ($employee->status->status_name == 'Opérationnel')
        @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $this_year_vacations, 'day_month'))
                                                                <div class="badge badge-success mt-1 pb-2 text-success fs-6">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.rest')</div>
        @else
                                                                <div class="form-check form-switch pt-2">
                                                                    <input type="checkbox" role="switch" name="is_present-{{ $employee->id }}" id="is_present-{{ $employee->id }}" class="form-check-input" onchange="changeIs('presence_absence', this)"{{ $employee->is_present == 1 ? ' checked' : '' }}>
                                                                    <label class="form-check-label align-bottom text-{{ $employee->is_present == 1 ? 'success' : 'danger' }}" for="is_present-{{ $employee->id }}" style="margin-top: -5px;"><i class="bi bi-{{ $employee->is_present == 1 ? 'check' : 'x' }}-circle me-1 cnpr-align-middle fs-5"></i>{{ $employee->is_present == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</label>
                                                                </div>
        @endif
    @else
                                                                <div class="badge badge-{{ $employee->status->color }} mt-1 pb-2 text-{{ $employee->status->color }} fs-6">{{ $employee->status->status_name }}</div>
    @endif
                                                            </td>
    @forelse ($employee->user->paid_unpaids as $payment)
        @if ($payment->month_year == date('m-Y'))
                                                            <td>
                                                                <div class="form-check form-switch pt-2">
                                                                    <input type="checkbox" role="switch" name="is_paid-{{ $payment->id }}" id="is_paid-{{ $payment->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $payment->is_paid == 1 ? ' checked' : '' }}>
                                                                    <label class="form-check-label align-bottom text-{{ $payment->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid-{{ $payment->id }}" style="margin-top: -5px;"><i class="bi bi-{{ $payment->is_paid == 1 ? 'check' : 'x' }}-circle me-1 cnpr-align-middle fs-5"></i>{{ $payment->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</label>
                                                                </div>
                                                            </td>
        @endif
    @empty
                                                            <td>
                                                                <h5 class="h5"><div class="badge badge-danger">- - - - - - -</div></h5>
                                                            </td>
    @endforelse
                                                            <td>
                                                                <a href="{{ route('employee.datas', ['id' => $employee->user->id]) }}" class="btn btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
                                                            </td>
                                                        </tr>
@empty
@endforelse
                                                    </tbody>
    
                                                </table>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('employee.home') }}">
@csrf
                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <h4 class="h4 mt-0 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.manager.home.employees.add')</h4>
    
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-5 col-11 mx-auto">
                                                <div class="card rounded-0">
                                                    <div id="otherUserImageWrapper" class="card-body pb-4 text-center">
                                                        <p class="card-text m-0">@lang('miscellaneous.pages_content.account.personal_infos.click_to_change_picture')</p>
    
                                                        <div class="bg-image hover-overlay mt-3">
                                                            <img src="{{ asset('assets/img/user.png') }}" alt="" class="other-user-image img-fluid rounded-4">
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
    
                                            <div class="col-lg-8 col-sm-7">
                                                <div class="card border-0 rounded-4">
                                                    <div class="card-body pt-0">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Number -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_number" id="register_number" class="form-control" placeholder="@lang('miscellaneous.number')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[0] : '' }}" {{ \Session::has('response_error') ? 'autofocus' : '' }}/>
                                                                    <label class="form-label" for="register_number">@lang('miscellaneous.number')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- First name -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" aria-describedby="firstname_error_message" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[1] : '' }}" />
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
                                                                    <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[2] : '' }}" />
                                                                    <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Surname -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[3] : '' }}" />
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
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Gender -->
                                                                <div class="text-center">
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
                                                            </div>
                                                        </div>
    
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Username -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_username" id="register_username" class="form-control" placeholder="@lang('miscellaneous.username.label')" aria-describedby="username_error_message" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[11] : '' }}" />
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
                                                                    <input type="text" name="register_phone" id="register_phone" class="form-control" placeholder="@lang('miscellaneous.phone')" aria-describedby="phone_error_message" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[9] : '' }}" />
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
                                                                    <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[10] : '' }}" />
                                                                    <label class="form-label" for="register_email">@lang('miscellaneous.email')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- P.O Box -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.p_o_box')" value="{{ \Session::has('response_error') ? explode('~', \Session::get('response_error'))[8] : '' }}" />
                                                                    <label class="form-label" for="register_p_o_box">@lang('miscellaneous.p_o_box')</label>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Choose department -->
                                                                <div class="form-floating">
                                                                    <select name="department_id" id="department_id" class="form-select pt-2 rounded-0">
                                                                        <option class="small" selected disabled>@lang('miscellaneous.department')</option>
@forelse ($departments as $department)
                                                                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
@empty
                                                                        <option>@lang('miscellaneous.empty_list')</option>
@endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Office -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_office" id="register_office" class="form-control" placeholder="@lang('miscellaneous.office')" />
                                                                    <label class="form-label" for="register_surname">@lang('miscellaneous.office')</label>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Address line 1 -->
                                                                <div class="form-floating">
                                                                    <textarea name="register_address_1" id="register_address_1" class="form-control" placeholder="@lang('miscellaneous.address.line1')"></textarea>
                                                                    <label class="form-label" for="register_address_1">@lang('miscellaneous.address.line1')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Address line 2 -->
                                                                <div class="form-floating">
                                                                    <textarea name="register_address_2" id="register_address_2" class="form-control" placeholder="@lang('miscellaneous.address.line2')"></textarea>
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
    
                                            <div class="col-lg-6 col-sm-8 mx-auto">
                                                <button class="btn btn-primary mb-4 btn-block rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
                <!-- END EMPLOYEES LIST-->
