@extends('layouts.app')

@section('content')
    <h1>Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('POST')
        <div>
            <label>Roles:</label>
            @foreach ($roles as $role)
                <div>
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    {{ $role->name }}
                </div>
            @endforeach
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
