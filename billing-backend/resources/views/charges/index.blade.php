@extends('layouts.app')

@section('title', 'Tax Charges')

@section('content')
@include('include.alerts.delete-confirmation')

<div class="main_content_iner">
    <div class="col-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">

                    {{-- Header --}}
                    <div class="white_box_tittle list_header">
                        <h4>Tax Charges</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{ route('tax-charges.create') }}" class="btn_1">+ Add New Tax Charge</a>
                            </div>
                        </div>
                    </div>

                    {{-- Success Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="QA_table mb_30 mt-3">
                        <table class="table  table-striped" id="usersTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Percentage</th>
                                    <th>From</th>
                                    <th>Till</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($taxes as $tax)
                                    <tr>
                                        <td>{{ $tax->tax_name }}</td>
                                        <td>{{ $tax->tax_percentage }}%</td>
                                        <td>{{ $tax->from_date }}</td>
                                        <td>{{ $tax->till_date }}</td>
                                 
                                        <td>
                                        <form method="POST" action="{{ route('tax-charges.toggleStatus', $tax->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch d-flex align-items-center gap-1">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    id="status-switch-{{ $tax->id }}" 
                                                    onchange="this.form.submit()"
                                                    {{ $tax->status ? 'checked' : '' }}>
                                            </div>
                                        </form>
                                    </td>
                                        <td>
                                            <a href="{{ route('tax-charges.edit', $tax) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                    
                                         
                                            <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('taxation', {{ $tax->id }})">Delete</button>
                                            <form method="POST" action="{{ route('tax-charges.destroy', $tax->id) }}" class="d-inline" id="deleteForm-{{ $tax->id }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                       
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No Tax Charges Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
