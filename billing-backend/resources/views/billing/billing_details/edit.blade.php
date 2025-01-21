@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- Success and Error Alerts -->
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

                    <!-- Title and Back Button -->
                    <div class="white_box_tittle list_header">
                        <h4>Edit Billing Detail</h4>
                        <div class="box_right d-flex lms_block">
                            <a href="{{ route('billing_details.index') }}" class="btn_1">Back to Billing Details List</a>
                        </div>
                    </div>

                    <!-- Form for Editing Billing Detail -->
                    <div class="QA_table mb_30">
                        <form action="{{ route('billing_details.update', $billingDetail->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <!-- House ID Dropdown -->
                                    <div class="mb-3">
                                        <label for="h_id" class="form-label">House ID</label>
                                        <select name="h_id" id="h_id" class="form-control-select" required>
                                            <option value="" disabled selected>Select a House</option>
                                            @foreach($houseDetails as $house)
                                                <option value="{{ $house->id }}" 
                                                    {{ old('h_id', $billingDetail->h_id) == $house->id ? 'selected' : '' }}>{{ $house->hno ?? 'No Name' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('h_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Reading -->
                                    <div class="mb-3">
                                        <label for="last_reading" class="form-label">Last Reading</label>
                                        <input type="number" name="last_reading" id="last_reading" class="form-control" value="{{ old('last_reading', $billingDetail->last_reading) }}" required>
                                        @error('last_reading')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Pay Date -->
                                    <div class="mb-3">
                                        <label for="last_pay_date" class="form-label">Last Pay Date</label>
                                        <input type="date" name="last_pay_date" id="last_pay_date" class="form-control" value="{{ old('last_pay_date', $billingDetail->last_pay_date) }}" required>
                                        @error('last_pay_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Outstanding Dues -->
                                    <div class="mb-3">
                                        <label for="outstanding_dues" class="form-label">Outstanding Dues</label>
                                        <input type="number" name="outstanding_dues" id="outstanding_dues" class="form-control" value="{{ old('outstanding_dues', $billingDetail->outstanding_dues) }}" required>
                                        @error('outstanding_dues')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <!-- Current Reading -->
                                    <div class="mb-3">
                                        <label for="current_reading" class="form-label">Current Reading</label>
                                        <input type="number" name="current_reading" id="current_reading" class="form-control" value="{{ old('current_reading', $billingDetail->current_reading) }}" required>
                                        @error('current_reading')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Current Charges -->
                                    <div class="mb-3">
                                        <label for="current_charges" class="form-label">Current Charges</label>
                                        <input type="number" name="current_charges" id="current_charges" class="form-control" value="{{ old('current_charges', $billingDetail->current_charges) }}" required>
                                        @error('current_charges')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Pay Date -->
                                    <div class="mb-3">
                                        <label for="pay_date" class="form-label">Pay Date</label>
                                        <input type="date" name="pay_date" id="pay_date" class="form-control" value="{{ old('pay_date', $billingDetail->pay_date) }}" required>
                                        @error('pay_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control-select" required>
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="paid" {{ old('status', $billingDetail->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="partially" {{ old('status', $billingDetail->status) == 'partially' ? 'selected' : '' }}>Partially Paid</option>
                                            <option value="unpaid" {{ old('status', $billingDetail->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
