@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <h4>Create Role</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Role Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}" 
                            placeholder="Enter role name" 
                            required>
                        <small id="role-name-error" class="form-text text-danger" style="display: none;">Role name already exists.</small>
                    </div>

                    <div class="mb-3">
                        <label for="permissions" class="form-label">Assign Permissions</label>
                        <div class="d-flex flex-wrap">
                            @foreach ($permissions as $permission)
                                <div class="form-check form-switch col-6 d-flex align-items-center gap-1" style="white-space: nowrap;">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="permission-{{ $permission->id }}" 
                                        name="permissions[]" 
                                        value="{{ $permission->id }}"
                                        {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success" id="submit-button">Create Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('name').addEventListener('input', function () {
        const roleName = this.value;
        const errorMessage = document.getElementById('role-name-error');
        const submitButton = document.getElementById('submit-button');
        if (roleName.length > 0) {
            fetch(`{{ route('roles.checkName') }}?name=${roleName}`)
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
