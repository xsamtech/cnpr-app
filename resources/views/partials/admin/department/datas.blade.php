
                <!-- UPDATE DEPARTMENT-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6 mx-auto">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('department.datas', ['id' => $department->id]) }}">
@csrf
                                                <input type="hidden" name="department_id" value="{{ $department->id }}">
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.department.edit')</h4>

                                                <!-- Department name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.department.data.department_name')" aria-describedby="name_error_message" value="{{ $department->department_name }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.department.data.department_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[1] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[2] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.department.data.department_description')">{{ $department->department_description }}</textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.department.data.department_description')</label>
                                                </div>

                                                <!-- Belongs to -->
                                                <div class="form-floating mt-3">
                                                    <p class="small m-0" for="belongs_to">@lang('miscellaneous.pages_content.admin.department.data.belongs_to')</p>
                                                    <select name="belongs_to" id="belongs_to" class="form-select pt-2 rounded-0">
                                                        <option class="small"{{ $department->belongs_to == null ? ' selected' : '' }} disabled>@lang('miscellaneous.pages_content.admin.department.data.choose_belongs_to')</option>
@foreach ($departments as $other_department)
    @if ($other_department->id != $department->id)
                                                        <option value="{{ $other_department->id }}"{{ $other_department->id == $department->belongs_to ? ' selected' : '' }}>{{ $other_department->department_name }}</option>
    @endif
@endforeach
                                                    </select>
                                                </div>


                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                                <a href="{{ route('department.home') }}" class="btn btn-light btn-block mt-2 border rounded-pill">@lang('miscellaneous.cancel')</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END UPDATE DEPARTMENT-->
