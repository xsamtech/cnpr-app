
                <!-- DEPARTMENTS LIST-->
                <section class="pt-5 pb-3">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-5 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-body pb-5">
                                            <form method="POST" action="{{ route('department.home') }}">
@csrf
                                                <h4 class="h4 mt-3 mb-4 text-center fw-bold">@lang('miscellaneous.pages_content.admin.department.add')</h4>

                                                <!-- Department name -->
                                                <div class="form-floating">
                                                    <input type="text" name="register_name" id="register_name" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.department.data.department_name')" aria-describedby="name_error_message" value="{{ \Session::has('response_error') ? explode('_', \Session::get('response_error'))[0] : '' }}" autofocus />
                                                    <label class="form-label" for="register_name">@lang('miscellaneous.pages_content.admin.department.data.department_name')</label>
                                                </div>
@if (\Session::has('response_error') && explode('_', \Session::get('response_error'))[1] == explode('_', \Session::get('response_error'))[0])
                                                <p id="name_error_message" class="text-center text-danger small">{{ explode('_', \Session::get('response_error'))[2] }}</p>
@endif

                                                <!-- Description -->
                                                <div class="form-floating mt-3">
                                                    <textarea name="register_description" id="register_description" class="form-control" placeholder="@lang('miscellaneous.pages_content.admin.department.data.department_description')"></textarea>
                                                    <label class="form-label" for="register_description">@lang('miscellaneous.pages_content.admin.department.data.department_description')</label>
                                                </div>

                                                <!-- Belongs to -->
                                                <div class="form-floating mt-3">
                                                    <p class="small m-0" for="belongs_to">@lang('miscellaneous.pages_content.admin.department.data.belongs_to')</p>
                                                    <select name="belongs_to" id="belongs_to" class="form-select pt-2 rounded-0">
                                                        <option class="small" selected disabled>@lang('miscellaneous.pages_content.admin.department.data.choose_belongs_to')</option>
    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}">{{ $department->department_name }}</option>
    @endforeach
                                                    </select>
                                                </div>

                                                <button class="btn btn-primary btn-block mt-3 rounded-pill" type="submit">@lang('miscellaneous.register')</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-sm-6">
                                    <div class="card rounded-4">
                                        <div class="card-header">
                                            <h5 class="card-title m-0">@lang('miscellaneous.pages_content.admin.department.list')</h5>
                                        </div>
                                        <div class="card-body p-2">
