@extends('layouts.app')
@section('title', 'Edit Configuration')
@section('content')
<div class="main_content_iner">
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
                            <small id="app-name-error" class="text-danger" style="display: none;">App name already exists.</small>
                        </div>
                        <div class="mb-3">
                           <label for="app_logo" class="form-label">Application Logo</label>
                           <input type="file" class="form-control" id="app_logo" name="app_logo" accept="image/*">
                           @if($configuration->app_logo)
                               <div class="mt-2">
                                   <p>Current logo: {{ basename($configuration->app_logo) }}</p>
                                   <img src="{{ asset('storage/' . $configuration->app_logo) }}" alt="Logo" width="100">
                               </div>
                           @endif
                           <small id="file-error" class="text-danger" style="display: none;"></small>
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
                        <button type="submit" id="submit-button" class="btn btn-success">Update Configuration</button>
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
        const appId = "{{ $configuration->id }}"; 

        if (appName.length > 0) {
            fetch(`{{ route('configuration.checkAppNameEdit') }}?app_name=${encodeURIComponent(appName)}&id=${appId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        errorMessage.style.display = 'block';
                        submitButton.disabled = true;  
                    } else {
                        errorMessage.style.display = 'none';
                        submitButton.disabled = false;  
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
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
