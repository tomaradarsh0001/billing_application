@extends('layouts.app')
@section('title', 'Billing Details')
@section('content')

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
                        <h4>Billing Details</h4>
                        <div class="box_right d-flex lms_block">
                            
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($data->isEmpty())
                            <p class="text-muted text-center">No details found.</p>
                        @else
                            <table class="table table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Occupant Name</th>
                                        <th>House Number</th>
                                        <th>Status</th>
                                        <th>Added At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->occupant->first_name . " " . $detail->occupant->last_name }}</td>
                                            <td>{{ $detail->house->hno . " " . $detail->house->area}}</td>
                                            <td>{{ $detail->status }}</td>
                                            <td>{{ $detail->added_date }}</td>
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
