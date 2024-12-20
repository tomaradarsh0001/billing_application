@extends('layouts.app')

@section('content')
<div class="main_content_iner mt-5">
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

                    <button type="submit" class="btn btn-success">Create Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
