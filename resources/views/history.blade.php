@extends('layouts.app')

@section('app-content')

                <!-- USER ACTIVITIES HISTORY-->
                <section class="pt-4 pb-5">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div id="scope" class="card rounded-4 overflow-hidden">
                                        <div id="items" class="list-group list-group-flush">
    @forelse ($activities_history as $activity)
                                            <a href="{{ $activity->history_url }}" id="item" class="list-group-item list-group-item-action d-sm-flex justify-content-between align-items-center">
                                                <h6 class="h6 m-0">
                                                    <div class="badge bg-{{ $activity->color }} me-2 fs-6 p-2 rounded-circle" style="width: 31px; height: 31px;"> <i class="{{ $activity->icon }}"></i></div>
                                                    {{ $activity->history_content }}
                                                </h6>
                                                <small class="small text-muted float-end">{{ $activity->created_at_ago }}</small>
                                            </a>
    @empty
                                            <span class="list-group-item">
                                                <p class="m-0 small text-center">@lang('miscellaneous.empty_list')</p>
                                            </span>
    @endforelse
                                            <a role="button" class="next-page-link list-group-item list-group-item-action bg-light"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END USER ACTIVITIES HISTORY-->

@endsection

