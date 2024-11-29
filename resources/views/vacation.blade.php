@extends('layouts.app')

@section('app-content')

    @if (Route::is('vacation.home'))
        @include('partials.admin.vacation.home')
    @endif

    @if (Route::is('vacation.datas'))
        @include('partials.admin.vacation.datas')
    @endif

@endsection
