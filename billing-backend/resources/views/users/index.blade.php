@extends('layouts.app')

@section('content')
    <h1>Users</h1>
    <a href="#">Create User</a>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}">Edit</a>
                        <form method="POST" action="{{ route('users.delete', $user) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
