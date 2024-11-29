@extends('layouts.errors')

@section('error-content')

                            <div class="card border border-default rounded-5">
                                <div class="card-body py-5 text-center">
                                    <h1 class="display-1 fw-bold text-danger">405</h1>
                                    <h1 class="mb-4">{{ __('notifications.405_title') }}</h1>
                                    <p class="mb-4">{{ __('notifications.405_description') }}</p>
                                    <a href="{{ route('home') }}" class="btn btn-warning rounded-pill py-3 px-5 shadow-0">{{ __('miscellaneous.back_home') }}</a>
                                </div>
                            </div>

@endsection
