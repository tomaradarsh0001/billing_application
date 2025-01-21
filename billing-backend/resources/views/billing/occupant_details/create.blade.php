@extends('layouts.app')

@section('title', 'Add New Occupant')

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
                            <h4>Add New Occupant</h4>
                            <div class="box_right d-flex lms_block">
                                <a href="{{ route('occupants.index') }}" class="btn_1">Back to Occupant List</a>
                            </div>
                        </div>

                        <!-- Form for Adding New Occupant -->
                        <div class="QA_table mb_30">
                            <form method="POST" action="{{ route('occupants.store') }}">
                                @csrf

                                <!-- Hidden Unique ID Field (No Input) -->
                                <input type="hidden" name="unique_id" value="">

                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- House Selection -->
                                <div class="form-group">
                                    <label for="h_id">House No</label>
                                    <select name="h_id" id="h_id" class="form-control-select" required>
                                        <option value="">Select House</option>
                                        @foreach($houses as $house)
                                            <option value="{{ $house->id }}" {{ old('h_id') == $house->id ? 'selected' : '' }}>
                                                {{ $house->hno }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('h_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mt-3">
                                    <!-- Mobile -->
                                    <div class="col-md-6 mb-3">
                                        <label for="phone_number" class="form-label mb-0">Mobile<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select id="phone_code" name="phone_code_id" class="form-select-country" 
                                                    style="width: 30px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                <option value="" disabled selected>Select Code</option>
                                                @foreach ($phoneCodes as $code)
                                                    <option value="{{ $code->id }}" {{ old('phone_code_id') == $code->id ? 'selected' : '' }}>
                                                        {{ $code->iso }} (+{{ $code->phonecode }})
                                                    </option>
                                                @endforeach
                                            </select>
                                
                                            <input type="text" name="mobile" id="mobile" class="form-control" 
                                                   value="{{ old('mobile') }}" placeholder="Enter mobile number" required>
                                        </div>
                                
                                        @error('mobile')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                
                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label mb-0">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                

                                <!-- Occupation Date -->
                                <div class="form-group">
                                    <label for="occupation_date">Occupation Date</label>
                                    <input type="date" name="occupation_date" id="occupation_date" class="form-control" value="{{ old('occupation_date') }}" required>
                                    @error('occupation_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">Save Occupant</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
