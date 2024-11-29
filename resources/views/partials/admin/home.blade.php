
                <!-- STATISTIC-->
                <section class="statistic">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="statistic__item rounded-4">
                                        <h2 class="number">{{ formatIntegerNumber(count($admins)) }}</h2>
                                        <span class="desc text-black">
                                            {{ count($admins) > 1 ? __('miscellaneous.pages_content.admin.home.statistics.admins') : __('miscellaneous.pages_content.admin.home.statistics.admin') }}
                                        </span>
                                        <div class="icon">
                                            <i class="bi bi-person-gear"></i>
                                        </div>
                                        <a href="{{ route('role.entity.home', ['entity' => 'other_admins']) }}" class="stretched-link"></a>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="statistic__item rounded-4">
                                        <h2 class="number">{{ formatIntegerNumber(count($managers)) }}</h2>
                                        <span class="desc text-black">
                                            {{ count($managers) > 1 ? __('miscellaneous.pages_content.admin.home.statistics.managers') : __('miscellaneous.pages_content.admin.home.statistics.manager') }}
                                        </span>
                                        <div class="icon">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </div>
                                        <a href="{{ route('role.entity.home', ['entity' => 'managers']) }}" class="stretched-link"></a>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6">
                                    <div class="statistic__item rounded-4">
                                        <h2 class="number">{{ formatIntegerNumber(count($branches)) }}</h2>
                                        <span class="desc text-black">
                                            {{ count($branches) > 1 ? __('miscellaneous.pages_content.admin.home.statistics.branches') : __('miscellaneous.pages_content.admin.home.statistics.branch') }}
                                        </span>
                                        <div class="icon">
                                            <i class="bi bi-building-check"></i>
                                        </div>
                                        <a href="{{ route('branch.home') }}" class="stretched-link"></a>
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
                                <!-- Recent admins-->
                                <div class="col-sm-6">
                                    <div class="recent-report2 p-4 rounded-4">
                                        <h6 class="h6 fw-bold">@lang('miscellaneous.pages_content.admin.role.admins.recent')</h6>

                                        <div class="list-group my-4">
@if (count($admins) > 1)
    @forelse ($admins as $admin)
        @if ($admin->id != $current_user->id)
            @if ($loop->index < 4)
                                            <a href="{{ route('role.entity.datas', ['entity' => 'other_admins', 'id' => $admin->id]) }}" class="list-group-item list-group-item-action">
                                                <div class="bg-image float-start">
                                                    <img src="{{ !empty($admin->avatar_url) ? $admin->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                    <div class="mask"></div>
                                                </div>
                                                <i class="bi bi-box-arrow-up-right mt-3 float-end"></i>
                                                <h6 class="h6 mt-2 mb-1 text-black text-truncate">{{ $admin->firstname . ' ' . $admin->lastname }}</h6>
                @if ($admin->username != null)
                                                <p class="m-0 small text-muted text-truncate cnpr-line-height-1">{{ '@' . $admin->username }}</p>
                @else
                    @if (!empty($admin->email) && !empty($admin->phone))
                                                <p class="m-0 small text-muted text-truncate cnpr-line-height-1">{{ $admin->email }}</p>
                    @else
                                                <p class="m-0 small text-muted text-truncate cnpr-line-height-1">{{ !empty($admin->email) ? $admin->phone : $admin->email }}</p>
                    @endif
                @endif
                                            </a>
            @endif
        @endif
    @empty
    @endforelse
@else
                                            <span class="list-group-item">
                                                <p class="m-0 text-center text-muted">@lang('miscellaneous.pages_content.admin.role.admins.nobody_else', ['vous' => $current_user->firstname])</p>
                                            </span>
@endif
                                        </div>

                                        <p class="m-0 text-center">
                                            <a href="{{ route('role.entity.home', ['entity' => 'other_admins']) }}" class="btn btn-primary rounded-pill">
                                                <i class="bi bi-person-gear me-2"></i> @lang('miscellaneous.pages_content.admin.role.admins.link')
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <!-- Recent managers-->
                                <div class="col-sm-6">
                                    <div class="recent-report2 p-4 rounded-4">
                                        <h6 class="h6 fw-bold">@lang('miscellaneous.pages_content.admin.role.managers.recent')</h6>

                                        <div class="list-group my-4">
