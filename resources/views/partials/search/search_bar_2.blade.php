
@if (Route::is('home') || Route::is('account') || Route::is('about') || Route::is('group.home') || Route::is('group.datas') || Route::is('group.entity.home') || Route::is('group.entity.datas') || Route::is('role.home') || Route::is('role.datas') || Route::is('role.entity.datas') || Route::is('vacation.home') || Route::is('vacation.datas') || Route::is('department.home') || Route::is('department.datas') || Route::is('notifications') || Route::is('history') || Route::is('search') && $entity == 'all')
                                            <form action="{{ route('search', ['entity' => 'all']) }}">
                                                <input type="hidden" name="branch_id" value="{{ !empty($current_user->branches) ? $current_user->branches[0]->id : '' }}">

                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
@else
    @if (Route::is('role.entity.home') && $entity == 'other_admins' || Route::is('search') && $entity == 'admins')
                                            <form action="{{ route('search', ['entity' => 'admins']) }}">
                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.role.admins.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('role.entity.home') && $entity == 'managers' || Route::is('search') && $entity == 'managers')
                                            <form action="{{ route('search', ['entity' => 'managers']) }}">
                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.role.managers.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('employee.home') || Route::is('employee.datas') || Route::is('employee.entity.home') || Route::is('employee.entity.datas') || Route::is('search') && $entity == 'employees')
                                            <form action="{{ route('search', ['entity' => 'employees']) }}">
                                                <input type="hidden" name="branch_id" value="{{ $current_user->branches[0]->id }}">

                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.manager.home.employees.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('province.home') || Route::is('province.datas') || Route::is('search') && $entity == 'province')
                                            <form action="{{ route('search', ['entity' => 'province']) }}">
                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.province.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('province.entity.home') || Route::is('province.entity.datas') || Route::is('search') && $entity == 'city')
                                            <form action="{{ route('search', ['entity' => 'city']) }}">
                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.province.city.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('branch.home') || Route::is('branch.datas') || Route::is('search') && $entity == 'branch')
                                            <form action="{{ route('search', ['entity' => 'branch']) }}">
                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.branch.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('task.home') || Route::is('task.datas') || Route::is('search') && $entity == 'task')
                                            <form action="{{ route('search', ['entity' => 'task']) }}">
                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.employee.tasks.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif

    @if (Route::is('message.home') || Route::is('message.datas') || Route::is('message.entity.home') || Route::is('message.entity.datas') || Route::is('search') && $entity == 'message')
                                            <form action="{{ route('search', ['entity' => 'message']) }}">
                                                <input type="hidden" name="type_name" value="{{ Route::is('message.entity.home') || Route::is('message.entity.datas') ? request()->entity : 'Message ordinaire' }}">

                                                <input class="au-input au-input--full au-input--h65" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.message.search')" />
                                                <span class="search-dropdown__icon"><i class="bi bi-search"></i></span>
                                            </form>
    @endif
@endif