@if (count($departments) > 0)
                                            <div class="tree shadow-0">
                                                <ul class="ps-0">
    @foreach ($departments as $department)
        @if (empty($department->belongs_to))
                                                    <li>
                                                        <span class="d-block">
                                                            <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="bi bi-three-dots"></i>
                                                                </a>

                                                                <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                    <a class="dropdown-item" href="{{ route('department.datas', ['id' => $department->id]) }}">@lang('miscellaneous.change')</a>
                                                                    <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $department->id]) }}">@lang('miscellaneous.delete')</a>
                                                                </div>
                                                            </div>

                                                            <p class="m-0">{{ $department->department_name }}</p>
                                                        </span>
            @if ($department->siblings != null)
                                                        <ul>
                @foreach ($department->siblings as $sibling1)
                                                            <li>
                                                                <span class="d-block">
                                                                    <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="bi bi-three-dots"></i>
                                                                        </a>
        
                                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                            <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling1->id]) }}">@lang('miscellaneous.change')</a>
                                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling1->id]) }}">@lang('miscellaneous.delete')</a>
                                                                        </div>
                                                                    </div>

                                                                    <p class="m-0">{{ $sibling1->department_name }}</p>
                                                                </span>
                    @if ($sibling1->siblings != null)
                                                                <ul>
                        @foreach ($sibling1->siblings as $sibling2)
                                                                    <li>
                                                                        <span class="d-block">
                                                                            <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <i class="bi bi-three-dots"></i>
                                                                                </a>
                
                                                                                <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                    <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling2->id]) }}">@lang('miscellaneous.change')</a>
                                                                                    <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling2->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                </div>
                                                                            </div>

                                                                            <p class="m-0">{{ $sibling2->department_name }}</p>
                                                                        </span>
                            @if ($sibling2->siblings != null)
                                                                        <ul>
                                @foreach ($sibling2->siblings as $sibling3)
                                                                            <li>
                                                                                <span class="d-block">
                                                                                    <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <i class="bi bi-three-dots"></i>
                                                                                        </a>
                        
                                                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                            <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling3->id]) }}">@lang('miscellaneous.change')</a>
                                                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling3->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                        </div>
                                                                                    </div>

                                                                                    <p class="m-0">{{ $sibling3->department_name }}</p>
                                                                                </span>
                                    @if ($sibling3->siblings != null)
                                                                                <ul>
                                        @foreach ($sibling3->siblings as $sibling4)
                                                                                    <li>
                                                                                        <span class="d-block">
                                                                                            <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                                <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                    <i class="bi bi-three-dots"></i>
                                                                                                </a>
                                
                                                                                                <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                                    <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling4->id]) }}">@lang('miscellaneous.change')</a>
                                                                                                    <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling4->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                                </div>
                                                                                            </div>

                                                                                            <p class="m-0">{{ $sibling4->department_name }}</p>
                                                                                        </span>
                                            @if ($sibling4->siblings != null)
                                                                                        <ul>
                                                @foreach ($sibling4->siblings as $sibling5)
                                                                                            <li>
                                                                                                <span class="d-block">
                                                                                                    <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                            <i class="bi bi-three-dots"></i>
                                                                                                        </a>
                                        
                                                                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                                            <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling5->id]) }}">@lang('miscellaneous.change')</a>
                                                                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling5->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <p class="m-0">{{ $sibling5->department_name }}</p>
                                                                                                </span>
                                                    @if ($sibling5->siblings != null)
                                                                                                <ul>
                                                        @foreach ($sibling5->siblings as $sibling6)
                                                                                                    <li>
                                                                                                        <span class="d-block">
                                                                                                            <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                                                <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                                    <i class="bi bi-three-dots"></i>
                                                                                                                </a>
                                                
                                                                                                                <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                                                    <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling6->id]) }}">@lang('miscellaneous.change')</a>
                                                                                                                    <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling6->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <p class="m-0">{{ $sibling6->department_name }}</p>
                                                                                                        </span>
                                                            @if ($sibling6->siblings != null)
                                                                                                        <ul>
                                                                @foreach ($sibling6->siblings as $sibling7)
                                                                                                            <li>
                                                                                                                <span class="d-block">
                                                                                                                    <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                                                        <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                                            <i class="bi bi-three-dots"></i>
                                                                                                                        </a>
                                                        
                                                                                                                        <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                                                            <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling7->id]) }}">@lang('miscellaneous.change')</a>
                                                                                                                            <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling7->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                                                        </div>
                                                                                                                    </div>

                                                                                                                    <p class="m-0">{{ $sibling7->department_name }}</p>
                                                                                                                </span>
                                                                    @if ($sibling7->siblings != null)
                                                                                                                <ul>
                                                                        @foreach ($sibling7->siblings as $sibling8)
                                                                                                                    <li>
                                                                                                                        <span class="d-block">
                                                                                                                            <div class="dropdown show float-end" style="margin-top: -5px;">
                                                                                                                                <a class="btn" role="button" id="dataLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                                                                    <i class="bi bi-three-dots"></i>
                                                                                                                                </a>
                                                                
                                                                                                                                <div class="dropdown-menu" aria-labelledby="dataLink">
                                                                                                                                    <a class="dropdown-item" href="{{ route('department.datas', ['id' => $sibling8->id]) }}">@lang('miscellaneous.change')</a>
                                                                                                                                    <a class="dropdown-item" href="{{ route('delete', ['entity' => 'department', 'id' => $sibling8->id]) }}">@lang('miscellaneous.delete')</a>
                                                                                                                                </div>
                                                                                                                            </div>

                                                                                                                            <p class="m-0">{{ $sibling8->department_name }}</p>
                                                                                                                        </span>

                                                                                                                    </li>
                                                                        @endforeach
                                                                                                                </ul>
                                                                    @endif

                                                                                                            </li>
                                                                @endforeach
                                                                                                        </ul>
                                                            @endif

                                                                                                    </li>
                                                        @endforeach
                                                                                                </ul>
                                                    @endif

                                                                                            </li>
                                                @endforeach
                                                                                        </ul>
                                            @endif

                                                                                    </li>
                                        @endforeach
                                                                                </ul>
                                    @endif

                                                                            </li>
                                @endforeach
                                                                        </ul>
                            @endif
                                                                    </li>
                        @endforeach
                                                                </ul>
                    @endif
                                                            </li>
                @endforeach
                                                        </ul>
            @endif
                                                    </li>

        @endif
    @endforeach
                                                </ul>
                                            </div>
@else
                                            <p class="card-text m-0 text-center">@lang('miscellaneous.empty_list')</p>
@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END DEPARTMENTS LIST-->
