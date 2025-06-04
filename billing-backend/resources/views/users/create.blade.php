@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    @if(session('success'))
                    <div class="alert text-white bg-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <!-- Error message -->
                    @if(session('error'))
                    <div class="alert text-white bg-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Create New User</h4>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter user name" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter user email" value="{{ old('email') }}" required>
                            <small id="email-error" class="text-danger" style="display: none;">Email already exists.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <div id="roles">
                                @foreach ($roles as $role)
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->id }}"
                                        id="role_{{ $role->id }}"
                                        {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Select one or more roles for the user.</small>
                        </div> --}}

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('email').addEventListener('input', function() {
        let email = this.value;
        let errorElement = document.getElementById('email-error');
        let submitButton = document.getElementById('submit-btn');

        if (email.length > 0) {
            fetch(`/check-email/${email}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        errorElement.style.display = 'block';
                        submitButton.disabled = true;
                    } else {
                        errorElement.style.display = 'none';
                        submitButton.disabled = false;
                    }
                });
        } else {
            errorElement.style.display = 'none';
            submitButton.disabled = false;
        }
    });
</script>
@endsection
