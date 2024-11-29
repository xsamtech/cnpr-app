<?php
$api_client_manager = new \App\Http\Controllers\ApiClientManager();
?>

                <!-- PRESENCES LIST-->
                <section class="py-4">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-7 col-sm-9 mx-auto">
                                    <div class="card mb-3 rounded-4">
                                        <div class="card-body">
                                            <form method="GET" action="{{ route('employee.entity.home', ['entity' => 'presence_absence']) }}">
                                                <div class="row g-2">
                                                    <div class="col-lg-2 col-sm-2 col-5">
                                                        <select name="day" class="form-select rounded-0">
                                                            <option class="small" disabled{{ !request()->has('day') ? ' selected' : '' }}>{{ ucfirst(__('miscellaneous.day_singular')) }}</option>
@foreach ($days as $day)
                                                            <option {{ request()->has('day') && request()->get('day') == $day ? ' selected' : '' }}>{{ $day }}</option>
@endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-sm-4 col-7">
                                                        <select name="month" class="form-select rounded-0">
                                                            <option class="small" disabled{{ !request()->has('month') ? ' selected' : '' }}>{{ ucfirst(__('miscellaneous.month_singular')) }}</option>
@foreach ($months as $key => $month)
                                                            <option value="{{ $key }}" {{ request()->has('month') && request()->get('month') == $key ? ' selected' : '' }}>{{ $month }}</option>
@endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3 col-5">
                                                        <select name="year" class="form-select rounded-0">
                                                            <option class="small" disabled{{ !request()->has('year') ? ' selected' : '' }}>{{ ucfirst(__('miscellaneous.year_singular')) }}</option>
<?php
$current_year = date('Y');

for ($year = $current_year; $year >= 1900 ; $year--) {
?>
                                                            <option {{ request()->has('year') && request()->get('year') == $year ? ' selected' : '' }}>{{ $year }}</option>
<?php
}
?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3 col-sm-3 col-7 d-flex">
                                                        <button type="submit" class="btn btn-block btn-primary shadow-0">@lang('miscellaneous.show')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
@if (request()->has('day') && request()->has('month') && request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-3 text-center fw-bold">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
    @forelse ($employees_present_absent as $employee)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->user->firstname . ' ' . $employee->user->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                            <td>
        @if ($employee->status->status_name == 'Opérationnel')
            @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
@endif

@if (!request()->has('day') && request()->has('month') && request()->has('year'))
                                    <h4 class="h4 mb-3 fw-bold text-center">{{ $entity_title }}</h4>

                                    <div class="card border-bottom border-start border-end rounded-bottom rounded-start rounded-end rounded-4">
    @if (count($employees_present_absent) > 0)
                                        <div id="employeeDatas" class="accordion">
        @forelse ($days as $day)
<?php
$employees_present_absent_date = $api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $current_user->branches[0]->id . '/' . request()->get('year') . '-' . request()->get('month') . '-' . $day, getApiToken());
$employees_present_absent_date = $employees_present_absent_date->data;
?>
            @if (count($employees_present_absent_date) > 0)
                                            <div class="accordion-item">
                                                <h2 id="heading_{{ request()->get('month') . '-' . $day }}" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ request()->get('month') . '-' . $day }}" aria-expanded="false" aria-controls="collapse_{{ request()->get('month') . '-' . $day }}">
                                                        <i class="bi bi-calendar-event me-2 cnpr-align-middle fs-5"></i><strong>{{ ucfirst(explicitDate(request()->get('year') . '-' . request()->get('month') . '-' . $day)) }}</strong>
                                                    </button>
                                                </h2>

                                                <div id="collapse_{{ request()->get('month') . '-' . $day }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ request()->get('month') . '-' . $day }}" data-bs-parent="#employeeDatas">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="dataList table border-top">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                @forelse ($employees_present_absent_date as $employee)
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
                                                                        <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                                        <td>
                    @if ($employee->status->status_name == 'Opérationnel')
                        @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
                                                                        <td>
                                                                            <a href="{{ route('employee.datas', ['id' => $employee->user->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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
            @endif
        @empty
        @endforelse
                                        </div>

    @else
                                        <div class="card-body">
                                            <p class="m-0 card-text text-center">@lang('miscellaneous.empty_list')</p>
                                        </div>
    @endif
                                    </div>
