@extends('layouts.app')
@section('title', 'Permission List')
@section('content')
@include('include.alerts.delete-confirmation')

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

                    <div class="white_box_tittle list_header">
                        <h4>Permissions</h4>
                        <div class="box_right d-flex lms_block">

                            <div class="add_button ms-2">
                                <a href="{{ route('permissions.create') }}" class="btn_1">Add Permission</a>
                            </div>
                        </div>
                    </div>
                    <div class="QA_table mb_30">
                        @if($permissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped" id="permissionsTable">
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
                                            <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('permission', {{ $permission->id }})">Delete</button>
                                           <form method="POST" action="{{ route('permissions.destroy', $permission) }}" class="d-inline" id="deleteForm-{{                                            $permission->id }}">
                                               @csrf
                                               @method('DELETE')
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

<script>
    $(document).ready(function() {
        $('#permissionsTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            autoWidth: false,
        });
    });
</script>
<script>
   
</script>


@endsection