@extends('layouts.app')

@section('title', 'Edit User')

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
                        <h4>Edit User</h4>
                    </div>

                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter user name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter user email" value="{{ old('email', $user->email) }}" required>
                            <small id="email-error" class="text-danger" style="display: none;">Email already exists.</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank if not changing">
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
                                        {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('email').addEventListener('input', function () {
        const email = this.value;
        const errorElement = document.getElementById('email-error');
        const submitButton = document.getElementById('submit-btn');
        const currentEmail = "{{ $user->email }}";
        const userId = "{{ $user->id }}"; 
        if (email !== currentEmail && email.length > 0) {
            fetch(`{{ route('users.checkEmailEdit') }}?email=${email}&id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        errorElement.style.display = 'block';
                        submitButton.disabled = true;
                    } else {
                        errorElement.style.display = 'none';
                        submitButton.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            errorElement.style.display = 'none';
            submitButton.disabled = false;
        }
    });
</script>

@endsection
