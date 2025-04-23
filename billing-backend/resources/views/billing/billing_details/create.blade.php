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
                                    <input type="hidden" name="occupant_id" id="hidden_occupant_id">
                                    @error('occupant_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                       
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="last_pay_date">Last Pay Date</label>
                                    <input type="date" name="last_pay_date" id="last_pay_date" class="form-control" value="{{ old('last_pay_date') }}" readonly>
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
                                    <input type="number" 
                                           name="current_charges" 
                                           id="current_charges" 
                                           class="form-control" 
                                           value="{{ old('current_charges', $unitRate) }}" 
                                           readonly 
                                           required>
                                    @error('current_charges') 
                                        <div class="text-danger">{{ $message }}</div> 
                                    @enderror
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
                                    <input type="date" name="pay_date" id="pay_date" class="form-control" value="{{ old('pay_date') }}" readonly>
                                    @error('pay_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="remission">Remission</label>
                                    <input type="number" name="remission" id="remission" class="form-control" value="{{ old('remission') }}">
                                    @error('remission') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                            <div class="bill_card">
                                <div class="receipt">
                                    <header class="receipt__header">
                                      <p class="receipt__title">
                                        Bill Summary
                                      </p>
                                      <p class="receipt__date">{{ now()->format('d F Y') }}</p>
                                    </header>
                                    <dl class="receipt__list">
                                      <div class="receipt__list-row">
                                        <dt class="receipt__item">Last Units (Units)</dt>
                                        <dd class="receipt__cost"><span id="last_units">0</span></dd>
                                      </div>
                                      <div class="receipt__list-row">
                                        <dt class="receipt__item">Total Units (Units)</dt>
                                        <dd class="receipt__cost"><span id="total_units">0</span></dd>
                                      </div>
                                      <div class="receipt__list-row">
                                        <dt class="receipt__item">Total After Remission (Units)</dt>
                                        <dd class="receipt__cost"><span id="total_after_remission">0</span></dd>
                                      </div>
                                      <div class="receipt__list-row">
                                        <dt class="receipt__item">Current Amount (INR)</dt>
                                        <dd class="receipt__cost"><span id="currentAmout">₹ 0</span></dd>
                                      </div>
                                      <div class="receipt__list-row">
                                        <dt class="receipt__item">Outstanding Dues (INR)</dt>
                                        <dd class="receipt__cost"><span id="outstanding_duess">₹ 0</span></dd>
                                      </div>
                                  
                                      @foreach ($taxation as $tax)
                                        <div class="receipt__list-row">
                                          <dt class="receipt__item">{{ $tax->tax_name }} ({{ $tax->tax_percentage }}%)</dt>
                                          <dd class="receipt__cost"><span id="tax_{{ $tax->id }}">₹ 0</span></dd>
                                        </div>
                                      @endforeach
                                  
                                      <div class="receipt__list-row receipt__list-row--total">
                                        <dt class="receipt__item">Total Bill + Tax (INR)</dt>
                                        <dd class="receipt__cost"><span id="total_bill_with_tax">₹ 0</span></dd>
                                      </div>
                                    </dl>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary mx-2">Generate</button>
                                        <button type="button" class="btn btn-success mx-2" id="approveBtn">Approve</button>
                                    </div>
                                  </div>
                            </div>
                        </form>
                        <form id="pdfForm" method="POST" action="{{ route('generate-billing-pdf') }}">
                            @csrf
                            <input type="hidden" name="current_reading" id="currentReadingInput">
                            <input type="hidden" name="last_reading" id="lastReadingInput">
                            <input type="hidden" name="remission" id="remissionInput">
                            <input type="hidden" name="outstanding_dues" id="outstandingDuesInput">
                            <input type="hidden" name="total_with_tax" id="totalWithTaxInput">
                            <input type="hidden" id="currentAmountHidden">
                            <!-- Add other hidden inputs as needed -->
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
    const amout = @json($unitRate);
    const taxes = @json($taxation);

    $(document).ready(function () {
        $('#outstanding_dues').val(0).prop('hidden', false);
        $('#last_reading').val(0).prop('hidden', false);
        $('#last_pay_date').val(0).prop('hidden', false);

        $('#house_id').on('change', function () {
            const selectedHouseId = $(this).val();
            const occupant = occupants.find(occ => occ.h_id == selectedHouseId);
            if (occupant) {
                $('#occupant_id').val(occupant.id).prop('disabled', true).prop('hidden', false);
                $('#hidden_occupant_id').val(occupant.id); 

                const billingDetail = billingDetails.find(bill => bill.house_id == selectedHouseId);
                if (billingDetail) {
                    $('#outstanding_dues').val(billingDetail.outstanding_dues).prop('hidden', false);
                    $('#last_reading').val(billingDetail.last_reading).prop('hidden', false);
                    $('#last_pay_date').val(billingDetail.last_reading).prop('hidden', false);
                } else {
                    $('#outstanding_dues').val(0).prop('hidden', false);
                    $('#last_reading').val(0).prop('hidden', false);
                    $('#last_pay_date').val(0).prop('hidden', false);
                }
            } else {
                $('#occupant_id').val('').prop('disabled', false).prop('hidden', false);
                $('#hidden_occupant_id').val('');
                $('#outstanding_dues').val(0).prop('hidden', false);
                $('#last_reading').val(0).prop('hidden', false);
                $('#last_pay_date').val(0).prop('hidden', false);
            }
        });

        $('#current_reading, #last_reading, #remission').on('input', function () {
            let currentReading = parseFloat($('#current_reading').val()) || 0;
            let lastReading = parseFloat($('#last_reading').val()) || 0;
            let remission = parseFloat($('#remission').val()) || 0;
            let outstanding_duess = parseFloat($('#outstanding_dues').val()) || 0;

            let totalUnits = currentReading + lastReading;
            let totalAfterRemission = totalUnits - remission;
            let AfterRemission = currentReading - remission;
            let finalAmout = AfterRemission * amout;
            let totalBill = finalAmout + outstanding_duess;
            
            let totalTax = 0;

            taxes.forEach(tax => {
                let taxAmount = (finalAmout * parseFloat(tax.tax_percentage)) / 100;
                $(`#tax_${tax.id}`).text('₹ ' + taxAmount.toFixed(2));
                totalTax += taxAmount;
            });

            let totalWithTax = totalBill + totalTax;

            $('#total_units').text(totalUnits.toFixed(2));
            $('#last_units').text(lastReading.toFixed(2));
            $('#total_after_remission').text(totalAfterRemission.toFixed(2));
            $('#outstanding_duess').text('₹ ' + outstanding_duess.toFixed(2));
            $('#currentAmout').text('₹ ' + finalAmout.toFixed(2));
            $('#total_bill_with_tax').text('₹ ' + totalWithTax.toFixed(2));
        });
    });
    document.getElementById('approveBtn').addEventListener('click', function () {
    const currentReading = parseFloat($('#current_reading').val()) || 0;
    const lastReading = parseFloat($('#last_reading').val()) || 0;
    const remission = parseFloat($('#remission').val()) || 0;
    const outstanding_dues = parseFloat($('#outstanding_dues').val()) || 0;

    const AfterRemission = currentReading - remission;
    const finalAmout = AfterRemission * amout;

    const data = {
        house_id: $('#house_id').val(),
        
        occupant_id: $('#hidden_occupant_id').val(),
        current_reading: currentReading,
        last_reading: lastReading,
        remission: remission,
        outstanding_dues: outstanding_dues,
        currentAmount: finalAmout,
        unit_rate: amout,
        taxes: taxes,
        billingDetails: billingDetails,
        occupants: occupants
    };
    console.log(data);
    
    fetch("{{ route('generate-billing-pdf') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        window.open(url, '_blank');
    })
    .catch(error => console.error('Error generating PDF:', error));
});


</script>
@endsection
