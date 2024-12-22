@extends('layouts.app')
@section('title', 'Users')
@section('content')

<div class="main_content_iner mt-5">
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
                    @if(session('error'))
                    <div class="alert text-white bg-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Edit User</h4>
                    </div>

                    <form action="{{ route('users.updateperandroles', $user) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <!-- Left Section -->
                            <div class="col-md-6 border-end pe-3">
                                <!-- Name Section -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control"
                                        placeholder="Enter user name"
                                        value="{{ old('name', $user->name) }}"
                                        required>
                                </div>

                                <!-- Roles Section -->
                                <div class="mt-4">
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
                                </div>
                            </div>

                            <!-- Right Section -->
                            <div class="col-md-6 ps-3">
                                <label for="permissions" class="form-label">Permissions</label>
                                <div class="d-flex flex-wrap" id="permissions">
                                    @foreach ($permissions as $permission)
                                    <div class="form-check form-switch col-6 d-flex align-items-center gap-2 mb-3">
                                        <input
                                            type="checkbox"
                                            id="permission_{{ $permission->id }}"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            class="form-check-input"
                                            @if(in_array($permission->id, $userPermissions)) checked @endif
                                        @foreach($roles as $role)
                                        @if($role->permissions->contains($permission->id))
                                        {{ $user->hasRole($role) ? 'checked' : '' }}
                                        @endif
                                        @endforeach
                                        >
                                        <label for="permission_{{ $permission->id }}" class="form-check-label">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection