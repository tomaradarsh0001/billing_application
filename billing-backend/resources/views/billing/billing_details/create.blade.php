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
                        <form id="myForm" action="{{ route('billing_details.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="house_id">Select House</label>
                                    <select name="house_id" id="house_id" class="form-control-select" required>
                                        <option value="">-- Select House --</option>
                                        @foreach($occupants as $occ)
                                            <option value="{{ $occ->h_id }}">Bungalow No: {{ $occ->house->hno }}</option>
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
                                    <input type="number" name="last_reading" id="last_reading" class="form-control"
                                           value="{{ old('last_reading', 0) }}" readonly>
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
                                    <div id="progress" class="progress" style="display:none; margin-top: 10px; height: 25px;">
                                        <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                      </div>
                                    <div class="d-flex justify-content-center mt-3">
                                          <!-- Hidden input to store the status -->
                                            <input type="hidden" name="status" id="statusInput">
                                            <button type="submit" class="btn btn-primary mx-2" id="generateBtn" onclick="setStatus('Generated')">Generate</button>
                                            {{-- <button type="submit" class="btn btn-success mx-2" id="approveBtn" onclick="setStatus('Approved')">Approve</button> --}}
                                    </div>
                                </div>
                            </form>
                          </div>
                        <form id="pdfForm" method="POST" action="{{ route('generate-billing-pdf') }}">
                            @csrf
                            <input type="hidden" name="current_reading" id="currentReadingInput">
                            <input type="hidden" name="last_reading" id="lastReadingInput">
                            <input type="hidden" name="remission" id="remissionInput">
                            <input type="hidden" name="outstanding_dues" id="outstandingDuesInput">
                            <input type="hidden" name="total_with_tax" id="totalWithTaxInput">
                            <input type="hidden" id="currentAmountHidden">
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
        // Setting the occupant id
        $('#occupant_id').val(occupant.id).prop('disabled', true).prop('hidden', false);
        $('#hidden_occupant_id').val(occupant.id);

        const billingDetail = billingDetails.find(bill => bill.house_id == selectedHouseId);
        // const filteredBillingDetails = billingDetails.filter(bill => bill.house_id == selectedHouseId);
        
        if (billingDetail) {
            const withOutRemission = billingDetail.current_reading - billingDetail.remission;
            const mainunits = withOutRemission * billingDetail.current_charges;
            let taxesInclude = 0;

            // Calculate the total taxes
            taxes.forEach(tax => {
                let taxAmount = (mainunits * parseFloat(tax.tax_percentage)) / 100;
                $(`#tax_${tax.id}`).text('₹ ' + taxAmount.toFixed(2));
                taxesInclude += taxAmount;
            });

            // Total amount including taxes
            const withtaxes = mainunits + taxesInclude;
            // console.log(withtaxes);
            let reading = billingDetail.current_reading + billingDetail.last_reading;
            console.log(reading);
            // Set the calculated values to the fields
            $('#last_reading').val(billingDetail.current_reading).prop('hidden', false);
            $('#outstanding_dues').val(withtaxes.toFixed(2)).prop('hidden', false); // Updated here
            $('#last_pay_date').val(billingDetail.last_reading).prop('hidden', false);
        } else {
            // Reset values if no billing details are found
            $('#outstanding_dues').val(0).prop('hidden', false);
            $('#last_reading').val(0).prop('hidden', false);
            $('#last_pay_date').val(0).prop('hidden', false);
        }
    } else {
        // Reset fields if no occupant is found
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
    document.getElementById('generateBtn').addEventListener('click', function (event) {
    event.preventDefault();

    const button = this;
    const form = document.getElementById('myForm');
    const progressBarWrapper = document.getElementById('progress');
    const progressBar = document.getElementById('progress-bar');

    button.innerHTML = 'Generating...';
    button.disabled = true;

    progressBarWrapper.style.display = 'block';
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', 0);
    progressBar.innerText = '';

    let width = 0;
    const interval = setInterval(function () {
        if (width >= 100) {
            clearInterval(interval);
            button.innerHTML = 'Generated';
            progressBar.style.width = '100%';
            progressBar.setAttribute('aria-valuenow', 100);
            progressBar.innerText = '';
            form.submit();
        } else {
            width++;
            progressBar.style.width = width + '%';
            progressBar.setAttribute('aria-valuenow', width);
            progressBar.innerText = '';
        }
    }, 30);
});

    document.getElementById('approveBtn').addEventListener('click', function () {
    const currentReading = parseFloat($('#current_reading').val()) || 0;
    const lastReading = parseFloat($('#last_reading').val()) || 0;
    const remission = parseFloat($('#remission').val()) || 0;
    const outstanding_dues = parseFloat($('#outstanding_dues').val()) || 0;

    const AfterRemission = currentReading - remission;
    const finalAmout = AfterRemission * amout;
    
    const button = this;
    const progressBarWrapper = document.getElementById('progress');
    const progressBar = document.getElementById('progress-bar');

    button.innerHTML = 'Processing...';
    button.disabled = true;

    progressBarWrapper.style.display = 'block';
    progressBar.style.width = '0%';
    progressBar.setAttribute('aria-valuenow', 0);
    progressBar.innerText = '';

    let width = 0;
    const interval = setInterval(function () {
        if (width >= 100) {
            clearInterval(interval);
            button.innerHTML = 'Approved';
            progressBar.style.width = '100%';
            progressBar.setAttribute('aria-valuenow', 100);
            progressBar.innerText = ''; 
        } else {
            width++;
            progressBar.style.width = width + '%';
            progressBar.setAttribute('aria-valuenow', width);
            progressBar.innerText = ''; 
        }
    }, 30);

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
    function setStatus(status) {
        document.getElementById('statusInput').value = status;
  }
  
</script>
@endsection
