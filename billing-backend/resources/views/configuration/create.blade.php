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

<div class="main_content_iner mt-5">
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
                            <small id="app-name-error" class="text-danger" style="display: none;">App name already exists.</small>
                        </div>
                        <div class="mb-3">
                            <label for="app_logo" class="form-label">Application Logo</label>
                            <input type="file" class="form-control" id="app_logo" name="app_logo" accept="image/*">
                            <small id="file-error" class="text-danger" style="display: none;"></small>
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
                            <button type="submit" id="submit-button" class="btn btn-success" disabled>Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('app_name').addEventListener('input', function () {
        const appName = this.value;
        const errorMessage = document.getElementById('app-name-error');
        const submitButton = document.getElementById('submit-button');

        errorMessage.style.display = 'none';

        if (appName.length > 0) {
            fetch(`{{ route('configuration.checkAppName') }}?app_name=${appName}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        errorMessage.style.display = 'block';
                        submitButton.disabled = true;  
                    } else {
                        errorMessage.style.display = 'none';
                        submitButton.disabled = false;  
                    }
                });
        } else {
            errorMessage.style.display = 'none';
            submitButton.disabled = false;  
        }
    });
    document.getElementById('app_logo').addEventListener('change', function () {
        const file = this.files[0];
        const errorMessage = document.getElementById('file-error');
        const submitButton = document.getElementById('submit-button');

        errorMessage.style.display = 'none';

        if (file) {
            const fileSize = file.size / 1024 / 1024; 
            const fileType = file.type;

            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!allowedTypes.includes(fileType)) {
                errorMessage.textContent = 'File type not supported. Please upload a JPEG, PNG, GIF, or JPG image.';
                errorMessage.style.display = 'block';
                submitButton.disabled = true;
                return;
            }

            if (fileSize > 2) {
                errorMessage.textContent = 'File size must be less than 2 MB.';
                errorMessage.style.display = 'block';
                submitButton.disabled = true;
                return;
            }   

            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    });
</script>

@endsection
