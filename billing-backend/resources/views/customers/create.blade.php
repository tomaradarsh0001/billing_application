@extends('layouts.app')
@section('title', 'Create Customer')
@section('content')

<div class="main_content_iner mt-5">
    <div class="col-lg-12">
        <div class="white_card card_height_100 mb_30">
            <div class="white_card_header">
                <div class="box_header m-0">
                    <div class="main-title">
                        <h4 class="m-0">Create Customer</h4>
                    </div>
                </div>
            </div>
            <div class="white_card_body">
                <div class="card-body">
                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name') }}" >
                            @error('full_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" >
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number') }}" maxlength="10">
                            <div id="phone_number-error" class="text-danger" style="display:none;">Phone number must be exactly 10 digits.</div>
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="service_address" class="form-label">Service Address</label>
                            <textarea id="service_address" name="service_address" class="form-control">{{ old('service_address') }}</textarea>
                            @error('service_address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob') }}">
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="aadhar_number" class="form-label">Aadhar Number</label>
                            <input type="text" id="aadhar_number" name="aadhar_number" class="form-control" value="{{ old('aadhar_number') }}" maxlength="12">
                            <div id="aadhar_number-error" class="text-danger" style="display:none;">Aadhar number must be exactly 12 digits.</div>
                            @error('aadhar_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pan_number" class="form-label">PAN Number</label>
                            <input type="text" id="pan_number" name="pan_number" class="form-control" value="{{ old('pan_number') }}" maxlength="10">
                            <div id="pan_number-error" class="text-danger" style="display:none;">PAN number must be 10 characters (5 letters, 4 digits, 1 letter).</div>
                            @error('pan_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select id="gender" name="gender" class="form-control-select">
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" id="submit-button" class="btn btn-success">Create Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
