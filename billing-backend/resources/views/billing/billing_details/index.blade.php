@extends('layouts.app')
@section('title', 'Billing Details')
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
                        <h4>Billing Details</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{ route('billing_details.create') }}" class="btn_1">Add Billing Detail</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($billingDetails->isEmpty())
                            <p class="text-muted text-center">No billing details found.</p>
                        @else
                            <table class="table table-striped" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>House Number</th>
                                        <th>Last Reading</th>
                                        <th>Outstanding Dues</th>
                                        <th>Current Reading</th>
                                        <th>Current Charges</th>
                                        <th>Pay Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($billingDetails as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->houseDetail->hno }}</td>
                                            <td>{{ $detail->last_reading }}</td>
                                            <td>{{ $detail->outstanding_dues }}</td>
                                            <td>{{ $detail->current_reading }}</td>
                                            <td>{{ $detail->current_charges }}</td>
                                            <td>{{ $detail->pay_date }}</td>
                                            <td>{{ ucfirst($detail->status) }}</td>
                                            <td>
                                                <a href="{{ route('billing_details.show', $detail->id) }}" class="btn btn-primary rounded-pill mb-2">View</a>
                                                <a href="{{ route('billing_details.edit', $detail->id) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                                <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('billing_detail', {{ $detail->id }})">Delete</button>
                                                <form method="POST" action="{{ route('billing_details.destroy', $detail->id) }}" class="d-inline" id="deleteForm-{{ $detail->id }}">
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