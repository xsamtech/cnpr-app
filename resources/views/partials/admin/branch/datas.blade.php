
                <!-- UPDATE BRANCH-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card rounded-4 overflow-hidden">
                                        <div class="card-header">
                                            <h5 class="card-title">@lang('miscellaneous.pages_content.admin.branch.data.withdraw_managers')</h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
@forelse ($branch_managers as $manager)
                                            <li class="list-group-item">
                                                <button id="user-{{ $manager->id }}" class="btn btn-sm btn-outline-dark mt-2 border-0 rounded-circle float-end" style="width: 30px; height: 31px; padding: 0.25rem 0.45rem" onclick="removeFromBranch(this, {{ $branch->id }})">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                                <div class="bg-image float-start me-2">
                                                    <img src="{{  !empty($manager->avatar_url) ? $manager->avatar_url : asset('assets/img/user.png') }}" alt="" width="50" class="rounded-circle">
                                                    <div class="mask"></div>
                                                </div>
                                                <h6 class="h6 mb-1">{{ $manager->firstname . ' ' . $manager->lastname }}</h6>
                                                <p class="m-0 small text-muted cnpr-line-height-1">{{ !empty($manager->username) ? '@' . $manager->username : (!empty($manager->email) ? $manager->email : $manager->phone) }}</p>
                                            </li>
@empty
                                            <li class="list-group-item">
                                                <p class="m-0 small text-center">@lang('miscellaneous.empty_list')</p>
                                            </li>
@endforelse
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('branch.datas', ['id' => $branch->id]) }}">
@csrf
                                                <input type="hidden" name="branch_id" value="{{ $branch->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.branch.edit')</h4>

                                                <!-- Branch name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.branch_name')" aria-describedby="name_error_message" value="{{ $branch->branch_name }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.branch.data.branch_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[6] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[7] }}</p>
@endif

                                                <!-- E-mail -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_email" id="register_email" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.email')" value="{{ $branch->email }}" />
                                                    <label class="form-label" for="register_email">@lang('miscellaneous.pages_content.admin.branch.data.email')</label>
                                                </div>

                                                <!-- Phone -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_phones" id="register_phones" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.phones.title')" aria-describedby="phones_description" value="{{ $branch->phones }}" />
                                                    <label class="form-label" for="register_phones">@lang('miscellaneous.pages_content.admin.branch.data.phones.title')</label>
                                                </div>
                                                <p id="phones_description" class="text-end text-muted fst-italic small">@lang('miscellaneous.pages_content.admin.branch.data.phones.description')</p>

                                                <!-- Address -->
                                                <div class="form-floating mt-2">
                                                    <textarea name="register_address" id="register_address" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.address')">{{ $branch->address }}</textarea>
                                                    <label class="form-label" for="register_address">@lang('miscellaneous.pages_content.admin.branch.data.address')</label>
                                                </div>

                                                <!-- P.O Box -->
                                                <div class="form-floating mt-3">
                                                    <input type="text" name="register_p_o_box" id="register_p_o_box" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.branch.data.p_o_box')" value="{{ $branch->p_o_box }}" />
                                                    <label class="form-label" for="register_p_o_box">@lang('miscellaneous.pages_content.admin.branch.data.p_o_box')</label>
                                                </div>

                                                <!-- Choose city -->
                                                <div class="form-floating mt-3" aria-describedby="province_error_message">
                                                    <select name="city_id" id="city_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" disabled>@lang('miscellaneous.pages_content.admin.branch.data.choose_city')</option>
@foreach ($provinces as $province)
                                                        <optgroup label="{{ $province->province_name }}">
    @foreach ($province->cities as $city)
                                                            <option value="{{ $city->id }}"{{ $city->id == $branch->city_id ? ' selected' : '' }}>{{ $city->city_name }}</option>
    @endforeach
                                                        </optgroup>
@endforeach
                                                    </select>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[6] == explode('_', \Session::get('response_error'))[5])
                                                <p id="province_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[7] }}</p>
@endif

                                                <div class="mt-3 p-2 border overflow-auto" title="@lang('miscellaneous.pages_content.admin.branch.data.choose_managers')" style="max-height: 7rem;">
                                                    <p class="mt-0 mb-2 small">@lang('miscellaneous.pages_content.admin.branch.data.managers')</p>
@forelse ($available_managers as $manager)
                                                    <div class="form-check">
                                                        <input type="checkbox" name="users_ids[]" id="manager-{{ $manager->id }}" class="form-check-input" value="{{ $manager->id }}"{{ inArrayR($branch->id, $manager->branches, 'id') ? ' checked' : '' }}>
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
                                                <a href="{{ route('branch.home') }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE BRANCH-->
