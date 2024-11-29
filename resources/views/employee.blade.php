@extends('layouts.app')

@section('app-content')

    @if (Route::is('employee.home'))
        @include('partials.manager.employee.home')
    @endif

    @if (Route::is('employee.datas'))
        @include('partials.manager.employee.datas')
    @endif

    @if (Route::is('employee.entity.home'))
        @if ($entity == 'paid_unpaid')
            @include('partials.manager.paid_unpaid.home')
        @endif

        @if ($entity == 'presence_absence')
            @include('partials.manager.presence_absence.home')
        @endif
    @endif

    @if (Route::is('employee.entity.datas'))
        @if ($entity == 'paid_unpaid')
            @include('partials.manager.paid_unpaid.datas')
        @endif

        @if ($entity == 'presence_absence')
            @include('partials.manager.presence_absence.datas')
        @endif
    @endif

@endsection
