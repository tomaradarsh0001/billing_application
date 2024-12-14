@extends('layouts.app')
@section('title', 'Configurations')
@section('content')
<title>Configurations</title>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="main_content_iner  mt-5">
    <div class="col-lg-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h4 class="m-0">Add Configuration</h4>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
                    <form action="{{ route('configuration.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="app_name" class="form-label">Application Name</label>
                            <input type="text" class="form-control" id="app_name" name="app_name" placeholder="Enter Application Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="app_logo" class="form-label">Application Logo</label>
                            <input type="file" class="form-control" id="app_logo" name="app_logo" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="app_tagline" class="form-label">Application Tagline</label>
                            <input type="text" class="form-control" id="app_tagline" name="app_tagline" placeholder="Enter Application Tagline">
                        </div>
                        <div class="mb-3">
                            <label for="app_theme" class="form-label">Application Theme</label>
                            <input type="color" class="form-control form-control-color" id="app_theme" name="app_theme" value="#000000" title="Choose your color">
                            <small class="form-text text-muted">Pick a color to set your app's theme.</small>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
