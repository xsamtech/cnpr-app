
                <!-- BRANCHES LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
@if (count($cities) > 0)
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('branch.home') }}">
    @csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.branch.add')</h4>

                                                <!-- Branch name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.branch_name')" aria-describedby="name_error_message" value="{{ Route::is('branch.home') && \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.branch.data.branch_name')</label>
                                                </div>
    @if (Route::is('branch.home') && \Session::has('response_error') && explode('_', \Session::get('response_error'))[6] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[7] }}</p>
    @endif

                                                <!-- E-mail -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.email')" value="{{ Route::is('branch.home') && \Session::has('response_error') ? explode('_', \Session::get('response_error'))[1] : '' }}" />
                                                    <label class="form-label" for="register_email">@lang('miscellaneous.pages_content.admin.branch.data.email')</label>
                                                </div>

                                                <!-- Phone -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_phones" id="register_phones" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.phones.title')" aria-describedby="phones_description" value="{{ Route::is('branch.home') && \Session::has('response_error') ? explode('_', \Session::get('response_error'))[2] : '' }}" />
                                                    <label class="form-label" for="register_phones">@lang('miscellaneous.pages_content.admin.branch.data.phones.title')</label>
                                                </div>
                                                <p id="phones_description" class="text-end text-muted fst-italic small">@lang('miscellaneous.pages_content.admin.branch.data.phones.description')</p>

                                                <!-- Address -->
                                                <div class="form-floating mt-2">
                                                    <textarea name="register_address" id="register_address" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.address')">{{ Route::is('branch.home') && \Session::has('response_error') ? explode('_', \Session::get('response_error'))[3] : '' }}</textarea>
                                                    <label class="form-label" for="register_address">@lang('miscellaneous.pages_content.admin.branch.data.address')</label>
                                                </div>

                                                <!-- P.O Box -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.p_o_box')" value="{{ Route::is('branch.home') && \Session::has('response_error') ? explode('_', \Session::get('response_error'))[4] : '' }}" />
                                                    <label class="form-label" for="register_p_o_box">@lang('miscellaneous.pages_content.admin.branch.data.p_o_box')</label>
                                                </div>

                                                <!-- Choose city -->
                                                <div class="form-floating mt-3" aria-describedby="city_error_message">
                                                    <select name="city_id" id="city_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" selected disabled>@lang('miscellaneous.pages_content.admin.branch.data.choose_city')</option>
    @foreach ($provinces as $province)
                                                        <optgroup label="{{ $province->province_name }}">
        @foreach ($province->cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
        @endforeach
                                                        </optgroup>
    @endforeach
                                                    </select>
                                                </div>
    @if (Route::is('branch.home') && \Session::has('response_error') && explode('_', \Session::get('response_error'))[6] == explode('_', \Session::get('response_error'))[5])
                                                <p id="city_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[7] }}</p>
    @endif

                                                <div class="mt-3 p-2 border overflow-auto" title="@lang('miscellaneous.pages_content.admin.branch.data.choose_managers')" style="max-height: 7rem;">
                                                    <p class="mt-0 mb-2 small">@lang('miscellaneous.pages_content.admin.branch.data.managers')</p>
    @forelse ($free_managers as $manager)
                                                    <div class="form-check">
                                                        <input type="checkbox" name="users_ids[]" id="manager-{{ $manager->id }}" class="form-check-input" value="{{ $manager->id }}">
                                                        <label class="form-check-label" for="manager-{{ $manager->id }}">{{ $manager->firstname . ' ' . $manager->lastname }}</label>
                                                    </div>
    @empty
                                                    <p class="mb-0 small text-center text-success"><i class="bi bi-info-circle me-2"></i>@lang('miscellaneous.pages_content.admin.branch.data.empty_managers_list')</p>
    @endforelse
                                                    <p class="mt-1 text-center">
                                                        <a role="button" class="btn btn-sm btn-link" data-bs-toggle="modal" data-bs-target="#registerModalManager" onclick="document.getElementById('register_number').focus()">
                                                            @lang('miscellaneous.pages_content.admin.role.managers.add')
                                                        </a>
                                                    </p>
                                                </div>

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.branch.list')</h5>
                                        </div>

                                        <ul class="list-group list-group-flush rounded-4">
    @if (count($branches) > 0)
        @foreach ($cities as $city)
            @if (count($city->branches) > 0)
                                            <li class="list-group-item pb-3">
                                                <h6 class="h6 mb-2 text-success text-uppercase">{{ $city->city_name }}</h6>

                                                <ul class="list-group">

                @foreach ($city->branches as $branch)
                                                    <li class="list-group-item">
                                                        <div class="dropdown show float-end">
                                                            <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bi bi-three-dots"></i>
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                <a class="dropdown-item" href="{{ route('branch.datas', ['id' => $branch->id]) }}">@lang('miscellaneous.change')</a>
                                                                <a class="dropdown-item" href="{{ route('delete', ['entity' => 'branch', 'id' => $branch->id]) }}">@lang('miscellaneous.delete')</a>
                                                            </div>
                                                        </div>

                                                        <h6 class="h6 mb-2 fw-bold">{{ $branch->branch_name }}</h6>
                    @if ($branch->email != null)
                                                        <p class="mb-1 small" style="color: #555;"><i class="bi bi-envelope-fill me-2"></i>{{ $branch->email }}</p>
                    @endif
                    @if ($branch->phones != null)
                                                        <p class="mb-1 small" style="color: #555;"><i class="bi bi-telephone-fill me-2"></i>{{ $branch->phones }}</p>
                    @endif
                    @if ($branch->address != null)
                                                        <p class="mb-1 small" style="color: #555;"><i class="bi bi-geo-alt-fill me-2"></i>{{ $branch->address }}</p>
                    @endif
                    @if ($branch->p_o_box != null)
                                                        <p class="m-0 small" style="color: #555;"><i class="bi bi-envelope-paper me-2"></i>{{ $branch->p_o_box }}</p>
                    @endif
                                                        <div class="card mt-3 mb-0 rounded-4 overflow-hidden">
                                                            <div class="card-header py-1">
                                                                <p class="card-text small m-0">@lang('miscellaneous.pages_content.admin.branch.data.managers')</p>
                                                            </div>

                                                            <ul class="list-group list-group-flush">
                    @forelse ($managers as $manager)
                        @if (inArrayR($branch->id, $manager->branches, 'id'))
                                                                <li class="list-group-item px-3 py-2">
                                                                    <div class="bg-image float-start me-2">
                                                                        <img src="{{  !empty($manager->avatar_url) ? $manager->avatar_url : asset('assets/img/user.png') }}" alt="" width="50" class="rounded-circle">
                                                                        <div class="mask"></div>
                                                                    </div>
                                                                    <h6 class="h6 mb-1">{{ $manager->firstname . ' ' . $manager->lastname }}</h6>
                                                                    <p class="m-0 small text-muted cnpr-line-height-1">{{ !empty($manager->username) ? '@' . $manager->username : (!empty($manager->email) ? $manager->email : $manager->phone) }}</p>

                                                                    <a href="{{ route('role.entity.datas', ['entity' => 'managers', 'id' => $manager->id]) }}" class="btn btn-sm btn-link p-0 float-end text-decoration-underline">@lang('miscellaneous.see_details')<i class="bi bi-chevron-double-right ms-2 cnpr-align-middle"></i></a>
                                                                </li>
                        @else
                        @endif
                    @empty
                    @endforelse
                                                            </ul>
                                                        </div>
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
@else
                                <div class="col-lg-7 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body">
                                            <p class="card-text text-center">@lang('miscellaneous.pages_content.admin.province.city.empty_city')</p>
                                        </div>
                                        <div class="card-footer text-center">
                                            <a href="{{ route('province.home') }}" class="btn-link">@lang('miscellaneous.pages_content.admin.province.city.link')<i class="bi bi-chevron-double-right ms-2 align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
@endif
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END BRANCHES LIST-->
    
