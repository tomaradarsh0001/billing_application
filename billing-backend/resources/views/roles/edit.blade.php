@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-6">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">    
                <h4>Edit Role</h4>

                <!-- Form to edit the role -->
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                        <small id="role-name-error" class="form-text text-danger" style="display: none;">Role name already exists.</small>
                    </div>

                    <!-- Hidden field to include role ID -->
                    <input type="hidden" id="role-id" value="{{ $role->id }}">

                    <button type="submit" class="btn btn-primary mt-3" id="submit-button">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('input', function () {
        const roleName = this.value;
        const roleId = document.getElementById('role-id').value; 
        const errorMessage = document.getElementById('role-name-error');
        const submitButton = document.getElementById('submit-button');

        if (roleName.length > 0) {
            fetch(`{{ route('roles.checkNameEdit') }}?name=${roleName}&role=${roleId}`)
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
