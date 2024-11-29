
                <!-- BREADCRUMB-->
@if (Route::is('home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">@lang('miscellaneous.menu.home')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('about'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.about')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('search'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.search_result')@lang('miscellaneous.colon_after_word') <strong>{{ $data }}</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('message.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.messages')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('message.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item active">
                                                    <a href="{{ route('message.home') }}">@lang('miscellaneous.menu.messages')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.messages')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('message.new'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('message.home') }}">@lang('miscellaneous.menu.messages')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.message.new')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('account'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.account_settings')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('account.update.password'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('account') }}">@lang('miscellaneous.menu.account_settings')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.account.update_password.title')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('notifications'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.notifications')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('history'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.activities_history')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('communique.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.manager.communiques')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('communique.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('communique.home') }}">@lang('miscellaneous.menu.manager.communiques')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.manager.home.communiques.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('task.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.manager.tasks')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('task.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('task.home') }}">@lang('miscellaneous.menu.manager.tasks')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.manager.home.tasks.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('province.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.admin.province.title')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('province.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('province.home') }}">@lang('miscellaneous.menu.admin.province.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.admin.province.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('province.entity.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('province.home') }}">@lang('miscellaneous.menu.admin.province.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_title }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('province.entity.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('province.home') }}">@lang('miscellaneous.menu.admin.province.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('province.entity.home', ['entity' => $entity]) }}">{{ $entity_title }}</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_details }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('group.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.admin.group.title')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('group.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('group.home') }}">@lang('miscellaneous.menu.admin.group.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.admin.group.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('group.entity.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('group.home') }}">@lang('miscellaneous.menu.admin.group.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_title }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('group.entity.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('group.home') }}">@lang('miscellaneous.menu.admin.group.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('group.entity.home', ['entity' => $entity]) }}">{{ $entity_title }}</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_details }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('role.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.admin.role.title')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('role.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('role.home') }}">@lang('miscellaneous.menu.admin.role.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.admin.role.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('role.entity.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('role.home') }}">@lang('miscellaneous.menu.admin.role.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_title }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('role.entity.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('role.home') }}">@lang('miscellaneous.menu.admin.role.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('role.entity.home', ['entity' => $entity]) }}">{{ $entity_title }}</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_details }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('vacation.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.admin.vacation')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('vacation.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('vacation.home') }}">@lang('miscellaneous.menu.admin.vacation')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.admin.vacation.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('department.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.admin.department')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('department.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('department.home') }}">@lang('miscellaneous.menu.admin.department')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.admin.department.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('branch.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.admin.branch')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('branch.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('branch.home') }}">@lang('miscellaneous.menu.admin.branch')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.admin.branch.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('employee.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.menu.manager.employees.title')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('employee.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('employee.home') }}">@lang('miscellaneous.menu.manager.employees.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">@lang('miscellaneous.pages_content.manager.home.employees.details')</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('employee.entity.home'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('employee.home') }}">@lang('miscellaneous.menu.manager.employees.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_title }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif

@if (Route::is('employee.entity.datas'))
                <section class="au-breadcrumb m-t-75 border-bottom">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="au-breadcrumb-content">
                                        <div class="au-breadcrumb-left">
                                            <ul class="list-unstyled list-inline au-breadcrumb__list">
                                                <li class="list-inline-item active">
                                                    <a href="{{ route('home') }}">@lang('miscellaneous.menu.home')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('employee.home') }}">@lang('miscellaneous.menu.manager.employees.title')</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="{{ route('employee.entity.home', ['entity' => $entity]) }}">{{ $entity_title }}</a>
                                                </li>
                                                <li class="list-inline-item seprate">
                                                    <span>/</span>
                                                </li>
                                                <li class="list-inline-item">{{ $entity_details }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
@endif
                <!-- END BREADCRUMB-->
