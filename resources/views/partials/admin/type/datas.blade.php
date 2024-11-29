
                <!-- UPDATE TYPE-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('group.entity.datas', ['entity' => 'type', 'id' => $type->id]) }}">
@csrf
                                                <input type="hidden" name="type_id" value="{{ $type->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.group.type.edit')</h4>

                                                <!-- Type name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.type.data.type_name')" aria-describedby="name_error_message" value="{{ $type->type_name }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.group.type.data.type_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control mb-3" placeholder="@lang('miscellaneous.pages_content.admin.group.data.group_description')">{{ $type->type_description }}</textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.group.data.group_description')</label>
                                                </div>

                                                <!-- Icon -->
                                                <div class="input-group mt-3">
                                                    <label class="input-group-text h-100 py-3 rounded-0" for="register_icon">@lang('miscellaneous.pages_content.admin.group.type.data.icon.label')</label>
                                                    <select name="register_icon" id="register_icon" class="form-select rounded-0" style="padding-top: 1rem; padding-bottom: 1rem;">
                                                        <option class="small" disabled{{ $type->icon == null ? ' selected' : '' }}>@lang('miscellaneous.pages_content.admin.group.type.data.icon.message')</option>
                                                        <option value="bi bi-chat-quote"{{ $type->icon == 'bi bi-chat-quote' ? ' selected' : '' }}>&#xf255; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.chat-quote')</option>
                                                        <option value="bi bi-camera"{{ $type->icon == 'bi bi-camera' ? ' selected' : '' }}>&#xf220; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.camera')</option>
                                                        <option value="bi bi-file-earmark-text"{{ $type->icon == 'bi bi-file-earmark-text' ? ' selected' : '' }}>&#xf38b; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.file-earmark-text')</option>
                                                        <option value="bi bi-headphones"{{ $type->icon == 'bi bi-headphones' ? ' selected' : '' }}>&#xf413; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.headphones')</option>
                                                        <option value="bi bi-emoji-angry"{{ $type->icon == 'bi bi-emoji-angry' ? ' selected' : '' }}>&#xf317; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.emoji-angry')</option>
                                                        <option value="bi bi-clock-history"{{ $type->icon == 'bi bi-clock-history' ? ' selected' : '' }}>&#xf292; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.clock-history')</option>
                                                        <option value="bi bi-image"{{ $type->icon == 'bi bi-image' ? ' selected' : '' }}>&#xf42a; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.image')</option>
                                                        <option value="bi bi-journals"{{ $type->icon == 'bi bi-journals' ? ' selected' : '' }}>&#xf447; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.journals')</option>
                                                        <option value="bi bi-search"{{ $type->icon == 'bi bi-search' ? ' selected' : '' }}>&#xf52a; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.search')</option>
                                                        <option value="bi bi-megaphone"{{ $type->icon == 'bi bi-megaphone' ? ' selected' : '' }}>&#xf484; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.megaphone')</option>
                                                        <option value="bi bi-umbrella"{{ $type->icon == 'bi bi-umbrella' ? ' selected' : '' }}>&#xf5fd; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.umbrella')</option>
                                                        <option value="bi bi-plus-square-dotted"{{ $type->icon == 'bi bi-plus-square-dotted' ? ' selected' : '' }}>&#xf4fb; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.plus-square-dotted')</option>
                                                        <option value="bi bi-patch-question"{{ $type->icon == 'bi bi-patch-question' ? ' selected' : '' }}>&#xf4be; @lang('miscellaneous.pages_content.admin.group.type.data.icon.figures.patch-question')</option>
                                                    </select>
                                                </div>

                                                <!-- Choose group -->
                                                <div class="form-floating mt-3" aria-describedby="group_error_message">
                                                    <select name="group_id" id="group_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" selected disabled>@lang('miscellaneous.pages_content.admin.group.type.data.choose_group')</option>
@foreach ($groups as $group)
                                                        <option value="{{ $group->id }}"{{ $type->group_id == $group->id ? ' selected' : '' }}>{{ $group->group_name }}</option>
@endforeach
                                                    </select>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[1])
                                                <p id="group_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('group.entity.home', ['entity' => 'type']) }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE TYPE-->
