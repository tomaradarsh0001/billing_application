@extends('layouts.app')
@section('title', 'Customers')
@section('content')
@include('include.alerts.delete-confirmation')

<div class="main_content_iner mt-5">
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
                        <h4>Customers List</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{ route('customers.create') }}" class="btn_1">Create New Customer</a>
                            </div>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        @if($customers->count() > 0)
                        <table class="table table-striped" id="usersTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email Address</th>
                                    <th>Phone Number</th>
                                    <th>Gender</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->full_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone_number }}</td>
                                    <td>{{ $customer->gender }}</td>
                                    <td>
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-primary rounded-pill mb-2">View</a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning rounded-pill mb-2">Edit</a>
                                        <!-- <form action="{{ route('customers.destroy', $customer) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill mb-2">Delete</button>
                                        </form> -->
                                        <button type="button" class="btn btn-danger rounded-pill mb-2" onclick="confirmDelete('customer', {{ $customer->id }})">Delete</button>
                                        <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="d-inline" id="deleteForm-{{ $customer->id }}">
                                         @csrf
                                         @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted text-center">No customers found.</p>
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
