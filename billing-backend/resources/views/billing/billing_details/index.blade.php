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
                        <div class="table-responsive">
                            <table class="table table-striped" id="billingTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>House Number</th>
                                        <th>Occupant Name</th>
                                        <th>Last Reading</th>
                                        <th>Outstanding Dues</th>
                                        <th>Current Reading</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($billingDetails as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->house->hno . " " . $detail->house->area ?? 'N/A' }}</td>
                                            <td>{{ $detail->occupant->first_name  . " " .  $detail->occupant->last_name?? 'N/A' }}</td>
                                            <td>{{ $detail->last_reading ?? 'N/A' }}</td>
                                            <td>₹{{ number_format($detail->outstanding_dues, 2) }}</td>
                                            <td>{{ $detail->current_reading }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = match($detail->status) {
                                                        'New' => 'secondary',     // Grey
                                                        'Generated' => 'primary', // Blue
                                                        'Approved' => 'success',  // Green
                                                        default => 'light'        // Fallback
                                                    };
                                                @endphp
                                            
                                                <span class="badge bg-{{ $badgeClass }}">
                                                    {{ ucfirst($detail->status) }}
                                                </span>
                                            </td>
                                            
                                            <td>
                                                {{-- <a href="{{ route('billing_details.show', $detail->id) }}" class="btn btn-primary rounded-pill mb-2">View</a> --}}
                                                <a href="{{ route('billing_details.edit', $detail->id) }}" class="btn btn-warning rounded-pill mb-2">Update</a>
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
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#billingTable').DataTable({
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
