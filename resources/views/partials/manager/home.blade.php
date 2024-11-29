
                <!-- STATISTIC-->
                <section class="statistic">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="statistic__item rounded-4">
                                        <h2 class="number">{{ formatIntegerNumber(count($all_employees)) }}</h2>
                                        <span class="desc text-black">
                                            {{ count($all_employees) > 1 ? __('miscellaneous.pages_content.manager.home.statistics.total_employees') : __('miscellaneous.pages_content.manager.home.statistics.total_employee') }}
                                        </span>
                                        <div class="icon">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <a href="{{ route('employee.home') }}" class="stretched-link"></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="statistic__item rounded-4">
                                        <h2 class="number">{{ formatIntegerNumber(count($employees_present_today)) }}</h2>
                                        <span class="desc text-black">
                                            {{ count($employees_present_today) > 1 ? __('miscellaneous.pages_content.manager.home.statistics.employees_presents') : __('miscellaneous.pages_content.manager.home.statistics.employee_present') }}
                                        </span>
                                        <div class="icon">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                        <a href="{{ route('employee.entity.home', ['entity' => 'presence_absence']) }}" class="stretched-link"></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="statistic__item rounded-4">
                                        <h2 class="number">{{ formatIntegerNumber(count($employees_absent_today)) }}</h2>
                                        <span class="desc text-black">
                                            {{ count($employees_absent_today) > 1 ? __('miscellaneous.pages_content.manager.home.statistics.employees_absents') : __('miscellaneous.pages_content.manager.home.statistics.employee_absent') }}
                                        </span>
                                        <div class="icon">
                                            <i class="bi bi-x-circle"></i>
                                        </div>
                                        <a href="{{ route('employee.entity.home', ['entity' => 'presence_absence']) }}" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END STATISTIC-->

                <!-- RECENT DATA-->
                <section>
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="recent-report2 p-4 rounded-4">
                                        <h6 class="h6 mb-4 fw-bold">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.recent')</h6>

                                        <div class="table-responsive">
                                            <table class="table border-top">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.title_singular')</th>
                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.department')</th>
                                                        <th class="cnpr-font-weight-700">@lang('miscellaneous.pages_content.manager.home.employees.remuneration.data.is_paid')</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                                <tbody>
@forelse ($employees_present_absent_today as $employee)
    @if ($loop->index < 6)
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
    @endif
@empty
                                                    <tr>
                                                        <td colspan="4" class="text-center"><small>@lang('miscellaneous.empty_list')</small></td>
                                                    </tr>
@endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <p class="mt-4 mb-0 text-center">
                                            <a href="{{ route('employee.entity.home', ['entity' => 'paid_unpaid']) }}" class="btn btn-primary py-1 rounded-pill">
                                                <i class="bi bi-coin fs-4 cnpr-align-middle me-2"></i> @lang('miscellaneous.pages_content.manager.home.employees.remuneration.link')
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="recent-report2 p-4 rounded-4">
                                        <h6 class="h6 mb-4 fw-bold">@lang('miscellaneous.pages_content.manager.home.employees.presences_absences.recent')</h6>

                                        <div class="table-responsive">
                                            <table class="table border-top">
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
    @if ($loop->index < 6)
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
    @endif
@empty
                                                    <tr>
                                                        <td colspan="4" class="text-center"><small>@lang('miscellaneous.empty_list')</small></td>
                                                    </tr>
@endforelse
                                                </tbody>

                                            </table>
                                        </div>

                                        <p class="mt-4 mb-0 text-center">
                                            <a href="{{ route('employee.entity.home', ['entity' => 'presence_absence']) }}" class="btn btn-primary py-1 rounded-pill">
                                                <i class="bi bi-person-check fs-4 cnpr-align-middle me-2"></i> @lang('miscellaneous.pages_content.manager.home.employees.presences_absences.link')
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END RECENT DATA-->
    
