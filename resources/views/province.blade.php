@extends('layouts.app')

@section('app-content')

    @if (Route::is('province.home'))
        @include('partials.admin.province.home')
    @endif

    @if (Route::is('province.datas'))
        @include('partials.admin.province.datas')
    @endif

    @if (Route::is('province.entity.home'))
        @if ($entity == 'city')
            @include('partials.admin.city.home')
        @endif
    @endif

    @if (Route::is('province.entity.datas'))
        @if ($entity == 'city')
            @include('partials.admin.city.datas')
        @endif
    @endif

@endsection

