
                <!-- UPDATE CITY-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('province.entity.datas', ['entity' => 'city', 'id' => $city->id]) }}">
@csrf
                                                <input type="hidden" name="city_id" value="{{ $city->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.province.city.edit')</h4>

                                                <!-- City name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.province.city.data.city_name')" aria-describedby="name_error_message" value="{{ $city->city_name }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.province.city.data.city_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <!-- Choose province -->
                                                <div class="form-floating mt-3" aria-describedby="province_error_message">
                                                    <select name="province_id" id="province_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" disabled>@lang('miscellaneous.pages_content.admin.province.city.data.choose_province')</option>
@forelse ($provinces as $province)
                                                        <option value="{{ $province->id }}"{{ $city->province_id == $province->id ? ' selected' : '' }}>{{ $province->province_name }}</option>
@empty
                                                        <option>@lang('miscellaneous.empty_list')</option>
@endforelse
                                                    </select>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[1])
                                                <p id="province_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
@endif

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('province.entity.home', ['entity' => 'city']) }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE CITY-->
