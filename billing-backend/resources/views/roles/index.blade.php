@extends('layouts.app')
@section('title', 'Roles List')
@section('content')

<div class="main_content_iner mt-5">
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
                        <h4>Roles List</h4>
                        <div class="box_right d-flex lms_block">
                            <!-- Search Form -->
                            <div class="serach_field_2">
                                <div class="search_inner">
                                    <form action="#" method="GET">
                                        <div class="search_field">
                                            <input type="text" name="search" placeholder="Search roles...">
                                        </div>
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <!-- Create Role Button -->
                            <div class="add_button ms-2">
                                <a href="{{ route('roles.create') }}" class="btn_1">Create New Role</a>
                            </div>
                        </div>
                    </div>

                    <!-- Table for Displaying Roles -->
                    <div class="QA_table mb_30">
                        @if($roles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th style="width: 50%;">Permissions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @php
                                                        $permissions = $role->permissions->take(3); 
                                                        $extraCount = $role->permissions->count() - 3; 
                                                        $extraPermissions = $role->permissions->skip(3)->pluck('name')->toArray(); // Get remaining permissions names
                                                    @endphp

                                                    @foreach ($permissions as $permission)
                                                        <span class="badge rounded-pill bg-primary mb-1">{{ $permission->name }}</span>
                                                    @endforeach

                                                    @if ($extraCount > 0)
                                                        <span 
                                                            class="badge rounded-pill bg-secondary mb-1" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Remaining permissions: {{ implode(', ', $extraPermissions) }}">
                                                            +{{ $extraCount }}
                                                        </span> 
                                                    @endif
                                                </td>
                                                <td class="gap-2">
                                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                                    <form action="{{ route('roles.delete', $role->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill mb-2" onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                                    </form>
                                                    <a href="{{ route('roles.permissions', $role->id) }}" class="btn btn-success rounded-pill mb-2">Add Permission</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No roles found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush

@endsection
