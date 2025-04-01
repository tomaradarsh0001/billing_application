@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    
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
                        <h4>Add Billing Detail</h4>
                        <div class="box_right d-flex lms_block">
                            <a href="{{ route('billing_details.index') }}" class="btn_1">Back to Billing Details List</a>
                        </div>
                    </div>

                    <div class="QA_table mb_30">
                        <form action="{{ route('billing_details.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="house_id">Select House</label>
                                    <select name="house_id" id="house_id" class="form-control-select" required>
                                        <option value="">-- Select House --</option>
                                        @foreach($occupants as $occ)
                                            <option value="{{ $occ->h_id }}">{{ $occ->house->hno }} - {{ $occ->house->area }}</option>
                                        @endforeach
                                    </select>
                                    @error('house_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            
                                <div class="col-md-6 mb-3">
                                    <label for="occupant_id">Select Occupant</label>
                                    <select id="occupant_id" class="form-control-select" disabled>
                                        <option value="">-- Select Occupant --</option>
                                        @foreach($occupants as $occupant)
                                            <option value="{{ $occupant->id }}">{{ $occupant->first_name }} {{ $occupant->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <!-- Hidden field to store the actual occupant_id value -->
                                    <input type="hidden" name="occupant_id" id="hidden_occupant_id">
                                    @error('occupant_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                       
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_pay_date">Last Pay Date</label>
                                    <input type="date" name="last_pay_date" id="last_pay_date" class="form-control" value="{{ old('last_pay_date') }}" required>
                                    @error('last_pay_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                              
                                <div class="col-md-6 mb-3">
                                    <label for="outstanding_dues">Outstanding Dues</label>
                                    <input type="number" name="outstanding_dues" id="outstanding_dues" class="form-control" value="{{ old('outstanding_dues', 0) }}" readonly>
                                    @error('outstanding_dues') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="current_reading">Current Reading</label>
                                    <input type="number" name="current_reading" id="current_reading" class="form-control" value="{{ old('current_reading') }}" required>
                                    @error('current_reading') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="current_charges">Current Charges</label>
                                    <input type="number" name="current_charges" id="current_charges" class="form-control" value="{{ old('current_charges') }}" required>
                                    @error('current_charges') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_reading">Last Reading</label>
                                    <input type="number" name="last_reading" id="last_reading" class="form-control" value="{{ old('last_reading', 0) }}" readonly>
                                    @error('last_reading') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pay_date">Pay Date</label>
                                    <input type="date" name="pay_date" id="pay_date" class="form-control" value="{{ old('pay_date') }}" required>
                                    @error('pay_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control-select" required>
                                    <option value="">-- Select Payment Status --</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partially_paid" {{ old('status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                </select>
                                @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const occupants = @json($occupants);
const billingDetails = @json($billingDetails);

$(document).ready(function() {
    // Set default values and show fields when page loads
    $('#outstanding_dues').val(0).prop('hidden', false);
    $('#last_reading').val(0).prop('hidden', false);

    $('#house_id').on('change', function() {
        const selectedHouseId = $(this).val();
        const occupant = occupants.find(occ => occ.h_id == selectedHouseId);

        if (occupant) {
            // Enable occupant selection
            $('#occupant_id').val(occupant.id).prop('disabled', true).prop('hidden', false);
            $('#hidden_occupant_id').val(occupant.id); // Set hidden field value

            const billingDetail = billingDetails.find(bill => bill.house_id == selectedHouseId);
            if (billingDetail) {
                // If billing detail exists, show outstanding dues and last reading
                $('#outstanding_dues').val(billingDetail.outstanding_dues).prop('hidden', false);
                $('#last_reading').val(billingDetail.last_reading).prop('hidden', false);
            } else {
                // If no billing detail exists, hide these fields
                $('#outstanding_dues').val(0).prop('hidden', false);
                $('#last_reading').val(0).prop('hidden', false);
            }
        } else {
            // Reset the fields if no occupant is found
            $('#occupant_id').val('').prop('disabled', false).prop('hidden', false);
            $('#hidden_occupant_id').val('');
            $('#outstanding_dues').val(0).prop('hidden', false);
            $('#last_reading').val(0).prop('hidden', false);
        }
    });
});

 </script>
 
@endsection
