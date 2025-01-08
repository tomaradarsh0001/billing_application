@extends('layouts.app')

@section('title', 'Occupant Details')

@section('content')
@include('include.alerts.delete-confirmation')

<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    @if(session('success'))
                        <div class="alert text-white bg-success alert-dismissible fade show" id="success-alert" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert text-white bg-danger alert-dismissible fade show" id="error-alert" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Occupant Details</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{ route('occupants.create') }}" class="btn_1">Add New Occupant</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($occupants->isEmpty())
                            <p class="text-muted text-center">No occupant details available.</p>
                        @else
                            <table class="table table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Unique ID</th>
                                        <th>House No</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Occupation Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($occupants as $occupant)
                                        <tr>
                                            <td>{{ $occupant->id }}</td>
                                            <td>{{ $occupant->unique_id }}</td>
                                            <td>{{ $occupant->house->hno }}</td>
                                            <td>{{ $occupant->first_name }}</td>
                                            <td>{{ $occupant->last_name }}</td>
                                            <td>{{ $occupant->mobile }}</td>
                                            <td>{{ $occupant->email }}</td>
                                            <td>{{ $occupant->occupation_date }}</td>
                                            <td>
                                            <a href="{{ route('occupants.show', $occupant->id) }}" class="btn btn-primary rounded-pill mb-2">View</a>
                                                <a href="{{ route('occupants.edit', $occupant->id) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                                <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('occupant', {{ $occupant->id }})">Delete</button>
                                                <form method="POST" action="{{ route('occupants.destroy', $occupant->id) }}" class="d-inline" id="deleteForm-{{ $occupant->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            responsive: true, 
        });
    });
</script>
@endsection
