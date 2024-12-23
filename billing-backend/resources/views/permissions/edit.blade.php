@extends('layouts.app')

@section('content')
<div class="main_content_iner mt-5">
    <div class="col-lg-6">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">    
                <h4>Edit Permission</h4>

                <form action="{{ route('permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
                    </div>
                    <div id="name-error" class="text-danger" style="display: none;">
                        Permission name already exists.
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" id="submit-button">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('input', function () {
        const permissionName = this.value; 
        const errorMessage = document.getElementById('name-error');
        const submitButton = document.getElementById('submit-button');
        
        if (permissionName.length > 0) {
            fetch(`{{ route('permissions.checkName') }}?name=${permissionName}`)
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
</script>
@endsection
