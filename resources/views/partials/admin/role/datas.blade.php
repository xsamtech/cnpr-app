
                <!-- UPDATE ROLE -->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('role.datas', ['id' => $role->id]) }}">
@csrf
                                                <input type="hidden" name="role_id" value="{{ $role->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.role.edit')</h4>

                                                <!-- Role name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.role.data.role_name')" aria-describedby="name_error_message" value="{{ $role->role_name }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.role.data.role_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[1] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[2] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.role.data.role_description')">{{ $role->role_description }}</textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.role.data.role_description')</label>
                                                </div>

                                                <!-- Icon -->
                                                <div class="input-group mt-3">
                                                    <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.pages_content.admin.role.data.icon.label')</label>
                                                    <select name="register_icon" id="register_icon" class="form-select rounded-0" style="padding-top: 1rem; padding-bottom: 1rem;">
                                                        <option class="small" disabled{{ $role->icon == null ? ' selected' : '' }}>@lang('miscellaneous.pages_content.admin.role.data.icon.message')</option>
                                                        <option value="bi bi-person-gear"{{ $role->icon == 'bi bi-person-gear' ? ' selected' : '' }}>&#xf8a7; @lang('miscellaneous.pages_content.admin.role.data.icon.figures.person-gear')</option>
                                                        <option value="bi bi-person-lines-fill{{ $role->icon == 'bi bi-person-lines-fill' ? ' selected' : '' }}">&#xf4db; @lang('miscellaneous.pages_content.admin.role.data.icon.figures.person-lines-fill')</option>
                                                        <option value="bi bi-person-badge"{{ $role->icon == 'bi bi-person-badge' ? ' selected' : '' }}>&#xf4d3; @lang('miscellaneous.pages_content.admin.role.data.icon.figures.person-badge')</option>
                                                    </select>
                                                </div>

                                                <!-- Color -->
                                                <div class="form-group mt-3 text-center">
                                                    <label class="form-label me-2" for="">
                                                        @lang('miscellaneous.pages_content.admin.role.data.color.label')
                                                        @lang('miscellaneous.colon_after_word')
                                                    </label>

                                                    <input type="radio" name="register_color" id="success-outlined" class="btn-check" autocomplete="off" value="success"{{ $role->color == 'success' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-success" for="success-outlined">@lang('miscellaneous.pages_content.admin.role.data.color.success')</label>

                                                    <input type="radio" name="register_color" id="warning-outlined" class="btn-check" autocomplete="off" value="warning"{{ $role->color == 'warning' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-warning" for="warning-outlined">@lang('miscellaneous.pages_content.admin.role.data.color.warning')</label>

                                                    <input type="radio" name="register_color" id="primary-outlined" class="btn-check" autocomplete="off" value="primary"{{ $role->color == 'primary' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-primary" for="primary-outlined">@lang('miscellaneous.pages_content.admin.role.data.color.primary')</label>
                                                </div>

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('role.home') }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE ROLE -->
