@extends('layouts.app')
@section('title', 'Permission List')
@section('content')

<div class="main_content_iner mt-5">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert text-white bg-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Permissions</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="serach_field_2">
                                <div class="search_inner">
                                    <form action="#" method="GET">
                                        <div class="search_field">
                                            <input type="text" name="search" placeholder="Search permissions...">
                                        </div>
                                        <button type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div class="add_button ms-2">
                                <a href="{{ route('permissions.create') }}" class="btn_1">Add Permission</a>
                            </div>
                        </div>
                    </div>
                    <div class="QA_table mb_30">
                        @if($permissions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions as $permission)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $permission->name }}</td>
                                                <td>
                                                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill mb-2" onclick="return confirm('Are you sure you want to delete this permission?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center">No permissions found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
