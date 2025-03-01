@extends('layouts.app')

@section('app-content')

    @if (Route::is('employee.home'))
        @if (inArrayR('Manager', $current_user->roles, 'role_name'))
            @include('partials.manager.tasks.home')
        @else
            @include('partials.employee.tasks.home')
        @endif
    @endif

    @if (Route::is('employee.datas'))
        @if (inArrayR('Manager', $current_user->roles, 'role_name'))
            @include('partials.manager.tasks.datas')
        @else
            @include('partials.employee.tasks.datas')
        @endif
    @endif

@endsection
