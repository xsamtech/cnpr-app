@extends('layouts.app')

@section('app-content')

    @if (Route::is('group.home'))
        @include('partials.admin.group.home')
    @endif

    @if (Route::is('group.datas'))
        @include('partials.admin.group.datas')
    @endif

    @if (Route::is('group.entity.home'))
        @if ($entity == 'status')
            @include('partials.admin.status.home')
        @endif

        @if ($entity == 'type')
            @include('partials.admin.type.home')
        @endif
    @endif

    @if (Route::is('group.entity.datas'))
        @if ($entity == 'status')
            @include('partials.admin.status.datas')
        @endif

        @if ($entity == 'type')
            @include('partials.admin.type.datas')
        @endif
    @endif

@endsection

