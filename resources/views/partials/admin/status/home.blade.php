
                <!-- STATUSES LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('group.entity.home', ['entity' => 'status']) }}">
@csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.group.status.add')</h4>

                                                <!-- Status name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.status.data.status_name')" aria-describedby="name_error_message" value="{{ \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.group.status.data.status_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.data.group_description')"></textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.group.data.group_description')</label>
                                                </div>

                                                <!-- Icon -->
                                                <div class="input-group mt-3">
                                                    <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.pages_content.admin.group.status.data.icon.label')</label>
                                                    <select name="register_icon" id="register_icon" class="form-select rounded-0" style="padding-top: 1rem; padding-bottom: 1rem;">
                                                        <option class="small" disabled selected>@lang('miscellaneous.pages_content.admin.group.status.data.icon.message')</option>
                                                        <option value="bi bi-airplane">&#xf7cd; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.airplane')</option>
                                                        <option value="bi bi-dash-circle">&#xf2e6; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.dash-circle')</option>
                                                        <option value="bi bi-circle-fill">&#xf287; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.circle-fill')</option>
                                                        <option value="bi bi-circle">&#xf28a; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.circle')</option>
                                                        <option value="bi bi-check2">&#xf272; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.check2')</option>
                                                        <option value="bi bi-check-circle">&#xf26b; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.check-circle')</option>
                                                        <option value="bi bi-check2-all">&#xf26f; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.check2-all')</option>
                                                        <option value="bi bi-trash3">&#xf78b; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.trash3')</option>
                                                        <option value="bi bi-x-circle">&#xf623; @lang('miscellaneous.pages_content.admin.group.status.data.icon.figures.x-circle')</option>
                                                    </select>
                                                </div>

                                                <!-- Color -->
                                                <div class="form-group mt-3 text-center">
                                                    <label class="form-label me-2" for="">
                                                        @lang('miscellaneous.pages_content.admin.group.status.data.color.label')
                                                        @lang('miscellaneous.colon_after_word')
                                                    </label>

                                                    <input type="radio" name="register_color" id="success-outlined" class="btn-check" autocomplete="off" value="success">
                                                    <label class="btn btn-outline-success" for="success-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.success')</label>

                                                    <input type="radio" name="register_color" id="warning-outlined" class="btn-check" autocomplete="off" value="warning">
                                                    <label class="btn btn-outline-warning" for="warning-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.warning')</label>

                                                    <input type="radio" name="register_color" id="primary-outlined" class="btn-check" autocomplete="off" value="primary">
                                                    <label class="btn btn-outline-primary" for="primary-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.primary')</label>

                                                    <input type="radio" name="register_color" id="danger-outlined" class="btn-check d-inline-block mt-1" autocomplete="off" value="danger">
                                                    <label class="btn btn-outline-danger" for="danger-outlined">@lang('miscellaneous.pages_content.admin.group.status.data.color.danger')</label>
                                                </div>

                                                <!-- Choose group -->
                                                <div class="form-floating mt-3" aria-describedby="group_error_message">
                                                    <select name="group_id" id="group_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" selected disabled>@lang('miscellaneous.pages_content.admin.group.status.data.choose_group')</option>
@foreach ($groups as $group)
                                                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
@endforeach
                                                    </select>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[1])
                                                <p id="group_error_message" class="text-center mt-2 text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.group.status.list')</h5>
                                        </div>

                                        <ul class="list-group list-group-flush rounded-4">
@if (count($statuses) > 0)
    @foreach ($groups as $group)
        @if (count($group->statuses) > 0)
                                            <li class="list-group-item pb-3">
                                                <h6 class="h6 fw-bold">{{ $group->group_name }}</h6>

                                                <ul class="list-group">
            @foreach ($group->statuses as $status)
                                                    <li class="list-group-item">
                                                        <div class="dropdown show float-end">
                                                            <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bi bi-three-dots"></i>
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                <a class="dropdown-item" href="{{ route('group.entity.datas', ['entity' => 'status', 'id' => $status->id]) }}">@lang('miscellaneous.change')</a>
                                                                <a class="dropdown-item" href="{{ route('delete', ['entity' => 'status', 'id' => $status->id]) }}">@lang('miscellaneous.delete')</a>
                                                            </div>
                                                        </div>

                                                        <h6 class="h6 mb-2 text-{{ $status->color }}"><i class="{{ $status->icon }} cnpr-align-middle me-2 fs-4"></i>{{ $status->status_name }}</h6>
                                                        <p class="small text-muted">{{ $status->status_description }}</p>
                                                    </li>
            @endforeach
                                                </ul>
                                            </li>
        @endif
    @endforeach
@else
                                            <li class="list-group-item">
                                                <p class="m-0 text-center text-muted">@lang('miscellaneous.empty_list')</p>
                                            </li>
@endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END STATUSES LIST-->