@endif

@if (request()->has('day') && !request()->has('month') && request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-3 text-center fw-bold">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
    @forelse ($employees_present_absent as $employee)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->user->firstname . ' ' . $employee->user->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                            <td>
        @if ($employee->status->status_name == 'Opérationnel')
            @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
@endif

@if (request()->has('day') && request()->has('month') && !request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-3 text-center fw-bold">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
    @forelse ($employees_present_absent as $employee)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->user->firstname . ' ' . $employee->user->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                            <td>
        @if ($employee->status->status_name == 'Opérationnel')
            @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
@endif

@if (request()->has('day') && !request()->has('month') && !request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-3 text-center fw-bold">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
    @forelse ($employees_present_absent as $employee)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->user->firstname . ' ' . $employee->user->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                            <td>
        @if ($employee->status->status_name == 'Opérationnel')
            @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
@endif

@if (!request()->has('day') && request()->has('month') && !request()->has('year'))
                                    <h4 class="h4 mb-3 fw-bold text-center">{{ $entity_title }}</h4>

                                    <div class="card border-bottom border-start border-end rounded-bottom rounded-start rounded-end rounded-4">
    @if (count($employees_present_absent) > 0)
                                        <div id="employeeDatas" class="accordion">
        @forelse ($days as $day)
<?php
$employees_present_absent_date = $api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $current_user->branches[0]->id . '/' . date('Y') . '-' . request()->get('month') . '-' . $day, getApiToken());
$employees_present_absent_date = $employees_present_absent_date->data;
?>
            @if (count($employees_present_absent_date) > 0)
                                            <div class="accordion-item">
                                                <h2 id="heading_{{ request()->get('month') . '-' . $day }}" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ request()->get('month') . '-' . $day }}" aria-expanded="false" aria-controls="collapse_{{ request()->get('month') . '-' . $day }}">
                                                        <i class="bi bi-calendar-event me-2 cnpr-align-middle fs-5"></i><strong>{{ ucfirst(explicitDate(date('Y') . '-' . request()->get('month') . '-' . $day)) }}</strong>
                                                    </button>
                                                </h2>

                                                <div id="collapse_{{ request()->get('month') . '-' . $day }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ request()->get('month') . '-' . $day }}" data-bs-parent="#employeeDatas">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="dataList table border-top">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                @forelse ($employees_present_absent_date as $employee)
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
                                                                        <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                                        <td>
                    @if ($employee->status->status_name == 'Opérationnel')
                        @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
                                                                        <td>
                                                                            <a href="{{ route('employee.datas', ['id' => $employee->user->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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
            @endif
        @empty
        @endforelse
                                        </div>

    @else
                                        <div class="card-body">
                                            <p class="m-0 card-text text-center">@lang('miscellaneous.empty_list')</p>
                                        </div>
    @endif
                                    </div>
@endif

@if (!request()->has('day') && !request()->has('month') && request()->has('year'))
                                    <h4 class="h4 mb-3 fw-bold text-center">{{ $entity_title }}</h4>

                                    <div class="card border-bottom border-start border-end rounded-bottom rounded-start rounded-end rounded-4">
    @if (count($employees_present_absent_year) > 0)
                                        <div id="employeeDatas" class="accordion">
        @forelse ($months as $key => $month)
