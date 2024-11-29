
                <!-- ROLES LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('role.home') }}">
@csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.role.add')</h4>

                                                <!-- Role name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.role.data.role_name')" aria-describedby="name_error_message" value="{{ \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.role.data.role_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[1] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[2] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.role.data.role_description')"></textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.role.data.role_description')</label>
                                                </div>

                                                <!-- Icon -->
                                                <div class="input-group mt-3">
                                                    <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.pages_content.admin.role.data.icon.label')</label>
                                                    <select name="register_icon" id="register_icon" class="form-select rounded-0" style="padding-top: 1rem; padding-bottom: 1rem;">
                                                        <option class="small" disabled selected>@lang('miscellaneous.pages_content.admin.role.data.icon.message')</option>
                                                        <option value="bi bi-person-gear">&#xf8a7; @lang('miscellaneous.pages_content.admin.role.data.icon.figures.person-gear')</option>
                                                        <option value="bi bi-person-lines-fill">&#xf4db; @lang('miscellaneous.pages_content.admin.role.data.icon.figures.person-lines-fill')</option>
                                                        <option value="bi bi-person-badge">&#xf4d3; @lang('miscellaneous.pages_content.admin.role.data.icon.figures.person-badge')</option>
                                                    </select>
                                                </div>

                                                <!-- Color -->
                                                <div class="form-group mt-3 text-center">
                                                    <label class="form-label me-2" for="">
                                                        @lang('miscellaneous.pages_content.admin.role.data.color.label')
                                                        @lang('miscellaneous.colon_after_word')
                                                    </label>

                                                    <input type="radio" name="register_color" id="success-outlined" class="btn-check" autocomplete="off" value="success">
                                                    <label class="btn btn-outline-success" for="success-outlined">@lang('miscellaneous.pages_content.admin.role.data.color.success')</label>

                                                    <input type="radio" name="register_color" id="warning-outlined" class="btn-check" autocomplete="off" value="warning">
                                                    <label class="btn btn-outline-warning" for="warning-outlined">@lang('miscellaneous.pages_content.admin.role.data.color.warning')</label>

                                                    <input type="radio" name="register_color" id="primary-outlined" class="btn-check" autocomplete="off" value="primary">
                                                    <label class="btn btn-outline-primary" for="primary-outlined">@lang('miscellaneous.pages_content.admin.role.data.color.primary')</label>
                                                </div>

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.role.list')</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
@forelse ($roles as $role)
                                                <li class="list-group-item">
    @if ($current_user->roles[0]->id != $role->id)
                                                    <div class="dropdown show float-end">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('role.datas', ['id' => $role->id]) }}">@lang('miscellaneous.change')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'role', 'id' => $role->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>
    @endif

                                                    <h5 class="h5 mb-2 fw-bold text-{{ $role->color }}"><i class="{{ $role->icon }} fs-4 cnpr-align-middle"></i> {{ $role->role_name }}</h5>
                                                    <p class="card-text small text-muted">{{ $role->role_description }}</p>
                                                </li>
@empty
                                                <li class="list-group-item">
                                                    <p class="m-0 text-center text-muted">@lang('miscellaneous.empty_list')</p>
                                                </li>
@endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END ROLES LIST-->
