
                <!-- TYPES LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('group.entity.home', ['entity' => 'type']) }}">
@csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.group.type.add')</h4>

                                                <!-- Type name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.type.data.type_name')" aria-describedby="name_error_message" value="{{ \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.group.type.data.type_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control mb-3" placeholder="@lang('miscellaneous.pages_content.admin.group.data.group_description')"></textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.group.data.group_description')</label>
                                                </div>

                                                <!-- Icon -->
                                                <div class="input-group mt-3">
                                                    <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.pages_content.admin.group.type.data.icon.label')</label>
                                                    <select name="register_icon" id="register_icon" class="form-select rounded-0" style="padding-top: 1rem; padding-bottom: 1rem;">
                                                        <option class="small" disabled selected>@lang('miscellaneous.pages_content.admin.group.type.data.icon.message')</option>
                                                        <option value="bi bi-chat-quote">&#xf255; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.chat-quote')</option>
                                                        <option value="bi bi-camera">&#xf220; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.camera')</option>
                                                        <option value="bi bi-file-earmark-text">&#xf38b; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.file-earmark-text')</option>
                                                        <option value="bi bi-headphones">&#xf413; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.headphones')</option>
                                                        <option value="bi bi-emoji-angry">&#xf317; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.emoji-angry')</option>
                                                        <option value="bi bi-clock-history">&#xf292; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.clock-history')</option>
                                                        <option value="bi bi-image">&#xf42a; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.image')</option>
                                                        <option value="bi bi-journals">&#xf447; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.journals')</option>
                                                        <option value="bi bi-search">&#xf52a; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.search')</option>
                                                        <option value="bi bi-megaphone">&#xf484; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.megaphone')</option>
                                                        <option value="bi bi-umbrella">&#xf5fd; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.umbrella')</option>
                                                        <option value="bi bi-plus-square-dotted">&#xf4fb; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.plus-square-dotted')</option>
                                                        <option value="bi bi-patch-question">&#xf4be; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.patch-question')</option>
                                                    </select>
                                                </div>

                                                <!-- Choose group -->
                                                <div class="form-floating mt-3" aria-describedby="group_error_message">
                                                    <select name="group_id" id="group_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" selected disabled>@lang('miscellaneous.pages_content.admin.group.type.data.choose_group')</option>
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
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.group.type.list')</h5>
                                        </div>

                                        <ul class="list-group list-group-flush rounded-4">
@if (count($types) > 0)
    @foreach ($groups as $group)
        @if (count($group->types) > 0)
                                            <li class="list-group-item pb-3">
                                                <h6 class="h6 fw-bold">{{ $group->group_name }}</h6>

                                                <ul class="list-group">
            @foreach ($group->types as $type)
                                                    <li class="list-group-item">
                                                        <div class="dropdown show float-end">
                                                            <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bi bi-three-dots"></i>
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                <a class="dropdown-item" href="{{ route('group.entity.datas', ['entity' => 'type', 'id' => $type->id]) }}">@lang('miscellaneous.change')</a>
                                                                <a class="dropdown-item" href="{{ route('delete', ['entity' => 'type', 'id' => $type->id]) }}">@lang('miscellaneous.delete')</a>
                                                            </div>
                                                        </div>

                                                        <h6 class="h6 mb-2"><i class="{{ $type->icon }} cnpr-align-middle me-2 fs-4"></i>{{ $type->type_name }}</h6>
                                                        <p class="small text-muted">{{ $type->type_description }}</p>
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
                <!-- END TYPES LIST-->
