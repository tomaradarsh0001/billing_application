@extends('layouts.app')

@section('title', 'Error 403')

@section('content')

<div class="error_page_wrapper">
    <div class="error_wrap">
        <div class="container text-center">
            <img src="{{ asset('assets/img/bak_hovers/sad.png') }}" alt="Error Image">
            <div class="error_heading text-center m-3">
                <h3 class="headline font-danger theme_color_1">403</h3>
            </div>
            <div class="col-md-8 offset-md-2 text-center">
                <p>The page you are attempting to reach is currently not available. This may be because the page does not exist or has been moved.</p>
            </div>
            <div class="error_btn text-center m-3">
                <a class="default_btn theme_bg_1" href="{{ url('/') }}">Back Home</a>
            </div>
        </div>
    </div>
</div>

@endsection
