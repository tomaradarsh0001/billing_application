@extends('layouts.app')

@section('title', 'Create Customer')

@section('content')
<style>
   
</style>
<div class="main_content_iner">
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

                        <!-- Customer Info -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}">
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}">
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Gender Dropdown -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-control-select">
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob') }}">
                                @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <!-- Phone Number -->
                            <div class="col-md-6 mb-3">
                            <label for="phone_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <!-- Country Code Dropdown -->
                                <select id="phone_code" name="phone_code_id" class="form-select-country" 
                                        style="width: 90px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                    <option value="" disabled selected>Select Code</option>
                                    @foreach ($phoneCodes as $code)
                                        <option value="{{ $code->id }}" {{ old('phone_code_id') == $code->id ? 'selected' : '' }}>
                                            {{ $code->iso }} (+{{ $code->phonecode }})
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Phone Number Input -->
                                <input type="text" id="phone_number" name="phone_number" class="form-control" 
                                    value="{{ old('phone_number') }}" maxlength="10" placeholder="Mobile"
                                    style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                            </div>
                            @error('phone_code_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @error('phone_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                            <!-- Email Address -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <!-- Aadhar Number -->
                            <div class="col-md-6 mb-3">
                                <label for="aadhar_number" class="form-label">Aadhar Number</label>
                                <input type="text" id="aadhar_number" name="aadhar_number" class="form-control" value="{{ old('aadhar_number') }}" maxlength="12">
                                @error('aadhar_number')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PAN Number -->
                            <div class="col-md-6 mb-3">
                                <label for="pan_number" class="form-label">PAN Number</label>
                                <input type="text" id="pan_number" name="pan_number" class="form-control" value="{{ old('pan_number') }}" maxlength="10">
                                @error('pan_number')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="service_address" class="form-label">Full Address</label>
                            <textarea id="service_address" name="service_address" class="form-control">{{ old('service_address') }}</textarea>
                            @error('service_address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Country, State, City Dropdowns -->
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <select id="country" name="country_id" class="form-control-select">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="state" class="form-label">State</label>
                                <select id="state" name="state_id" class="form-control-select">
                                    <option value="">Select State</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="city" class="form-label">City</label>
                                <select id="city" name="city_id" class="form-control-select">
                                    <option value="">Select City</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="text" id="pincode" name="pincode" class="form-control" value="{{ old('pincode') }}">
                            @error('pincode')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>


                        <!-- Pincode -->
                    
                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Create Customer</button>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        // Fetch states based on selected country
        $('#country').change(function() {
            let countryId = $(this).val();
            $('#state').html('<option value="">Select State</option>'); // Reset states
            $('#city').html('<option value="">Select City</option>'); // Reset cities

            if (countryId) {
                $.ajax({
                    url: "{{ route('get.states') }}",
                    type: "GET",
                    data: {
                        country_id: countryId
                    },
                    success: function(data) {
                        data.forEach(state => {
                            $('#state').append(`<option value="${state.id}">${state.name}</option>`);
                        });
                    }
                });
            }
        });

        // Fetch cities based on selected state
        $('#state').change(function() {
            let stateId = $(this).val();
            $('#city').html('<option value="">Select City</option>'); // Reset cities

            if (stateId) {
                $.ajax({
                    url: "{{ route('get.cities') }}",
                    type: "GET",
                    data: {
                        state_id: stateId
                    },
                    success: function(data) {
                        data.forEach(city => {
                            $('#city').append(`<option value="${city.id}">${city.name}</option>`);
                        });
                    }
                });
            }
        });
    });
</script>

@endsection