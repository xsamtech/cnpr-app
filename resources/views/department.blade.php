@extends('layouts.app')

@section('app-content')

    @if (Route::is('department.home'))
        @include('partials.admin.department.home')
    @endif

    @if (Route::is('department.datas'))
        @include('partials.admin.department.datas')
    @endif

@endsection
