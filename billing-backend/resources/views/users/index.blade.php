@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="main_content_iner  mt-5">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- Success message -->
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
                        <h4>Users List</h4>
                        <div class="box_right d-flex lms_block">

                            <div class="add_button ms-2">
                                <a href="{{ route('users.create') }}" class="btn_1">Create User</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($users->count() > 0)
                        <table class="table table-striped" id="usersTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td> @foreach ($user->roles as $role)
                                        <span class="badge bg-primary rounded-pill me-1">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-primary rounded-pill mb-2">View</a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                        <form method="POST" action="{{ route('users.delete', $user) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill mb-2" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted text-center">No users found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            autoWidth: false,
            responsive: true, // Make it responsive
        });
    });
</script>
@endsection