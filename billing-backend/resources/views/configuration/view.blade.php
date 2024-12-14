@extends('layouts.app')
@section('title', 'Configuration Details')
@section('content')
<title>Configurations</title>
    <div class="main_content_iner mt-5">
        <div class="col-lg-6">
            <div class="card_box box_shadow position-relative ">
                <div class="white_box_tittle">
                    <div class="main-title2">
                        <h4 class="nowrap">Configuration Details</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong>Application Name:</strong> {{ $configuration->app_name }}
                    </div>
                    <div class="mb-3">
                        <strong>Tagline:</strong> {{ $configuration->app_tagline }}
                    </div>
                    <div class="mb-3">
                        <strong>Theme:</strong>
                        <span class="badge" style="background-color: {{ $configuration->app_theme }};">
                            {{ $configuration->app_theme }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <strong>Logo:</strong>
                        @if($configuration->app_logo)
                            <img src="{{ asset('storage/' . $configuration->app_logo) }}" alt="Logo" width="100">
                        @else
                            <span>No Logo</span>
                        @endif
                    </div>
                    <a href="{{ route('configuration.index') }}" class="btn btn-secondary">Back to List</a>
                </div>

            </div>
        </div>
    </div>
@endsection
