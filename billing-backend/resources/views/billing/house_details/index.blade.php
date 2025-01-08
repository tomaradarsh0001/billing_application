@extends('layouts.app')

@section('title', 'House Details')

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
                        <h4>House Details</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{ route('houses.create') }}" class="btn_1">Add New House</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($houses->isEmpty())
                            <p class="text-muted text-center">No house details available.</p>
                        @else
                            <table class="table table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>House No</th>
                                        <th>Area</th>
                                        <th>Landmark</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Pincode</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($houses as $house)
                                        <tr>
                                            <td>{{ $house->id }}</td>
                                            <td>{{ $house->hno }}</td>
                                            <td>{{ $house->area }}</td>
                                            <td>{{ $house->landmark }}</td>
                                            <td>{{ $house->city }}</td>
                                            <td>{{ $house->state }}</td>
                                            <td>{{ $house->country }}</td>
                                            <td>{{ $house->pincode }}</td>
                                            <td>
                                                <a href="{{ route('houses.edit', $house->id) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                                <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('house', {{ $house->id }})">Delete</button>
                                                <form method="POST" action="{{ route('houses.destroy', $house->id) }}" class="d-inline" id="deleteForm-{{ $house->id }}">
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