<?php
$employees_present_absent_monthyear = $api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_month_year/' . $current_user->branches[0]->id . '/' . $key . '-' . request()->get('year'), getApiToken());
$employees_present_absent_month_year = $employees_present_absent_monthyear->data;
?>
            @if (count($employees_present_absent_month_year) > 0)
                                            <div class="accordion-item">
                                                <h2 id="heading_{{ $key }}" class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $key }}" aria-expanded="false" aria-controls="collapse_{{ $key }}">
                                                        <i class="bi bi-chevron-double-right me-2 cnpr-align-middle fs-5"></i><strong>{{ explicitMonth($key) }}</strong>
                                                    </button>
                                                </h2>

                                                <div id="collapse_{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $key }}" data-bs-parent="#employeeDatas">
                                                    <div class="accordion-body">
                                                        <div id="employeeDatas_{{ $key }}" class="accordion">
                @forelse ($days as $day)
<?php
$employees_present_absent_date = $api_client_manager::call('GET', getApiURL() . '/presence_absence/find_by_branch_date/' . $current_user->branches[0]->id . '/' . request()->get('year') . '-' . $key . '-' . $day, getApiToken());
$employees_present_absent_date = $employees_present_absent_date->data;
?>
                    @if (count($employees_present_absent_date) > 0)
                                                            <div class="accordion-item">
                                                                <h2 id="heading_{{ request()->get('year') . '-' . $key . '-' . $day }}" class="accordion-header">
                                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ request()->get('year') . '-' . $key . '-' . $day }}" aria-expanded="false" aria-controls="collapse_{{ request()->get('year') . '-' . $key . '-' . $day }}">
                                                                        <i class="bi bi-calendar-event me-2 cnpr-align-middle fs-5"></i><strong>{{ explicitDate(request()->get('year') . '-' . $key . '-' . $day) }}</strong>
                                                                    </button>
                                                                </h2>

                                                                <div id="collapse_{{ request()->get('year') . '-' . $key . '-' . $day }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ request()->get('year') . '-' . $key . '-' . $day }}" data-bs-parent="#employeeDatas_{{ $key }}">
                                                                    <div class="accordion-body">
                                                                        <div class="table-responsive">
                                                                            <table class="dataList table border-top">
                                                                                <thead class="bg-light">
                                                                                    <tr>
                                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                                                        <th></th>
                                                                                    </tr>
                                                                                </thead>

                                                                                <tbody>
                        @forelse ($employees_present_absent_date as $employee)
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
                                                                                        <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
                                                                                        <td>
                            @if ($employee->status->status_name == 'Opérationnel')
                                @if (inArrayR(\Carbon\Carbon::createFromFormat('Y-m-d', $employee->daytime)->format('m-d'), $year_vacations, 'day_month'))
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
                                                                                        <td>
                                                                                            <a href="{{ route('employee.datas', ['id' => $employee->user->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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
                    @endif

                @empty
                @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            @endif
        @empty
        @endforelse
                                        </div>

    @else
                                        <div class="card-body">
                                            <p class="m-0 card-text text-center">@lang('miscellaneous.empty_list')</p>
                                        </div>
    @endif
                                    </div>
@endif

@if (!request()->has('day') && !request()->has('month') && !request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-3 text-center fw-bold">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.data.is_present')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
    
                                                    <tbody>
    @forelse ($employees_present_absent_today as $employee)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->user->avatar_url) ? $employee->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->user->firstname . ' ' . $employee->user->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">{{ $employee->user->department != null ? $employee->user->department->department_name : '- - - - - -' }}</td>
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
                                                            <td>
                                                                <a href="{{ route('employee.datas', ['id' => $employee->user->id]) }}" class="btn btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
                                                            </td>
                                                        </tr>
    @empty
                                                        <tr>
                                                            <td colspan="4" class="text-center"><small>@lang('miscellaneous.empty_list')</small></td>
                                                        </tr>
    @endforelse
                                                    </tbody>
    
                                                </table>
                                            </div>    
                                        </div>
                                    </div>
@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END PRESENCES LIST-->
