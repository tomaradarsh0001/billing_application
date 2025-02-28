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
                        <h4>Add Billing Detail</h4>
                        <div class="box_right d-flex lms_block">
                            <a href="{{ route('billing_details.index') }}" class="btn_1">Back to Billing Details List</a>
                        </div>
                    </div>

                    <!-- Form for Adding Billing Detail -->
                    <div class="QA_table mb_30">
                        <form action="{{ route('billing_details.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- House Selection -->
                                <div class="form-group">
                                    <label for="house_id">Select House</label>
                                    <select name="house_id" id="house_id" class="form-control" required>
                                        <option value="">-- Select House --</option>
                                        @foreach($houses as $house)
                                            <option value="{{ $house->id }}">{{ $house->hno  }}  {{ $house->area}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <!-- Occupant Selection -->
                                <div class="form-group">
                                    <label for="occupant_id">Select Occupant</label>
                                    <select name="occupant_id" id="occupant_id" class="form-control" required>
                                        <option value="">-- Select Occupant --</option>
                                        @foreach($occupants as $occupant)
                                            <option value="{{ $occupant->id }}">{{ $occupant->first_name }}{{ $occupant->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                            </div>
                            

                            <div class="row">
                                <!-- Last Pay Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="last_pay_date" class="form-label">Last Pay Date</label>
                                    <input type="date" name="last_pay_date" id="last_pay_date" class="form-control" value="{{ old('last_pay_date') }}" >
                                    @error('last_pay_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Outstanding Dues -->
                                <div class="col-md-6 mb-3">
                                    <label for="outstanding_dues" class="form-label">Outstanding Dues</label>
                                    <input type="number" name="outstanding_dues" id="outstanding_dues" class="form-control" value="{{ old('outstanding_dues') }}" >
                                    @error('outstanding_dues')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Current Reading -->
                                <div class="col-md-6 mb-3">
                                    <label for="current_reading" class="form-label">Current Reading</label>
                                    <input type="number" name="current_reading" id="current_reading" class="form-control" value="{{ old('current_reading') }}" >
                                    @error('current_reading')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Current Charges -->
                                <div class="col-md-6 mb-3">
                                    <label for="current_charges" class="form-label">Current Charges</label>
                                    <input type="number" name="current_charges" id="current_charges" class="form-control" value="{{ old('current_charges') }}" >
                                    @error('current_charges')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Pay Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="pay_date" class="form-label">Pay Date</label>
                                    <input type="date" name="pay_date" id="pay_date" class="form-control" value="{{ old('pay_date') }}" >
                                    @error('pay_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status Dropdown -->
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control-select" >
                                        <option value="" disabled selected>Select Payment Status</option>
                                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="partially_paid" {{ old('status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
