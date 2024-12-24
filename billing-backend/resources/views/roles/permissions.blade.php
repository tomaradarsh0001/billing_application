@extends('layouts.app')

@section('title', 'Manage Permissions for ' . $role->name)

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <h4>Manage Permissions for Role: {{ $role->name }}</h4>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <h5 class="mt-4">Assign Permissions</h5>
                <form action="{{ route('roles.permissions.add', $role->id) }}" method="POST">
                    @csrf
                    <div class="d-flex flex-wrap">
                        @foreach ($permissions as $permission)
                        <div class="form-check form-switch col-6 d-flex align-items-center gap-2 mb-3">
                            <input
                                type="checkbox"
                                id="permission_{{ $permission->id }}"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                class="form-check-input"
                                @if($role->permissions->contains($permission->id)) checked @endif>
                            <label for="permission_{{ $permission->id }}" class="form-check-label">
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-success">Save Permissions</button>
                </form>

                <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Back to Roles</a>
            </div>
        </div>
    </div>
</div>
@endsection