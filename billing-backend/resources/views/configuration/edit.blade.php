@extends('layouts.app')
@section('title', 'Edit Configuration')
@section('content')
<title>Configurations</title>
<div class="main_content_iner  mt-5">
    <div class="col-lg-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h4 class="m-0">Edit Configuration</h4>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
            <form action="{{ route('configuration.update', $configuration->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="app_name" class="form-label">Application Name</label>
                    <input type="text" class="form-control" id="app_name" name="app_name" value="{{ $configuration->app_name }}" required>
                </div>
                <div class="mb-3">
                    <label for="app_logo" class="form-label">Application Logo</label>
                    <input type="file" class="form-control" id="app_logo" name="app_logo" accept="image/*">
                    @if($configuration->app_logo)
                        <img src="{{ asset('storage/' . $configuration->app_logo) }}" alt="Logo" width="100" class="mt-2">
                    @endif
                </div>
                <div class="mb-3">
                    <label for="app_tagline" class="form-label">Application Tagline</label>
                    <input type="text" class="form-control" id="app_tagline" name="app_tagline" value="{{ $configuration->app_tagline }}">
                </div>
                <div class="mb-3">
                    <label for="app_theme" class="form-label">Application Theme</label>
                    <input type="color" class="form-control form-control-color" id="app_theme" name="app_theme" value="{{ $configuration->app_theme }}">
                    <small class="form-text text-muted">Pick a color to set your app's theme.</small>
                </div>
                <button type="submit" class="btn btn-success">Update Configuration</button>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
