
                <!-- SEARCH RESULTS LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-8 mx-auto">
@if ($entity == 'all')
                                    <h3 class="h3 m-0">{{ __('miscellaneous.search_result_for') . $data }}</h3>

                                    <hr class="my-4 bg-black">

    @if (inArrayR('Administrateur', $current_user->roles, 'role_name'))
        @if ($provinces != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.admin.province.title')</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
            @foreach ($provinces as $province)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <h6 class="h6 m-0">{{ $province->province_name }}</h6>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('province.datas', ['id' => $province->id]) }}">@lang('miscellaneous.change')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'province', 'id' => $province->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
            @endforeach
                                            </ul>
                                        </div>
                                    </div>
        @endif

        @if ($cities != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.admin.province.city')</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
            @foreach ($cities as $city)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <h6 class="h6 m-0">{{ $city->city_name }}</h6>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('province.entity.datas', ['entity' => 'city', 'id' => $city->id]) }}">@lang('miscellaneous.change')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'city', 'id' => $city->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
            @endforeach
                                            </ul>
                                        </div>
                                    </div>
        @endif

        @if ($branches != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.admin.branch')</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
            @foreach ($branches as $branch)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <h6 class="h6 m-0">{{ $branch->branch_name }}</h6>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('branch.datas', ['id' => $branch->id]) }}">@lang('miscellaneous.details')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'branch', 'id' => $province->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
            @endforeach
                                            </ul>
                                        </div>
                                    </div>
        @endif

        @if ($admins != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.admin.role.other_admins')</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group">
            @foreach ($admins as $admin)
                @if ($admin->id != $current_user->id)
                                                <a href="{{ route('role.entity.datas', ['entity' => 'other_admins', 'id' => $admin->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($admin->avatar_url) ? $admin->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $admin->firstname . ' ' . $admin->lastname }}</h6>
                    @if (!empty($admin->email) && !empty($admin->phone))
                                                    <p class="m-0 small text-muted text-truncate">{{ $admin->email }}</p>
                                                    <p class="m-0 small text-muted text-truncate">{{ $admin->phone }}</p>            
                    @else
                                                    <p class="m-0 small text-muted text-truncate">{{ !empty($admin->email) ? $admin->phone : $admin->email }}</p>
                    @endif
                                                </a>
                @else
                                                <span class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.pages_content.admin.role.admins.nobody_else', ['vous' => $current_user->firstname])</p>
                                                </span>
                @endif
            @endforeach
                                            </div>
                                        </div>
                                    </div>
        @endif

        @if ($managers != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.admin.role.managers')</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group">
            @foreach ($managers as $manager)
                                                <a href="{{ route('role.entity.datas', ['entity' => 'managers', 'id' => $manager->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($manager->avatar_url) ? $manager->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $manager->firstname . ' ' . $manager->lastname }}</h6>
                @if (!empty($manager->email) && !empty($manager->phone))
                                                    <p class="m-0 small text-muted text-truncate">{{ $manager->email }}</p>
                                                    <p class="m-0 small text-muted text-truncate">{{ $manager->phone }}</p>            
                @else
                                                    <p class="m-0 small text-muted text-truncate">{{ !empty($manager->email) ? $manager->phone : $manager->email }}</p>
                @endif
                                                </a>
            @endforeach
                                            </div>
                                        </div>
                                    </div>
        @endif

        @if ($provinces == null && $cities == null && $branches == null && $admins == null && $managers == null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
        @endif
    @endif

    @if (inArrayR('Manager', $current_user->roles, 'role_name'))
        @if ($employees != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.manager.employees.title')</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group">
            @foreach ($employees as $employee)
                                                <a href="{{ route('employee.datas', ['id' => $employee->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($employee->avatar_url) ? $employee->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $employee->firstname . ' ' . $employee->lastname }}</h6>
                @if (!empty($employee->email) && !empty($employee->phone))
                                                    <p class="m-0 small text-muted text-truncate">{{ $employee->email }}</p>
                                                    <p class="m-0 small text-muted text-truncate">{{ $employee->phone }}</p>            
                @else
                                                    <p class="m-0 small text-muted text-truncate">{{ !empty($employee->email) ? $employee->phone : $employee->email }}</p>
                @endif
                                                </a>
            @endforeach
                                            </div>
                                        </div>
                                    </div>
        @endif

        @if ($tasks != null)
            @if (!inArrayR(null, $tasks, 'department_id'))
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.employee.tasks')</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                @foreach ($tasks as $task)
                    @if ($task->department->id == $current_user->department_id)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="h6 m-0">{{ $task->task_title }}</h6>
                                                        <p class="m-0">{{ $task->task_content }}</p>
                                                    </div>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('task.datas', ['id' => $task->id]) }}">@lang('miscellaneous.details')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'task', 'id' => $province->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
                    @endif
                @endforeach
                                            </ul>
                                        </div>
                                    </div>
            @endif
        @endif

        @if ($employees == null && $tasks == null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
        @endif
    @endif

    @if (inArrayR('Employé', $current_user->roles, 'role_name'))
        @if ($tasks != null)
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.menu.employee.tasks')</h5>
                                        </div>
                                        <div class="card-body">
            @foreach ($tasks as $task)
                @if ($current_user->is_department_chief == 1)
                                            <ul class="list-group">
                    @if ($task->department->id == $current_user->department_id || $task->user->id == $current_user->id)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="h6 m-0">{{ $task->task_title }}</h6>
                                                        <p class="m-0">{{ $task->task_content }}</p>
                                                    </div>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('task.datas', ['id' => $task->id]) }}">@lang('miscellaneous.details')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'task', 'id' => $province->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
                    @endif
                                            </ul>

                @else
                                            <div class="list-group">
                    @if ($task->user->id == $current_user->id)
                                                <a href="{{ route('task.datas', ['id' => $task->id]) }}" class="list-group-item list-group-item-action">
                                                    <div>
                                                        <h6 class="h6 m-0">{{ $task->task_title }}</h6>
                                                        <p class="m-0">{{ $task->task_content }}</p>
                                                    </div>
                                                </a>
                    @endif
                                            </div>
                @endif
            @endforeach
                                        </div>
                                    </div>
        @else
                                    <div class="card rounded-4 mb-4">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
        @endif
    @endif

@endif

@if ($entity != 'all')
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">{{ __('miscellaneous.search_result_for') . $data }}</h5>
                                        </div>
                                        <div class="card-body">
    @if ($entity == 'admins')
                                            <div class="list-group">
            @forelse ($results_list as $admin)
                @if ($admin->id != $current_user->id)
                                                <a href="{{ route('role.entity.datas', ['entity' => 'other_admins', 'id' => $admin->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($admin->avatar_url) ? $admin->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $admin->firstname . ' ' . $admin->lastname }}</h6>
                    @if (!empty($admin->email) && !empty($admin->phone))
                                                    <p class="m-0 small text-muted text-truncate">{{ $admin->email }}</p>
                                                    <p class="m-0 small text-muted text-truncate">{{ $admin->phone }}</p>            
                    @else
                                                    <p class="m-0 small text-muted text-truncate">{{ !empty($admin->email) ? $admin->phone : $admin->email }}</p>
                    @endif
                                                </a>
                @else
                                                <span class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.pages_content.admin.role.admins.nobody_else', ['vous' => $current_user->firstname])</p>
                                                </span>
                @endif
            @empty
                                                <span class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </span>
            @endforelse
                                            </div>
    @endif

    @if ($entity == 'managers')
                                            <div class="list-group">
            @forelse ($results_list as $manager)
                                                <a href="{{ route('role.entity.datas', ['entity' => 'managers', 'id' => $manager->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($manager->avatar_url) ? $manager->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $manager->firstname . ' ' . $manager->lastname }}</h6>
                    @if (!empty($manager->email) && !empty($manager->phone))
                                                    <p class="m-0 small text-muted text-truncate">{{ $manager->email }}</p>
                                                    <p class="m-0 small text-muted text-truncate">{{ $manager->phone }}</p>            
                    @else
                                                    <p class="m-0 small text-muted text-truncate">{{ !empty($manager->email) ? $manager->phone : $manager->email }}</p>
                    @endif
                                                </a>
            @empty
                                                <span class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </span>
            @endforelse
                                            </div>
    @endif

    @if ($entity == 'employees')
                                            <div class="list-group">
            @forelse ($results_list as $employee)
                                                <a href="{{ route('employee.datas', ['id' => $employee->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($employee->avatar_url) ? $employee->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $employee->firstname . ' ' . $employee->lastname }}</h6>
                    @if (!empty($employee->email) && !empty($employee->phone))
                                                    <p class="m-0 small text-muted text-truncate">{{ $employee->email }}</p>
                                                    <p class="m-0 small text-muted text-truncate">{{ $employee->phone }}</p>            
                    @else
                                                    <p class="m-0 small text-muted text-truncate">{{ !empty($employee->email) ? $employee->phone : $manager->email }}</p>
                    @endif
                                                </a>
            @empty
                                                <span class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </span>
            @endforelse
                                            </div>
    @endif

    @if ($entity == 'message')
                                            <div class="list-group">
            @forelse ($results_list as $message)
                                                <a href="{{ route('role.entity.datas', ['entity' => 'managers', 'id' => $manager->id]) }}" class="list-group-item list-group-item-action">
                                                    <div class="bg-image float-start">
                                                        <img src="{{ !empty($message->user->avatar_url) ? $message->user->avatar_url : asset('assets/img/user.png') }}" alt="" width="60" class="rounded-circle me-3">
                                                        <div class="mask"></div>
                                                    </div>

                                                    <h6 class="h6 m-0 text-black text-truncate">{{ $message->user->firstname . ' ' . $message->user->lastname }}</h6>
                                                    <p class="m-0 small text-muted text-truncate">{{ \Str::limit($message->message_content, 100, '...') }}</p>
                                                </a>
            @empty
                                                <span class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </span>
            @endforelse
                                            </div>
    @endif

    @if ($entity == 'province')
                                            <ul class="list-group">
        @forelse ($results_list as $province)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <h6 class="h6 m-0">{{ $province->province_name }}</h6>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('province.datas', ['id' => $province->id]) }}">@lang('miscellaneous.change')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'province', 'id' => $province->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
        @empty
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
        @endforelse
                                            </ul>
    @endif

    @if ($entity == 'city')
                                            <ul class="list-group">
        @forelse ($results_list as $city)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <h6 class="h6 m-0">{{ $city->city_name }}</h6>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('province.entity.datas', ['entity' => 'city', 'id' => $city->id]) }}">@lang('miscellaneous.change')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'city', 'id' => $city->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
        @empty
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
        @endforelse
                                            </ul>
    @endif

    @if ($entity == 'branch')
                                            <ul class="list-group">
        @forelse ($results_list as $branch)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <h6 class="h6 m-0">{{ $branch->branch_name }}</h6>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('branch.datas', ['id' => $branch->id]) }}">@lang('miscellaneous.details')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'branch', 'id' => $branch->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
        @empty
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
        @endforelse
                                            </ul>
    @endif

    @if ($entity == 'task')
        @forelse ($results_list as $task)
            @if ($current_user->is_department_chief == 1)
                                            <ul class="list-group">
                @if ($task->department->id == $current_user->department_id || $task->user->id == $current_user->id)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="h6 m-0">{{ $task->task_title }}</h6>
                                                        <p class="m-0">{{ $task->task_content }}</p>
                                                    </div>

                                                    <div class="dropdown show">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('task.datas', ['id' => $task->id]) }}">@lang('miscellaneous.details')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'task', 'id' => $province->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
                                                </li>
                @endif
                                            </ul>

            @else
                                            <div class="list-group">
                @if ($task->user->id == $current_user->id)
                                                <a href="{{ route('task.datas', ['id' => $task->id]) }}" class="list-group-item list-group-item-action">
                                                    <div>
                                                        <h6 class="h6 m-0">{{ $task->task_title }}</h6>
                                                        <p class="m-0">{{ $task->task_content }}</p>
                                                    </div>
                                                </a>
                @endif
                                            </div>
            @endif
        @empty
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.no_result')</p>
                                                </li>
                                            </ul>
        @endforelse
    @endif
                                        </div>
                                    </div>
@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END SEARCH RESULTS LIST-->
    
