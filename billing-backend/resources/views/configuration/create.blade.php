@extends('layouts.app')
@section('title', 'Configurations')
@section('content')

@if(session('success'))
<div class="alert text-white bg-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
<div class="alert text-white bg-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<link id="google-fonts" rel="stylesheet" href="" />

<div class="main_content_iner">
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
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="app_name" class="form-label">Application Name</label>
                                <input type="text" class="form-control" id="app_name" name="app_name" placeholder="Enter Application Name" required>
                                <small id="app-name-error" class="text-danger" style="display: none;">App name already exists.</small>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="app_logo" class="form-label">Application Logo</label>
                                <input type="file" class="form-control" id="app_logo" name="app_logo" accept="image/*">
                                <small id="file-error" class="text-danger" style="display: none;"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="app_purpose" class="form-label">Application Purpose</label>
                                <input type="text" class="form-control" id="app_purpose" name="app_purpose" placeholder="Enter Application Purpose">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="app_tagline" class="form-label">Application Tagline</label>
                                <input type="text" class="form-control" id="app_tagline" name="app_tagline" placeholder="Enter Application Tagline">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-5">
                                <label for="app_font_primary" class="form-label">Select Primary Font</label>
                                <select name="app_font_primary" id="app_font_primary" class="form-control-select" onchange="applyFontToDropdownPri()">
                                    @foreach ($fonts as $font)
                                        @php
                                            $fontFamily = strtolower($font['family']);
                                            $spaced = preg_replace('/(?<!^)([A-Z])/', ' $1', $fontFamily);
                                            $fontFamily = ucwords($spaced);
                                        @endphp
                                        <option value="{{ $fontFamily }}" data-font-family="{{ $font['family'] }}" style="font-family: '{{ $font['family'] }}'"
                                        @if($font['family'] == 'Signika') selected @endif>
                                        {{ $font['family'] }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-1">
                                <div id="sample-text" style="font-size: 22px; margin: 31px 0px 0px 0px; font-family; $font['family'] == 'Signika'">
                                    Sample Text
                                </div>
                            </div>                       
                            <div class="mb-3 col-md-5">
                                <label for="app_font_secondary" class="form-label">Select Secondary Font</label>
                                <select name="app_font_secondary" id="app_font_secondary" class="form-control-select" onchange="applyFontToDropdownSec()">
                                    @foreach ($fonts as $font)
                                        @php
                                            $fontFamily = strtolower($font['family']);
                                            $spaced = preg_replace('/(?<!^)([A-Z])/', ' $1', $fontFamily);
                                            $fontFamily = ucwords($spaced);
                                        @endphp
                                         <option value="{{ $fontFamily }}" data-font-family="{{ $font['family'] }}" style="font-family: '{{ $font['family'] }}'"
                                         @if($font['family'] == 'Signika') selected @endif>
                                         {{ $font['family'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-1">
                                <div id="sample-text-secondary" style="font-size: 22px; margin: 31px 0px 0px 0px;">
                                    Sample Text
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="app_theme" class="form-label">Application Theme</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div>
                                    <label>Primary Light</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_primary_light" name="app_theme_primary_light" value="#93bded" title="Choose your color">
                                </div>
                                <div>
                                    <label>Primary Dark</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_primary_dark" name="app_theme_primary_dark" value="#4b98f0" title="Choose your color">
                                </div>
                                <div>
                                    <label>Secondary Light</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_secondary_light" name="app_theme_secondary_light" value="#d7e9f8" title="Choose your color">
                                </div>
                                <div>
                                    <label>Secondary Dark</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_secondary_dark" name="app_theme_secondary_dark" value="#c0d7ea" title="Choose your color">
                                </div>
                                <div>
                                    <label>Background</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_background" name="app_theme_background" value="#ffffff" title="Choose your color">
                                </div>
                                <div>
                                    <label>Text Primary</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_text_primary" name="app_theme_text_primary" value="#649ad9" title="Choose your color">
                                </div>
                                <div>
                                    <label>Text Secondary</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_text_secondary" name="app_theme_text_secondary" value="#5d6269" title="Choose your color">
                                </div>
                                <div>
                                    <label>Circle SVG Login</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_svg_login" name="app_theme_svg_login" value="#cfefff" title="Choose your color">
                                </div>
                                <div>
                                    <label>Circle SVG Signup</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_svg_signup" name="app_theme_svg_signup" value="#8ebdf2" title="Choose your color">
                                </div>
                                <div>
                                    <label>Page Links</label>
                                    <input type="color" class="form-control form-control-color" id="app_theme_links" name="app_theme_links" value="#2b48aa" title="Choose your color">
                                </div>
                            </div>
                            <small class="form-text text-muted">Set to Default app's theme.</small>
                        </div>
                        <div class="mb-3">
                            <button type="submit" id="submit-button" class="btn btn-success" disabled>Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function applyFontToDropdownPri() {
        var selectElement = document.getElementById('app_font_primary');
        var fontFamily = selectElement.value;
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var fontFamilyName = selectedOption.getAttribute('data-font-family');
        var link = document.getElementById('google-fonts-primary');
        if (!link) {
            link = document.createElement('link');
            link.id = 'google-fonts-primary';
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        }
        link.href = 'https://fonts.googleapis.com/css2?family=' + fontFamilyName + '&display=swap';
        document.getElementById('sample-text').style.fontFamily = fontFamilyName;
    }

    function applyFontToDropdownSec() {
        var selectElement = document.getElementById('app_font_secondary');
        var fontFamily = selectElement.value;
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var fontFamilyName = selectedOption.getAttribute('data-font-family');
        var link = document.getElementById('google-fonts-secondary');
        if (!link) {
            link = document.createElement('link');
            link.id = 'google-fonts-secondary';
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        }
        link.href = 'https://fonts.googleapis.com/css2?family=' + fontFamilyName + '&display=swap';
        document.getElementById('sample-text-secondary').style.fontFamily = fontFamilyName;
    }
</script>
@endsection
