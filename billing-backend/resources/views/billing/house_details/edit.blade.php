@extends('layouts.app')

@section('title', 'Edit House Details')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Edit House Details</h4>
                        <div class="box_right d-flex lms_block">
                            <a href="{{ route('houses.index') }}" class="btn_1">Back to List</a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('houses.update', $house->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="hno">House Number <span class="text-danger">*</span></label>
                                <input type="text" name="hno" id="hno" class="form-control" value="{{ old('hno', $house->hno) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="house_type">House Type</label>
                                <input type="text" name="house_type" id="house_type" class="form-control" value="{{ old('house_type', $house->house_type) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="meter_number">Meter Number</label>
                                <input type="text" name="meter_number" id="meter_number" class="form-control" value="{{ old('meter_number', $house->meter_number) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ews_qtr">EWS QTR</label>
                                <input type="text" name="ews_qtr" id="ews_qtr" class="form-control" value="{{ old('ews_qtr', $house->ews_qtr) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="area">Area</label>
                                <input type="text" name="area" id="area" class="form-control" value="{{ old('area', $house->area) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="city">City</label>
                                <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $house->city) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="state">State</label>
                                <input type="text" name="state" id="state" class="form-control" value="{{ old('state', $house->state) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country">Country</label>
                                <input type="text" name="country" id="country" class="form-control" value="{{ old('country', $house->country) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pincode">Pincode</label>
                            <input type="text" name="pincode" id="pincode" class="form-control" value="{{ old('pincode', $house->pincode) }}">
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Update House</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
