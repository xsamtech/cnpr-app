
                <!-- CITIES LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
@if (count($provinces) > 0)
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('province.entity.home', ['entity' => 'city']) }}">
    @csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.province.city.add')</h4>

                                                <!-- City name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.province.city.data.city_name')" aria-describedby="name_error_message" value="{{ \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.province.city.data.city_name')</label>
                                                </div>
    @if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
    @endif

                                                <!-- Choose province -->
                                                <div class="form-floating mt-3" aria-describedby="province_error_message">
                                                    <select name="province_id" id="province_id" class="form-select pt-2 rounded-0">
                                                        <option class="small" selected disabled>@lang('miscellaneous.pages_content.admin.province.city.data.choose_province')</option>
    @forelse ($provinces as $province)
                                                        <option value="{{ $province->id }}">{{ $province->province_name }}</option>
    @empty
                                                        <option>@lang('miscellaneous.empty_list')</option>
    @endforelse
                                                    </select>
                                                </div>
    @if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[1])
                                                <p id="province_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
    @endif

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.province.city.list')</h5>
                                        </div>

                                        <ul class="list-group list-group-flush rounded-4">
    @if (count($cities) > 0)
        @foreach ($provinces as $province)
            @if (count($province->cities) > 0)
                                            <li class="list-group-item pb-3">
                                                <h6 class="h6 fw-bold">{{ $province->province_name }}</h6>

                                                <ul class="list-group">
                @foreach ($province->cities as $city)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <h6 class="h6 m-0">{{ $city->city_name }}</h6>

                                                        <div class="dropdown show">
                                                            <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="bi bi-three-dots"></i>
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                <a class="dropdown-item" href="{{ route('province.entity.datas', ['entity' => 'city', 'id' => $city->id]) }}">@lang('miscellaneous.change')</a>
                                                                <a class="dropdown-item" href="{{ route('delete', ['entity' => 'city', 'id' => $city->id]) }}">@lang('miscellaneous.delete')</a>
                                                            </div>
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
                                            <p class="card-text text-center">@lang('miscellaneous.pages_content.admin.province.city.empty_province')</p>
                                        </div>
                                        <div class="card-footer text-center">
                                            <a href="{{ route('province.home') }}" class="btn-link">@lang('miscellaneous.pages_content.admin.province.link')<i class="bi bi-chevron-double-right ms-2 align-middle"></i></a>
                                        </div>
                                    </div>
                                </div>
@endif
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END CITIES LIST-->
    
