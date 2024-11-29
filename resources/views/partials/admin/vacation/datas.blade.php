
                <!-- UPDATE VACATION -->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('vacation.datas', ['id' => $vacation->id]) }}">
@csrf
                                                <input type="hidden" name="vacation_id" value="{{ $vacation->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.vacation.edit')</h4>

                                                <!-- Date -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_other_date" id="register_otherdate" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.vacation.data.date')" aria-describedby="day_month_error_message" value="{{ str_starts_with(app()->getLocale(), 'fr') ? \Carbon\Carbon::createFromFormat('Y-m-d', $vacation->year . '-' . $vacation->day_month)->format('d/m/Y') : \Carbon\Carbon::createFromFormat('Y-m-d', $vacation->year . '-' . $vacation->day_month)->format('m/d/Y') }}" />
                                                    <label class="form-label" for="register_other_date">@lang('miscellaneous.pages_content.admin.vacation.data.date')</label>
                                                </div>
@if (\Session::has('response_error'))
    @if (explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[0] || explode('_', \Session::get('response_error'))[2] == explode('_', \Session::get('response_error'))[1])
                                                <p id="day_month_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[3] }}</p>
    @endif
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.vacation.data.vacation_description')" autofocus>{{ $vacation->vacation_description }}</textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.vacation.data.vacation_description')</label>
                                                </div>

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('vacation.home') }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE VACATION -->
