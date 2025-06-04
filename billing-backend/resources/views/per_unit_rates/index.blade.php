@extends('layouts.app')
@section('title', 'Per unit Charge')
@section('content')
@include('include.alerts.delete-confirmation')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- Success and Error messages -->
                    @if(session('success'))
                    <div class="alert text-white bg-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert text-white bg-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Per Unit Rates</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{ route('per_unit_rates.create') }}" class="btn_1">Add New Rate</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($rates->count() > 0)
                        <table class="table table-striped" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Unit Rate (Rs)</th>
                                    <th>From Date</th>
                                    <th>Till Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rates as $rate)
                                <tr>
                                    <td>{{ $rate->unit_rate }}</td>
                                    <td>{{ $rate->from_date }}</td>
                                    <td>{{ $rate->till_date ?? 'On-going' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('per_unit_rates.toggleStatus', $rate->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch d-flex align-items-center gap-1">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    id="status-switch-{{ $rate->id }}" 
                                                    onchange="this.form.submit()"
                                                    {{ $rate->status ? 'checked' : '' }}>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('per_unit_rates.edit', $rate->id) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                    
                                        @if(!$rate->status)
                                            <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('per_unit_rate', {{ $rate->id }})">Delete</button>
                                            <form method="POST" action="{{ route('per_unit_rates.destroy', $rate->id) }}" class="d-inline" id="deleteForm-{{ $rate->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-secondary rounded-pill mb-2" disabled title="Cannot delete active rate">
                                                Delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted text-center">No rates found.</p>
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
