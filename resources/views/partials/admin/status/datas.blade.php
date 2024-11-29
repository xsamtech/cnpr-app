
                <!-- UPDATE STATUS-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('group.entity.datas', ['entity' => 'status', 'id' => $status->id]) }}">
@csrf
                                                <input type="hidden" name="status_id" value="{{ $status->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.group.status.edit')</h4>

                                                <!-- Status name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.status.data.status_name')" aria-describedby="name_error_message" value="{{ $status->status_name }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.group.status.data.status_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.data.group_description')">{{ $status->status_description }}</textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.group.data.group_description')</label>
                                                </div>

                                                <!-- Icon -->
                                                <div class="input-group mt-3">
                                                    <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.pages_content.admin.group.status.data.icon.label')</label>
                                                    <select name="register_icon" id="register_icon" class="form-select rounded-0" style="padding-top: 1rem; padding-bottom: 1rem;">
                                                        <option class="small" disabled{{ $status->icon == null ? ' selected' : '' }}>@lang('miscellaneous.pages_content.admin.group.status.data.icon.message')</option>
                                                        <option value="bi bi-airplane"{{ $status->icon == 'bi bi-airplane' ? ' selected' : '' }}>&#xf7cd; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.airplane')</option>
                                                        <option value="bi bi-dash-circle"{{ $status->icon == 'bi bi-dash-circle' ? ' selected' : '' }}>&#xf2e6; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.dash-circle')</option>
                                                        <option value="bi bi-circle-fill"{{ $status->icon == 'bi bi-circle-fill' ? ' selected' : '' }}>&#xf287; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.circle-fill')</option>
                                                        <option value="bi bi-circle"{{ $status->icon == 'bi bi-circle' ? ' selected' : '' }}>&#xf28a;  @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.circle')</option>
                                                        <option value="bi bi-check2"{{ $status->icon == 'bi bi-check2' ? ' selected' : '' }}>&#xf272; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.check2')</option>
                                                        <option value="bi bi-check-circle"{{ $status->icon == 'bi bi-check-circle' ? ' selected' : '' }}>&#xf26b; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.check-circle')</option>
                                                        <option value="bi bi-check2-all"{{ $status->icon == 'bi bi-check2-all' ? ' selected' : '' }}>&#xf26f; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.check2-all')</option>
                                                        <option value="bi bi-trash3"{{ $status->icon == 'bi bi-trash3' ? ' selected' : '' }}>&#xf78b; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.trash3')</option>
                                                        <option value="bi bi-x-circle"{{ $status->icon == 'bi bi-x-circle' ? ' selected' : '' }}>&#xf623; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.x-circle')</option>
                                                    </select>
                                                </div>

                                                <!-- Color -->
                                                <div class="form-group mt-3 text-center">
                                                    <label class="form-label me-2" for="">
                                                        @lang('miscellaneous.pages_content.admin.group.status.data.color.label')
                                                        @lang('miscellaneous.colon_after_word')
                                                    </label>

                                                    <input type="radio" name="register_color" id="success-outlined" class="btn-check" autocomplete="off" value="success"{{ $status->color == 'success' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-success" for="success-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.success')</label>

                                                    <input type="radio" name="register_color" id="warning-outlined" class="btn-check" autocomplete="off" value="warning"{{ $status->color == 'warning' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-warning" for="warning-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.warning')</label>

                                                    <input type="radio" name="register_color" id="primary-outlined" class="btn-check" autocomplete="off" value="primary"{{ $status->color == 'primary' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-primary" for="primary-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.primary')</label>

                                                    <input type="radio" name="register_color" id="danger-outlined" class="btn-check" autocomplete="off" value="danger"{{ $status->color == 'danger' ? ' checked' : '' }}>
                                                    <label class="btn btn-outline-danger" for="danger-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.danger')</label>
                                                </div>

                                                <!-- Choose group -->
                                                <div class="form-floating mt-3" aria-describedby="group_error_message">
                                                    <select name="group_id" id="group_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" disabled>@lang('miscellaneous.pages_content.admin.group.status.data.choose_group')</option>
@foreach ($groups as $group)
                                                        <option value="{{ $group->id }}"{{ $status->group_id == $group->id ? ' selected' : '' }}>{{ $group->group_name }}</option>
@endforeach
                                                    </select>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[1])
                                                <p id="group_error_message" class="text-center mt-2 text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('group.entity.home', ['entity' => 'status']) }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE STATUS-->
