@extends('layouts.app')

@section('app-content')

                <!-- USER NOTIFICATION-->
                <section class="pt-4 pb-5">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div id="scope" class="card rounded-4 overflow-hidden">
                                        <div class="card-header pb-2 d-flex justify-content-between align-items-center">
                                            <p class="m-0">{{ count($unread_notifications) > 0 ? (count($unread_notifications) == 1 ? __('miscellaneous.one_notification') : __('miscellaneous.count_notifications', ['count' => count($unread_notifications)])) : __('miscellaneous.no_notification') }}</p>
                                            <i role="button" class="bi bi-circle fs-4" title="@lang('miscellaneous.mark_all_read')" data-bs-toggle="tooltip" data-bs-placement="auto" onclick="markAllRead('notification', {{ $current_user->id }});"></i>
                                        </div>

                                        <ul id="items" class="list-group list-group-flush">
    @if (count($all_notifications) > 0)
        @foreach ($all_notifications as $notification)
                                            <li id="item" class="list-group-item list-group-item-action d-sm-flex justify-content-between">
                                                <h6 class="h6 small m-0">
                                                    <div class="badge bg-{{ $notification->color }} me-2 fs-6 p-2 rounded-circle" style="width: 31px; height: 31px;"> <i class="{{ $notification->icon }}"></i></div>
                                                    {{ $notification->notification_content }}
            @if ($notification->status->status_name == 'Non lue')
                                                    <a href="{{ $notification->notification_url }}" id="notification_link-{{ $notification->id }}" class="stretched-link" onclick="event.stopPropagation(); switchRead('notification', this)"></a>
            @else
                                                    <a href="{{ $notification->notification_url }}" id="notification_link-{{ $notification->id }}" class="stretched-link"></a>
            @endif
                                                </h6>

                                                <div class="d-inline-flex align-items-center float-end" style="z-index: 9999;">
                                                    <small class="small text-muted">{{ $notification->created_at_ago }}</small>
                                                    <button role="button" id="notification-{{ $notification->id }}" class="btn btn-outline-{{ $notification->status->status_name == 'Non lue' ? 'primary' : 'secondary' }} ms-1 px-2 py-1 border-0 rounded-circle" title="{{ $notification->status->status_name == 'Non lue' ? __('miscellaneous.mark_notification_read') : __('miscellaneous.mark_notification_unread') }}" onclick="event.stopPropagation(); switchRead('notification', this)"><i class="{{ $notification->status->icon }} text-{{ $notification->status->color }}"></i></button>
                                                </div>
                                            </li>
        @endforeach
                                            <li role="button" class="next-page-link list-group-item list-group-item-action bg-light"></a>
    @else
                                            <li class="list-group-item">
                                                <p class="m-0 text-center">@lang('miscellaneous.no_notification')</p>
                                            </li>
    @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- END USER NOTIFICATION-->

@endsection

