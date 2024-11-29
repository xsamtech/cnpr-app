
            <!-- MENU SIDEBAR-->
            <aside class="menu-sidebar2">
                <div class="logo border shadow-0">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/logo-text.png') }}" alt="Cool Admin" width="160" />
                    </a>
                </div>

                <div class="menu-sidebar2__content js-scrollbar1">
                    <nav class="navbar-sidebar2">
                        <ul class="list-unstyled navbar__list">
                            <li class="{{ Route::is('about') ? 'active' : '' }}">
                                <a href="{{ route('about') }}" class="bg-light">
                                    <i class="bi bi-question-circle fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.about')
                                </a>
                            </li>
                            <li class="{{ Route::is('home') ? 'active' : '' }}">
                                <a href="{{ route('home') }}">
                                    <i class="bi bi-speedometer2 fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.dashboard')
                                </a>
                            </li>

@if (inArrayR('Administrateur', $current_user->roles, 'role_name'))
                            <li class="has-sub{{ Route::is('province.home') || Route::is('province.datas') || Route::is('province.entity.home') || Route::is('province.entity.datas') ? ' active' : '' }}">
                                <a href="#" class="js-arrow">
                                    <i class="bi bi-pin-map fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.admin.province.title')
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>

                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="{{ route('province.home') }}" class="px-4">
                                            @lang('miscellaneous.pages_content.admin.province.link')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('province.entity.home', ['entity' => 'city']) }}" class="px-4">
                                            @lang('miscellaneous.pages_content.admin.province.city.link')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub{{ Route::is('group.home') || Route::is('group.datas') || Route::is('group.entity.home') || Route::is('group.entity.datas') ? ' active' : '' }}">
                                <a href="#" class="js-arrow">
                                    <i class="bi bi-layers fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.admin.group.title')
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>

                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="{{ route('group.home') }}" class="px-4">
                                            @lang('miscellaneous.pages_content.admin.group.link')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('group.entity.home', ['entity' => 'status']) }}" class="px-4">
                                            @lang('miscellaneous.pages_content.admin.group.status.link')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('group.entity.home', ['entity' => 'type']) }}" class="px-4">
                                            @lang('miscellaneous.pages_content.admin.group.type.link')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub{{ Route::is('role.home') || Route::is('role.datas') || Route::is('role.entity.home') || Route::is('role.entity.datas') ? ' active' : '' }}">
                                <a href="#" class="js-arrow">
                                    <i class="bi bi-mortarboard fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.admin.role.title')
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>

                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="{{ route('role.home') }}" class="px-4">
                                            @lang('miscellaneous.pages_content.admin.role.link')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('role.entity.home', ['entity' => 'other_admins']) }}" class="px-4">
                                            @lang('miscellaneous.menu.admin.role.other_admins')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('role.entity.home', ['entity' => 'managers']) }}" class="px-4">
                                            @lang('miscellaneous.menu.admin.role.managers')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ Route::is('vacation.home') || Route::is('vacation.datas') ? 'active' : '' }}">
                                <a href="{{ route('vacation.home') }}">
                                    <i class="bi bi-stop-circle fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.admin.vacation')
                                </a>
                            </li>
                            <li class="{{ Route::is('department.home') || Route::is('department.datas') ? 'active' : '' }}">
                                <a href="{{ route('department.home') }}">
                                    <i class="bi bi-diagram-3 fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.admin.department')
                                </a>
                            </li>
                            <li class="{{ Route::is('branch.home') || Route::is('branch.datas') ? ' active' : '' }}">
                                <a href="{{ route('branch.home') }}">
                                    <i class="bi bi-building-check fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.admin.branch')
                                </a>
                            </li>
@endif

@if (inArrayR('Manager', $current_user->roles, 'role_name'))
                            <li class="has-sub{{ Route::is('employee.home') || Route::is('employee.datas') || Route::is('employee.entity.home') || Route::is('employee.entity.datas') ? ' active' : '' }}">
                                <a href="#" class="js-arrow">
                                    <i class="bi bi-people fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.manager.employees.title')
                                    <span class="arrow">
                                        <i class="fas fa-angle-down"></i>
                                    </span>
                                </a>

                                <ul class="list-unstyled navbar__sub-list js-sub-list">
                                    <li>
                                        <a href="{{ route('employee.home') }}" class="px-4">
                                            @lang('miscellaneous.pages_content.manager.home.employees.link')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('employee.entity.home', ['entity' => 'paid_unpaid']) }}" class="px-4">
                                            @lang('miscellaneous.menu.manager.employees.remuneration')
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('employee.entity.home', ['entity' => 'presence_absence']) }}" class="px-4">
                                            @lang('miscellaneous.menu.manager.employees.presences_absences')
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ Route::is('task.home') || Route::is('task.datas') ? 'active' : '' }}">
                                <a href="{{ route('task.home') }}">
                                    <i class="bi bi-stickies fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.manager.tasks')
                                </a>
                            </li>
                            <li class="{{ Route::is('communique.home') || Route::is('communique.datas') ? 'active' : '' }}">
                                <a href="{{ route('communique.home') }}">
                                    <i class="bi bi-megaphone fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.manager.communiques')
                                </a>
                            </li>
@endif

@if (inArrayR('Employé', $current_user->roles, 'role_name'))
                            <li class="{{ Route::is('presence_absence.home') || Route::is('presence_absence.datas') ? 'active' : '' }}">
                                <a href="{{ route('presence_absence.home') }}">
                                    <i class="bi bi-check-circle fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.employee.presences_absences')
                                </a>
                            </li>
                            <li class="{{ Route::is('task.home') || Route::is('task.datas') ? 'active' : '' }}">
                                <a href="{{ route('task.home') }}">
                                    <i class="bi bi-stickies fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.employee.tasks')
                                </a>
                            </li>
                            <li class="{{ Route::is('communique.home') || Route::is('communique.datas') ? 'active' : '' }}">
                                <a href="{{ route('communique.home') }}">
                                    <i class="bi bi-megaphone fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.employee.communiques')
                                </a>
                            </li>
@endif

                            <li class="{{ Route::is('history') ? 'active' : '' }}">
                                <a href="{{ route('history') }}">
                                    <i class="bi bi-clock-history fs-5 cnpr-align-middle"></i>@lang('miscellaneous.menu.activities_history')
                                </a>
                            </li>
                            <li class="opacity-0"><a style="cursor: default;">-------------------</a></li>
                        </ul>
                    </nav>
                </div>
            </aside>
            <!-- END MENU SIDEBAR-->