@forelse ($managers as $manager)
    @if ($loop->index < 4)
                                            <a href="{{ route('role.entity.datas', ['entity' => 'managers', 'id' => $manager->id]) }}" class="list-group-item list-group-item-action">
                                                <div class="bg-image float-start">
                                                    <img src="{{ !empty($manager->avatar_url) ? $manager->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                    <div class="mask"></div>
                                                </div>
                                                <i class="bi bi-box-arrow-up-right mt-3 float-end"></i>
                                                <h6 class="h6 mt-2 mb-1 text-black text-truncate">{{ $manager->firstname . ' ' . $manager->lastname }}</h6>
        @if ($manager->username != null)
                                                <p class="m-0 small text-muted text-truncate cnpr-line-height-1">{{ '@' . $manager->username }}</p>
        @else
            @if (!empty($manager->email) && !empty($manager->phone))
                                                <p class="m-0 small text-muted text-truncate cnpr-line-height-1">{{ $manager->email }}</p>
            @else
                                                <p class="m-0 small text-muted text-truncate cnpr-line-height-1">{{ !empty($manager->email) ? $manager->phone : $manager->email }}</p>
            @endif
        @endif
                                            </a>
    @endif
@empty
                                            <span class="list-group-item">
                                                <p class="m-0 text-center text-muted">@lang('miscellaneous.empty_list')</p>
                                            </span>
@endforelse
                                        </div>

                                        <p class="m-0 text-center">
                                            <a href="{{ route('role.entity.home', ['entity' => 'managers']) }}" class="btn btn-primary rounded-pill">
                                                <i class="bi bi-person-lines-fill me-2"></i> @lang('miscellaneous.pages_content.admin.role.managers.link')
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <!-- Recent departments-->
                                <div class="col-lg-6">
                                    <div class="recent-report2 p-4 rounded-4">
                                        <h6 class="h6 fw-bold">@lang('miscellaneous.pages_content.admin.department.recent')</h6>

                                        <div class="list-group my-4">
@forelse ($departments as $department)
    @if ($loop->index < 4)
                                            <a href="{{ route('department.datas', ['id' => $department->id]) }}" class="list-group-item list-group-item-action">
                                                <h5 class="h5 text-black">{{ $department->department_name }}</h5>
                                                <p class="m-0 small text-muted cnpr-line-height-1">{{ \Str::limit($department->department_description, 80, '...') }}</p>
                                            </a>
    @endif
@empty
                                            <span class="list-group-item">
                                                <p class="m-0 text-center text-muted">@lang('miscellaneous.empty_list')</p>
                                            </span>
@endforelse
                                        </div>

                                        <p class="m-0 text-center">
                                            <a href="{{ route('department.home') }}" class="btn btn-primary rounded-pill">
                                                <i class="bi bi-diagram-3 me-2"></i> @lang('miscellaneous.pages_content.admin.department.link')
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <!-- Recent branches-->
                                <div class="col-lg-6">
                                    <div class="recent-report2 p-4 rounded-4">
                                        <h6 class="h6 fw-bold">@lang('miscellaneous.pages_content.admin.branch.recent')</h6>

                                        <div class="list-group my-4">
@forelse ($branches as $branch)
    @if ($loop->index < 4)
                                            <a href="{{ route('branch.datas', ['id' => $branch->id]) }}" class="list-group-item list-group-item-action">
                                                <h5 class="h5 text-black">{{ $branch->branch_name }}</h5>
                                                <p class="small text-muted cnpr-line-height-1">
                                                    <i class="bi bi-geo-alt-fill fs-5 me-1 cnpr-align-middle"></i>{{ $branch->address }}
                                                </p>
                                            </a>
    @endif
@empty
                                            <span class="list-group-item">
                                                <p class="m-0 text-center text-muted">@lang('miscellaneous.empty_list')</p>
                                            </span>
@endforelse
                                        </div>

                                        <p class="m-0 text-center">
                                            <a href="{{ route('branch.home') }}" class="btn btn-primary rounded-pill">
                                                <i class="bi bi-building-check me-2"></i> @lang('miscellaneous.pages_content.admin.branch.link')
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END RECENT DATA-->
    
