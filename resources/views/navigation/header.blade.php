
                <!-- HEADER DESKTOP-->
                <header class="header-desktop2 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="header-wrap2 d-flex justify-content-between">
                                <div class="logo d-sm-none d-block">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('assets/img/logo.png') }}" alt="Cool Admin" width="40" />
                                    </a>
                                </div>

                                <div class="logo d-lg-none d-sm-block d-none">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('assets/img/logo-text.png') }}" alt="Cool Admin" width="160" />
                                    </a>
                                </div>

@include('partials.search.search_bar_1')

                                <div class="header-button2 float-end">
                                    <div class="header-button-item js-item-menu d-lg-none d-block">
                                        <i class="bi bi-search fs-4 align-text-top" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('miscellaneous.search')"></i>
                                        <div class="search-dropdown js-dropdown">
@include('partials.search.search_bar_2')
                                        </div>
                                    </div>

                                    <div class="header-button-item{{ count($ordinary_chats) > 0 ? ' has-noti' : '' }} js-item-menu pb-1">
                                        <i class="bi{{ count($ordinary_chats) > 0 ? ' bi-chat-quote-fill text-primary' : ' bi-chat-quote' }} fs-4 align-top" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('miscellaneous.menu.messages')"></i>
                                        <div class="email-dropdown js-dropdown">
@if (count($ordinary_chats) > 0)
                                            <div class="email__title">
                                                <p>{{ count($ordinary_chats) == 1 ? __('miscellaneous.one_message') : __('miscellaneous.count_notifications', ['count' => count($ordinary_chats)]) }}</p>
                                            </div>
    @forelse ($ordinary_chats as $message)
        @if ($loop->index < 4)
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="{{ !empty($message->user->avatar_url) ? $message->user->avatar_url : asset('assets/img/user.png') }}" alt="{{ $message->user->firstname . ' ' . $message->user->lastname }}" class="user-image" />
                                                </div>
                                                <div class="content">
                                                    <p>{{ $message->message_content }}</p>
                                                    <span>{{ $message->user->firstname . ' ' . $message->user->lastname . ', ' . $message->created_at_ago }}</span>
                                                </div>
                                                <a href="{{ $notif->notification_url }}" class="stretched_link"></a>
                                            </div>
        @endif
    @empty
    @endforelse
@else
                                            <div class="email__title">
                                                <p class="text-center">@lang('miscellaneous.no_message')</p>
                                            </div>
@endif
                                            <div class="email__footer bg-light">
                                                <a href="{{ route('message.home') }}" style="text-transform: inherit!important;">
                                                    @lang('miscellaneous.see_all_messages') <i class="bi bi-chevron-double-right ms-3"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="header-button-item{{ count($unread_notifications) > 0 ? ' has-noti' : '' }} js-item-menu pb-1">
                                        <i class="bi{{ count($unread_notifications) > 0 ? ' bi-bell-fill text-primary' : ' bi-bell' }} fs-4 align-top" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('miscellaneous.menu.notifications')"></i>
                                        <div class="notifi-dropdown js-dropdown">
@if (count($unread_notifications) > 0)
                                            <div class="notifi__title">
                                                <i role="button" class="bi bi-circle float-end fs-4" title="@lang('miscellaneous.mark_all_read')" data-bs-toggle="tooltip" data-bs-placement="auto" style="margin-top: -5px;" onclick="markAllRead('notification', {{ $current_user->id }});"></i>
                                                <p>
                                                    {{ count($unread_notifications) == 1 ? __('miscellaneous.one_notification') : __('miscellaneous.count_notifications', ['count' => count($unread_notifications)]) }}
                                                </p>
                                            </div>
    @forelse ($unread_notifications as $notif)
        @if ($loop->index < 4)
                                            <a href="{{ $notif->notification_url }}" id="notification-{{ $notif->id }}" class="notifi__item pt-2 d-inline-flex align-items-center" onclick="switchRead('notification', this);">
                                                <div class="bg-{{ $notif->color }} img-cir img-40">
                                                    <i class="{{ $notif->icon }}"></i>
                                                </div>
                                                <div class="content">
                                                    <p style="line-height: 1.2rem;">{{ $notif->notification_content }}</p>
                                                    <span class="date">{{ $notif->created_at_ago }}</span>
                                                </div>
                                            </a>
        @endif
    @empty
    @endforelse

@else
                                            <div class="notifi__title">
                                                <p class="text-center">@lang('miscellaneous.no_notification')</p>
                                            </div>
@endif
                                            <div class="notifi__footer bg-light">
                                                <a href="{{ route('notifications') }}" style="text-transform: inherit!important;">
                                                    @lang('miscellaneous.see_all_notifications') <i class="bi bi-chevron-double-right ms-3"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="account-wrap">
                                        <div class="account-item clearfix js-item-menu">
                                            <div class="image">
                                                <img src="{{ !empty($current_user->avatar_url) ? $current_user->avatar_url : asset('assets/img/user.png') }}" alt="{{ $current_user->firstname . ' ' . $current_user->lastname }}" class="user-image rounded-circle" style="width: 40px!important; margin-top: 0.15rem;" />
                                            </div>
                                            <div class="content d-lg-block d-none">
                                                <a class="js-acc-btn" href="{{ route('account') }}">{{ $current_user->firstname }}</a>
                                            </div>
                                            <div class="account-dropdown js-dropdown">
                                                <div class="info clearfix">
                                                    <div class="image">
                                                        <a href="{{ route('account') }}">
                                                            <img src="{{ !empty($current_user->avatar_url) ? $current_user->avatar_url : asset('assets/img/user.png') }}" alt="{{ $current_user->firstname . ' ' . $current_user->lastname }}" class="user-image" />
                                                        </a>
                                                    </div>
                                                    <div class="content">
                                                        <h4 class="name"><a href="{{ route('account') }}" class="fw-bold">{{ $current_user->firstname . ' ' . $current_user->lastname }}</a></h4>
                                                        <span class="email">{{ !empty($current_user->username) ? '@' . $current_user->username : (!empty($current_user->email) ? $current_user->email : $current_user->phone) }}</span>
                                                    </div>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <a href="{{ route('account') }}">
                                                        <i class="bi bi-gear fs-5"></i>@lang('miscellaneous.menu.account_settings')
                                                    </a>
                                                </div>
                                                <div class="account-dropdown__footer">
                                                    <a href="{{ route('logout') }}">
                                                        <i class="bi bi-power cnpr-align-middle"></i>@lang('miscellaneous.logout')
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="header-button-item d-lg-none d-inline-block ms-2 mr-0 js-sidebar-btn">
                                        <i class="bi bi-list fs-4 align-text-top"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- END HEADER DESKTOP-->
