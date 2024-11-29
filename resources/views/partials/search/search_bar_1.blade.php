
@if (Route::is('home') || Route::is('account') || Route::is('about') || Route::is('group.home') || Route::is('group.datas') || Route::is('group.entity.home') || Route::is('group.entity.datas') || Route::is('role.home') || Route::is('role.datas') || Route::is('role.entity.datas') || Route::is('vacation.home') || Route::is('vacation.datas') || Route::is('department.home') || Route::is('department.datas') || Route::is('notifications') || Route::is('history') || Route::is('search') && $entity == 'all')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'all']) }}">
                                    <input type="hidden" name="branch_id" value="{{ !empty($current_user->branches) ? $current_user->branches[0]->id : '' }}">

                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
@else
    @if (Route::is('role.entity.home') && $entity == 'other_admins' || Route::is('search') && $entity == 'admins')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'admins']) }}">
                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.role.admins.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('role.entity.home') && $entity == 'managers' || Route::is('search') && $entity == 'managers')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'managers']) }}">
                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.role.managers.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('employee.home') || Route::is('employee.datas') || Route::is('employee.entity.home') || Route::is('employee.entity.datas') || Route::is('search') && $entity == 'employees')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'employees']) }}">
                                    <input type="hidden" name="branch_id" value="{{ $current_user->branches[0]->id }}">

                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.manager.home.employees.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('province.home') || Route::is('province.datas') || Route::is('search') && $entity == 'province')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'province']) }}">
                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.province.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('province.entity.home') || Route::is('province.entity.datas') || Route::is('search') && $entity == 'city')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'city']) }}">
                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.province.city.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('branch.home') || Route::is('branch.datas') || Route::is('search') && $entity == 'branch')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'branch']) }}">
                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.admin.branch.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('task.home') || Route::is('task.datas') || Route::is('search') && $entity == 'task')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'task']) }}">
                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.employee.tasks.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif

    @if (Route::is('message.home') || Route::is('message.datas') || Route::is('message.entity.home') || Route::is('message.entity.datas') || Route::is('search') && $entity == 'message')
                                <form class="form-header d-lg-block d-none float-start" action="{{ route('search', ['entity' => 'message']) }}">
                                    <input type="hidden" name="type_name" value="{{ Route::is('message.entity.home') || Route::is('message.entity.datas') ? request()->entity : 'Message ordinaire' }}">

                                    <input class="au-input au-input--xl" type="text" name="query" placeholder="@lang('miscellaneous.pages_content.message.search')" />
                                    <button class="au-btn--submit btn top-0 border-0 rounded-0 rounded-end" type="submit" style="height: 97%; margin-top: -1px; margin-left: -5px;">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
    @endif
@endif
