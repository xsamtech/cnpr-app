
                <!-- UPDATE EMPLOYEE-->
                <section class="pt-4 pb-5">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
@if ($employee->user->branches[0]->id != $current_user->branches[0]->id)
                            <div class="row">
                                <div class="col-lg-6 col-sm-8 mx-auto">
                                    <div class="card rounded-5">
                                        <div class="card-body py-5 text-center">
                                            <h1 class="display-2 mb-2 fw-bold text-info"><i class="bi bi-info-circle"></i></h1>
                                            <h1 class="h1 mb-2 fw-bold">@lang('miscellaneous.pages_content.manager.home.employees.intrusion.title')</h1>
                                            <p class="mb-4">@lang('miscellaneous.pages_content.manager.home.employees.intrusion.description')</p>
                                            <a href="{{ route('employee.home') }}" class="btn btn-warning rounded-pill py-2 px-5">
                                                @lang('miscellaneous.pages_content.manager.home.employees.intrusion.link')
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
@else
                            <form method="POST" action="{{ route('employee.datas', ['id' => $employee->user->id]) }}">
    @csrf
                                <input type="hidden" name="user_id" value="{{ $employee->user->id }}">

                                <div class="card rounded-4">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-8 col-sm-7 col-11 mx-auto">
                                                <h4 class="h4 mt-0 mb-sm-0 mb-2 text-sm-start text-center fw-bold">@lang('miscellaneous.pages_content.manager.home.employees.edit')</h4>
                                            </div>
                                            <div class="col-lg-4 col-sm-5 col-11 mx-auto">
                                                <!-- Employee status -->
                                                <div class="input-group">
                                                    <label class="input-group-text h-100 rounded-0" for="status_id">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.status')</label>
                                                    <select role="button" name="status_id" id="status_id" class="form-select pt-1 rounded-0" data-cnpr-presence="{{ $employee->id }}" data-cnpr-user="{{ $employee->user->id }}" onchange="changeStatus('employee', this);">
    @forelse ($employee_statuses as $status)
                                                        <option value="{{ $status->id }}"{{ $employee->status->id == $status->id ?  ' selected' : ''}}>{{ $status->status_name }}</option>
    @empty
                                                        <option>@lang('miscellaneous.empty_list')</option>
    @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-sm-5 col-11 mx-auto">
                                                <div class="card rounded-0">
                                                    <div id="otherUserImageWrapper" class="card-body pb-4 text-center">
                                                        <p class="card-text m-0">@lang('miscellaneous.pages_content.account.personal_infos.click_to_change_picture')</p>
    
                                                        <div class="bg-image hover-overlay mt-3">
                                                            <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" class="other-user-image img-fluid rounded-4">
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

                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present_current')</small>
    @if ($employee->status->status_name == 'Opérationnel')
        @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $this_year_vacations, 'day_month'))
                                                            <div class="badge badge-success mt-1 pb-2 text-success">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.rest')</div>
        @else
                                                            <div class="form-check form-switch pt-1 pb-0">
                                                                <input type="checkbox" role="switch" name="is_present1-{{ $employee->id }}" id="is_present1-{{ $employee->id }}" class="form-check-input" onchange="changeIs('presence_absence', this)"{{ $employee->is_present == 1 ? ' checked' : '' }}>
                                                                <label class="form-check-label align-bottom text-{{ $employee->is_present == 1 ? 'success' : 'danger' }}" for="is_present1-{{ $employee->id }}">
                                                                    <i class="bi bi-{{ $employee->is_present == 1 ? 'check' : 'x' }}-circle position-relative" style="top: -1.65px;"></i>
                                                                    <small class="d-inline-block position-relative" style="top: -1.8px;">{{ $employee->is_present == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</small>
                                                                </label>
                                                            </div>
        @endif
    @else
                                                            <div class="badge badge-{{ $employee->status->color }} mt-1 pb-2 text-{{ $employee->status->color }}">{{ $employee->status->status_name }}</div>
    @endif
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid_current')</small>
    @forelse ($employee->user->paid_unpaids as $payment)
        @if ($payment->month_year == date('m-Y'))
                                                            <div class="form-check form-switch pt-1 pb-0">
                                                                <input type="checkbox" role="switch" name="is_paid1-{{ $payment->id }}" id="is_paid1-{{ $payment->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $payment->is_paid == 1 ? ' checked' : '' }}>
                                                                <label class="form-check-label align-bottom text-{{ $payment->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid1-{{ $payment->id }}">
                                                                    <i class="bi bi-{{ $payment->is_paid == 1 ? 'check' : 'x' }}-circle position-relative" style="top: -1.6px;"></i>
                                                                    <small class="d-inline-block position-relative" style="top: -1.8px;">{{ $payment->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</small>
                                                                </label>
                                                            </div>
        @endif
    @empty
                                                            <h5 class="h5"><div class="badge badge-danger">- - - - - - -</div></h5>
    @endforelse
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">@lang('miscellaneous.is_department_chief.label')</small>
                                                            <div class="form-check form-switch pt-1 pb-0" title="{{ !empty($employee->user->department) ? __('miscellaneous.is_department_chief.description') : __('miscellaneous.is_department_chief.error', ['firstname' => $employee->user->firstname]) }}" data-bs-toggle="tooltip" data-bs-placement="right">
                                                                <input type="checkbox" role="switch" name="is_department_chief-{{ $employee->user->id }}" id="is_department_chief-{{ $employee->user->id }}" class="form-check-input" onchange="changeIs('department_chief', this)"{{ $employee->user->is_department_chief == 1 ? ' checked' : '' }}{{ !empty($employee->user->department) ? '' : ' disabled' }}>
                                                                <label class="form-check-label align-bottom text-{{ $employee->user->is_department_chief == 1 ? 'success' : 'danger' }}" for="is_department_chief-{{ $employee->user->id }}">
                                                                    <i class="bi bi-{{ $employee->user->is_department_chief == 1 ? 'check' : 'x' }}-circle position-relative" style="top: -1.6px;"></i>
                                                                    <small class="d-inline-block position-relative" style="top: -1.8px;">{{ $employee->user->is_department_chief == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</small>
                                                                </label>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item border-bottom-0">
    @if ($qr_code == null)
                                                            <p class="card-text small fst-italic text-primary">@lang('miscellaneous.qr_code_error')</p>
    @else
                                                            <div class="bg-image">
                                                                <img src="{{ $qr_code }}" alt="@lang('miscellaneous.pages_content.manager.home.employees.qr_code')" class="qr-code img-fluid rounded-4">
                                                                <div class="mask"></div>
                                                            </div>
    @endif
                                                        </li>
                                                        <li class="list-group-item pt-2 pb-3">
                                                            <a role="button" id="accountActivation" class="employee-locking btn btn-block btn-outline-{{ $employee->user->status->status_name == 'Actif' ? 'danger' : 'success' }} rounded-pill py-2" data-cnpr-user="{{ $employee->user->id }}" data-cnpr-status="{{ $employee->user->status->status_name }}" title="@lang('miscellaneous.pages_content.account.locked.explain')" data-bs-toggle="tooltip" data-bs-placement="right">
                                                                <i class="bi bi-{{ $employee->user->status->status_name == 'Actif' ? 'x' : 'check' }}-circle-fill me-2 cnpr-align-middle fs-4"></i>{{ $employee->user->status->status_name == 'Actif' ? __('miscellaneous.pages_content.account.locked.link_do', ['firstname' => $employee->user->firstname]) : __('miscellaneous.pages_content.account.locked.link_undo', ['firstname' => $employee->user->firstname]) }}
                                                            </a>    
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-lg-8 col-sm-7">
                                                <div class="card border-0 rounded-4">
                                                    <div class="card-body pt-sm-0 pe-sm-0">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Number -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_number" id="register_number" class="form-control" placeholder="@lang('miscellaneous.number')" value="{{ $employee->user->number }}" />
                                                                    <label class="form-label" for="register_number">@lang('miscellaneous.number')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- First name -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_firstname" id="register_firstname" class="form-control" placeholder="@lang('miscellaneous.firstname')" aria-describedby="firstname_error_message" value="{{ $employee->user->firstname }}" />
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
                                                                    <input type="text" name="register_lastname" id="register_lastname" class="form-control" placeholder="@lang('miscellaneous.lastname')" value="{{ $employee->user->lastname }}" />
                                                                    <label class="form-label" for="register_lastname">@lang('miscellaneous.lastname')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Surname -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_surname" id="register_surname" class="form-control" placeholder="@lang('miscellaneous.surname')" value="{{ $employee->user->surname }}" />
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
                                                                            <input type="text" name="register_birth_city" id="register_birth_city" class="form-control" placeholder="@lang('miscellaneous.birth_city')" value="{{ $employee->user->birth_city }}" />
                                                                            <label class="form-label" for="register_birth_city">@lang('miscellaneous.birth_city')</label>
                                                                        </div>
                                                                    </div>
    
                                                                    <div class="col-sm-5">
                                                                        <div class="form-floating mt-sm-0 mt-2">
                                                                            <input type="text" name="register_birth_date" id="register_birthdate" class="form-control" placeholder="@lang('miscellaneous.birth_date.label')" value="{{ !empty($employee->user->birth_date) ? str_starts_with(app()->getLocale(), 'fr') ? \Carbon\Carbon::createFromFormat('Y-m-d', $employee->user->birth_date)->format('d/m/Y') : \Carbon\Carbon::createFromFormat('Y-m-d', $employee->user->birth_date)->format('m/d/Y') : null }}" />
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
                                                                        <input class="form-check-input" type="radio" name="register_gender" id="male" value="M"{{ $employee->user->gender == 'M' ? ' checked' : '' }}>
                                                                        <label class="form-check-label" for="male">@lang('miscellaneous.gender1')</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="register_gender" id="female" value="F"{{ $employee->user->gender == 'F' ? ' checked' : '' }}>
                                                                        <label class="form-check-label" for="female">@lang('miscellaneous.gender2')</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Username -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_username" id="register_username" class="form-control" placeholder="@lang('miscellaneous.username.label')" aria-describedby="username_error_message" value="{{ $employee->user->username }}" />
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
                                                                    <input type="text" name="register_phone" id="register_phone" class="form-control" placeholder="@lang('miscellaneous.phone')" aria-describedby="phone_error_message" value="{{ $employee->user->phone }}" />
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
                                                                    <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.email')" value="{{ $employee->user->email }}" />
                                                                    <label class="form-label" for="register_email">@lang('miscellaneous.email')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- P.O Box -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.p_o_box')" value="{{ $employee->user->p_o_box }}" />
                                                                    <label class="form-label" for="register_p_o_box">@lang('miscellaneous.p_o_box')</label>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Choose department -->
                                                                <div class="form-floating">
                                                                    <select name="department_id" id="department_id" class="form-select pt-2 rounded-0">
                                                                        <option class="small"{{ $employee->user->department == null ? ' selected' : '' }} disabled>@lang('miscellaneous.department')</option>
    @forelse ($departments as $department)
                                                                        <option value="{{ $department->id }}"{{ $employee->user->department != null ? ($department->id == $employee->user->department->id ? ' selected' : '') : ''}}>{{ $department->department_name }}</option>
    @empty
                                                                        <option>@lang('miscellaneous.empty_list')</option>
    @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Office -->
                                                                <div class="form-floating">
                                                                    <input type="text" name="register_office" id="register_office" class="form-control" placeholder="@lang('miscellaneous.office')" value="{{ $employee->user->office }}" />
                                                                    <label class="form-label" for="register_surname">@lang('miscellaneous.office')</label>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-lg-6">
                                                                <!-- Address line 1 -->
                                                                <div class="form-floating">
                                                                    <textarea name="register_address_1" id="register_address_1" class="form-control" placeholder="@lang('miscellaneous.address.line1')">{{ $employee->user->address_1 }}</textarea>
                                                                    <label class="form-label" for="register_address_1">@lang('miscellaneous.address.line1')</label>
                                                                </div>
                                                            </div>
    
                                                            <div class="col-lg-6">
                                                                <!-- Address line 2 -->
                                                                <div class="form-floating">
                                                                    <textarea name="register_address_2" id="register_address_2" class="form-control" placeholder="@lang('miscellaneous.address.line2')">{{ $employee->user->address_2 }}</textarea>
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
                                                <button class="btn btn-primary btn-block rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('employee.home') }}" class="btn btn-light mb-4 btn-block border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mt-0 mb-4 text-center cnpr-font-weight-600">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.presences_month', ['month' => explicitMonth(\Carbon\Carbon::now()->month)])</h4>

                                            <div class="row g-2">
    @forelse ($presences_month_year as $presence)
                                                <div class="col-lg-6">
                                                    <div class="border bg-light p-2 rounded-4 text-center">
                                                        <h6 class="mb-1 cnpr-font-weight-700">{{ explicitDate($presence->daytime) }}</h6>
        @if ($presence->status->status_name == 'Opérationnel')
            @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $presence->daytime)->format('m-d'), $this_year_vacations, 'day_month'))
                                                            <div class="badge badge-success mt-1 pb-2 text-success">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.rest')</div>
            @else
                                                            <div class="d-flex justify-content-center form-check form-switch pt-1 pb-0">
                                                                <input type="checkbox" role="switch" name="is_present2-{{ $presence->id }}" id="is_present2-{{ $presence->id }}" class="form-check-input" onchange="changeIs('presence_absence', this)"{{ $presence->is_present == 1 ? ' checked' : '' }}>
                                                                <label class="form-check-label align-bottom text-{{ $presence->is_present == 1 ? 'success' : 'danger' }}" for="is_present2-{{ $presence->id }}">
                                                                    <i class="bi bi-{{ $presence->is_present == 1 ? 'check' : 'x' }}-circle position-relative" style="top: -1.65px;"></i>
                                                                    <span class="d-inline-block position-relative" style="top: -1.8px;">{{ $presence->is_present == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</span>
                                                                </label>
                                                            </div>
            @endif
        @else
                                                            <div class="badge badge-{{ $presence->status->color }} mt-1 pb-2 text-{{ $presence->status->color }}">{{ $presence->status->status_name }}</div>
    @endif

                                                    </div>
                                                </div>
    @empty
    @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mt-0 mb-4 text-center cnpr-font-weight-600">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.payments_year', ['year' => date('Y')])</h4>

                                            <div class="table-responsive">
                                                <table class="border-top border-start border-end table">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>{{ ucfirst(__('miscellaneous.month_singular')) }}</th>
                                                            <th>@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid')</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
<?php
foreach ($months as $key => $month) {
    $api_client_manager = new \App\Http\Controllers\ApiClientManager();
    $payment_month_year = $api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_user_month_year/' . $employee->user->id . '/' . $key . '-' . date('Y'), getApiToken());
?>
                                                        <tr>
                                                            <td>{{ $month }}</td>
                                                            <td>
<?php
    if (!empty($payment_month_year->data)) {
        $payment = $payment_month_year->data
?>
                                                                <div class="form-check form-switch pt-1 pb-0">
                                                                    <input type="checkbox" role="switch" name="is_paid2-{{ $payment->id }}" id="is_paid2-{{ $payment->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $payment->is_paid == 1 ? ' checked' : '' }}>
                                                                    <label class="form-check-label align-bottom text-{{ $payment->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid2-{{ $payment->id }}">
                                                                        <i class="bi bi-{{ $payment->is_paid == 1 ? 'check' : 'x' }}-circle position-relative" style="top: -1.6px;"></i>
                                                                        <small class="d-inline-block position-relative" style="top: -1.8px;">{{ $payment->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</small>
                                                                    </label>
                                                                </div>
<?php
    } else {
?>
                                                                <div class="d-flex align-items-center">
                                                                    <h6 class="h6 m-0">- - - - - - -</h6>
                                                                </div>
<?php
    }
?>
                                                            </td>
                                                        </tr>
<?php
}
?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
@endif
                        </div>
                    </div>
                </section>
                <!-- END UPDATE EMPLOYEE-->
