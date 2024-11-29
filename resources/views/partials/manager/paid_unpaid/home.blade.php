<?php
$api_client_manager = new \App\Http\Controllers\ApiClientManager();
?>

                <!-- PAYMENTS LIST-->
                <section class="py-4">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-6 col-sm-8 mx-auto">
                                    <div class="card mb-3 rounded-4">
                                        <div class="card-body">
                                            <form method="GET" action="{{ route('employee.entity.home', ['entity' => 'paid_unpaid']) }}">
                                                <div class="row g-2">
                                                    <div class="col-4">
                                                        <select name="month" class="form-select rounded-0">
                                                            <option class="small" disabled{{ !request()->has('month') ? ' selected' : '' }}>{{ ucfirst(__('miscellaneous.month_singular')) }}</option>
@foreach ($months as $key => $month)
                                                            <option value="{{ $key }}"{{ request()->has('month') && request()->get('month') == $key ? ' selected' : '' }}>{{ $month }}</option>
@endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <select name="year" class="form-select rounded-0">
                                                            <option class="small" disabled{{ !request()->has('year') ? ' selected' : '' }}>{{ ucfirst(__('miscellaneous.year_singular')) }}</option>
<?php
$current_year = date('Y');

for ($year = $current_year; $year >= 1900 ; $year--) {
?>
                                                            <option {{ request()->has('year') && request()->get('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
<?php
}
?>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-block btn-primary shadow-0">@lang('miscellaneous.show')</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
@if (request()->has('month') || request()->has('year'))
    @if (!request()->has('month') && request()->has('year'))
                                    <h4 class="h4 mb-3 fw-bold text-center">{{ $entity_title }}</h4>

                                    <div class="card border-bottom border-start border-end rounded-bottom rounded-start rounded-end rounded-4">
<?php
if (count($all_months_paid_unpaids) > 0) {
?>
                                        <div id="employeeDatas" class="accordion">
<?php
    foreach ($months as $key => $month) {
        $paid_unpaids = $api_client_manager::call('GET', getApiURL() . '/paid_unpaid/find_by_branch_month_year_status/' . $current_user->branches[0]->id . '/' . $key . '-' . request()->get('year') . '/Actif', getApiToken());

        if (count($paid_unpaids->data) > 0) {
?>
                                            <div class="accordion-item">
                                                <h2 id="heading_{{ $key }}" class="accordion-header">
                                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $key }}" aria-expanded="false" aria-controls="collapse_{{ $key }}">
                                                        <i class="bi bi-chevron-double-right me-2 cnpr-align-middle fs-5"></i><strong>{{ ucfirst(explicitMonth($key)) }}</strong>
                                                    </button>
                                                </h2>

                                                <div id="collapse_{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $key }}" data-bs-parent="#employeeDatas">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive">
                                                            <table class="dataList table border-top">
                                                                <thead class="bg-light">
                                                                    <tr>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid')</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
<?php
            foreach ($paid_unpaids->data as $paid_unpaid) {
                $current_employee = $api_client_manager::call('GET', getApiURL() . '/user/' . $paid_unpaid->user_id, getApiToken());
                $employee = $current_employee->data;
?>

                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-sm-flex h-100 align-items-center">
                                                                                <div class="bg-image float-start">
                                                                                    <img src="{{ !empty($employee->avatar_url) ? $employee->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                                    <div class="mask"></div>
                                                                                </div>
                                                                                {{ $employee->firstname . ' ' . $employee->lastname }}
                                                                            </div>
                                                                        </td>
                                                                        <td style="padding-top: 0.9rem">
                                                                            {{ $employee->department != null ? $employee->department->department_name : '- - - - - -' }}
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-check form-switch pt-2">
                                                                                <input type="checkbox" role="switch" name="is_paid-{{ $paid_unpaid->id }}" id="is_paid-{{ $paid_unpaid->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $paid_unpaid->is_paid == 1 ? ' checked' : '' }}>
                                                                                <label class="form-check-label align-bottom text-{{ $paid_unpaid->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid-{{ $paid_unpaid->id }}" style="margin-top: -5px;"><i class="bi bi-{{ $paid_unpaid->is_paid == 1 ? 'check' : 'x' }}-circle me-1 cnpr-align-middle fs-5"></i>{{ $paid_unpaid->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</label>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('employee.datas', ['id' => $employee->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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
<?php
        }
    }
?>
                                        </div>
<?php
} else {
?>
                                        <div class="card-body">
                                            <p class="m-0 card-text text-center">@lang('miscellaneous.empty_list')</p>
                                        </div>
<?php
}
?>
                                    </div>
    @endif

    @if (request()->has('month') && !request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-2 fw-bold text-center">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
        @forelse ($paid_unpaids as $paid_unpaid)
<?php
$current_employee = $api_client_manager::call('GET', getApiURL() . '/user/' . $paid_unpaid->user_id, getApiToken());
$employee = $current_employee->data;
?>

                                                        <tr>
                                                            <td>
                                                                <div class="d-sm-flex h-100 align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->avatar_url) ? $employee->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->firstname . ' ' . $employee->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">
                                                                {{ $employee->department != null ? $employee->department->department_name : '- - - - - -' }}
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch pt-2">
                                                                    <input type="checkbox" role="switch" name="is_paid-{{ $paid_unpaid->id }}" id="is_paid-{{ $paid_unpaid->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $paid_unpaid->is_paid == 1 ? ' checked' : '' }}>
                                                                    <label class="form-check-label align-bottom text-{{ $paid_unpaid->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid-{{ $paid_unpaid->id }}" style="margin-top: -5px;"><i class="bi bi-{{ $paid_unpaid->is_paid == 1 ? 'check' : 'x' }}-circle me-1 cnpr-align-middle fs-5"></i>{{ $paid_unpaid->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('employee.datas', ['id' => $employee->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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

    @if (request()->has('month') && request()->has('year'))
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-2 fw-bold text-center">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
        @forelse ($paid_unpaids as $paid_unpaid)
<?php
$current_employee = $api_client_manager::call('GET', getApiURL() . '/user/' . $paid_unpaid->user_id, getApiToken());
$employee = $current_employee->data;
?>

                                                        <tr>
                                                            <td>
                                                                <div class="d-sm-flex h-100 align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->avatar_url) ? $employee->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->firstname . ' ' . $employee->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">
                                                                {{ $employee->department != null ? $employee->department->department_name : '- - - - - -' }}
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch pt-2">
                                                                    <input type="checkbox" role="switch" name="is_paid-{{ $paid_unpaid->id }}" id="is_paid-{{ $paid_unpaid->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $paid_unpaid->is_paid == 1 ? ' checked' : '' }}>
                                                                    <label class="form-check-label align-bottom text-{{ $paid_unpaid->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid-{{ $paid_unpaid->id }}" style="margin-top: -5px;"><i class="bi bi-{{ $paid_unpaid->is_paid == 1 ? 'check' : 'x' }}-circle me-1 cnpr-align-middle fs-5"></i>{{ $paid_unpaid->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('employee.datas', ['id' => $employee->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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
@else
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <h4 class="h4 mb-2 fw-bold text-center">{{ $entity_title }}</h4>

                                            <div class="table-responsive">
                                                <table id="dataList" class="table border-top">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                            <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid')</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
    @forelse ($paid_unpaids as $paid_unpaid)
<?php
$current_employee = $api_client_manager::call('GET', getApiURL() . '/user/' . $paid_unpaid->user_id, getApiToken());
$employee = $current_employee->data;
?>

                                                        <tr>
                                                            <td>
                                                                <div class="d-sm-flex h-100 align-items-center">
                                                                    <div class="bg-image float-start">
                                                                        <img src="{{ !empty($employee->avatar_url) ? $employee->avatar_url : asset('assets/img/user.png') }}" alt="" width="35" class="rounded-circle me-3">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    {{ $employee->firstname . ' ' . $employee->lastname }}
                                                                </div>
                                                            </td>
                                                            <td style="padding-top: 0.9rem">
                                                                {{ $employee->department != null ? $employee->department->department_name : '- - - - - -' }}
                                                            </td>
                                                            <td>
                                                                <div class="form-check form-switch pt-2">
                                                                    <input type="checkbox" role="switch" name="is_paid-{{ $paid_unpaid->id }}" id="is_paid-{{ $paid_unpaid->id }}" class="form-check-input" onchange="changeIs('paid_unpaid', this)"{{ $paid_unpaid->is_paid == 1 ? ' checked' : '' }}>
                                                                    <label class="form-check-label align-bottom text-{{ $paid_unpaid->is_paid == 1 ? 'success' : 'danger' }}" for="is_paid-{{ $paid_unpaid->id }}" style="margin-top: -5px;"><i class="bi bi-{{ $paid_unpaid->is_paid == 1 ? 'check' : 'x' }}-circle me-1 cnpr-align-middle fs-5"></i>{{ $paid_unpaid->is_paid == 1 ? __('miscellaneous.yes') : __('miscellaneous.no') }}</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('employee.datas', ['id' => $employee->id]) }}" class="btn btn-sm btn-link py-1 text-decoration-underline">@lang('miscellaneous.details')<i class="bi bi-chevron-double-right ms-2"></i></a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END PAYMENTS LIST-->
