@extends('layouts.app')

@section('app-content')

    @if (inArrayR('Administrateur', $current_user->roles, 'role_name'))
        @include('partials.admin.home')
    @endif

    @if (inArrayR('Manager', $current_user->roles, 'role_name'))
        @include('partials.manager.home')
    @endif

    @if (inArrayR('Employé', $current_user->roles, 'role_name'))
        @include('partials.employee.home')
    @endif

@endsection

