@extends('layouts.app')

@section('app-content')

    @if (Route::is('role.home'))
        @include('partials.admin.role.home')
    @endif

    @if (Route::is('role.datas'))
        @include('partials.admin.role.datas')
    @endif

    @if (Route::is('role.entity.home'))
        @if ($entity == 'other_admins')
            @include('partials.admin.admins.home')
        @endif

        @if ($entity == 'managers')
            @include('partials.admin.managers.home')
        @endif
    @endif

    @if (Route::is('role.entity.datas'))
        @if ($entity == 'other_admins')
            @include('partials.admin.admins.datas')
        @endif

        @if ($entity == 'managers')
            @include('partials.admin.managers.datas')
        @endif
    @endif

@endsection
