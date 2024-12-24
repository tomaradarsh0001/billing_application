@extends('layouts.app')
@section('title', 'Create Customer')
@section('content')

<title>Customer Details</title>
<div class="main_content_iner">
    <div class="col-lg-6">
        <div class="card_box box_shadow position-relative ">
            <div class="white_box_tittle">
                <div class="main-title2">
                    <h4 class="nowrap">Customer Details</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <strong>Full Name:</strong> {{ $customer->full_name }}
                </div>
                <div class="mb-3">
                    <strong>Email Address:</strong> {{ $customer->email }}
                </div>
                <div class="mb-3">
                    <strong>Phone Number:</strong> {{ $customer->phone_number }}
                </div>
                <div class="mb-3">
                    <strong>Service Address:</strong> {{ $customer->service_address }}
                </div>
                <div class="mb-3">
                    <strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($customer->dob)->format('d M, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Aadhar Number:</strong> {{ $customer->aadhar_number }}
                </div>
                <div class="mb-3">
                    <strong>PAN Number:</strong> {{ $customer->pan_number }}
                </div>
                <div class="mb-3">
                    <strong>Gender:</strong> {{ $customer->gender }}
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $customer->created_at->diffForHumans() }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $customer->updated_at->diffForHumans() }}
                </div>

                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
