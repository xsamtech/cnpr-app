@extends('layouts.app')

@section('app-content')

    @if (Route::is('branch.home'))
        @include('partials.admin.branch.home')
    @endif

    @if (Route::is('branch.datas'))
        @include('partials.admin.branch.datas')
    @endif

@endsection
