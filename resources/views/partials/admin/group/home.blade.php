
                <!-- GROUPS LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('group.home') }}">
@csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.group.add')</h4>

                                                <!-- Group name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.province.data.province_name')" aria-describedby="name_error_message" value="{{ \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.group.data.group_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[1] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[2] }}</p>
@endif
                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.group.data.group_description')"></textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.group.data.group_description')</label>
                                                </div>

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.group.list')</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
@forelse ($groups as $group)
                                                <li class="list-group-item">
                                                    <div class="dropdown show float-end">
                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>

                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                            <a class="dropdown-item" href="{{ route('group.datas', ['id' => $group->id]) }}">@lang('miscellaneous.change')</a>
                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'group', 'id' => $group->id]) }}">@lang('miscellaneous.delete')</a>
                                                        </div>
                                                    </div>

                                                    <h5 class="h5 mb-2 fw-bold">{{ $group->group_name }}</h5>
                                                    <p class="card-text small text-muted">{{ $group->group_description }}</p>
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
                <!-- END GROUPS LIST-->
