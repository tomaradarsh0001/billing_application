@extends('layouts.app')

@section('content')
<style>
    .material-btn {
    background: linear-gradient(145deg, #f44336, #d32f2f); /* Red gradient */
    color: white; /* White text */
    border-radius: 12px; /* Rounded corners */
    padding: 16px 24px; /* More padding for a material feel */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Soft shadow */
    text-align: center; /* Center text */
    transition: all 0.3s ease; /* Smooth transition on hover */
}
.p-4 {
    padding: 1.1rem !important;
}
.material-btn:hover {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); /* More pronounced shadow on hover */
    transform: translateY(-4px); /* Slight upward movement on hover */
    background: linear-gradient(145deg, #d32f2f, #f44336); /* Reversed gradient on hover */
}

.material-btn:active {
    transform: translateY(2px); /* Simulates button press */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Reduces shadow when clicked */
}
.fa-2x {
    font-size: 1.5em !important;
}
</style>
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">

                    {{-- Alerts --}}
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

                    {{-- Header --}}
                    <div class="white_box_tittle list_header">
                        <h4>Edit Billing Detail</h4>
                        <div class="box_right d-flex lms_block">
                            <a href="{{ route('billing_details.index') }}" class="btn_1">Back to Billing Details List</a>
                        </div>
                    </div>

                    {{-- Form --}}
                    <div class="QA_table mb_30">
                        <form action="{{ route('billing_details.update', $billingDetail->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                {{-- Left Column --}}
                                <div class="col-md-6 mb-3">
                                    <label for="house_id">Select House</label>
                                    <select name="house_id" id="house_id" class="form-control-select" disabled>
                                        <option value="">-- Select House --</option>
                                        @foreach($occupants as $occ)
                                            <option value="{{ $occ->h_id }}" {{ $billingDetail->house_id == $occ->h_id ? 'selected' : '' }}>
                                                {{ $occ->house->hno }} - {{ $occ->house->area }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('house_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="occupant_id">Select Occupant</label>
                                    <select id="occupant_id" class="form-control-select" disabled>
                                        <option value="">-- Select Occupant --</option>
                                        @foreach($occupants as $occupant)
                                            <option value="{{ $occupant->id }}" {{ $billingDetail->occupant_id == $occupant->id ? 'selected' : '' }}>
                                                {{ $occupant->first_name }} {{ $occupant->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="occupant_id" id="hidden_occupant_id" value="{{ $billingDetail->occupant_id }}">
                                    @error('occupant_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_reading" class="form-label">Last Reading</label>
                                    <input type="number" name="last_reading" id="last_reading" class="form-control" value="{{ old('last_reading', $billingDetail->last_reading) }}">
                                    @error('last_reading') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="last_pay_date" class="form-label">Last Pay Date</label>
                                    <input type="date" name="last_pay_date" id="last_pay_date" class="form-control" value="{{ old('last_pay_date', $billingDetail->last_pay_date) }}">
                                    @error('last_pay_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="outstanding_dues" class="form-label">Outstanding Dues</label>
                                    <input type="number" name="outstanding_dues" id="outstanding_dues" class="form-control" value="{{ old('outstanding_dues', $billingDetail->outstanding_dues) }}">
                                    @error('outstanding_dues') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                {{-- Right Column --}}
                                <div class="col-md-6 mb-3">
                                    <label for="current_reading" class="form-label">Current Reading</label>
                                    <input type="number" name="current_reading" id="current_reading" class="form-control" value="{{ old('current_reading', $billingDetail->current_reading) }}" required>
                                    @error('current_reading') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="current_charges" class="form-label">Current Charges</label>
                                    <input type="number" name="current_charges" id="current_charges" class="form-control" value="{{ old('current_charges', $billingDetail->current_charges) }}" readonly>
                                    @error('current_charges') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pay_date" class="form-label">Pay Date</label>
                                    <input type="date" name="pay_date" id="pay_date" class="form-control" value="{{ old('pay_date', $billingDetail->pay_date) }}">
                                    @error('pay_date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="remission" class="form-label">Remission</label>
                                    <input type="number" name="remission" id="remission" class="form-control" value="{{ old('remission', $billingDetail->remission) }}">
                                    @error('remission') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="border p-2 rounded shadow-sm">
                                        <label for="status" class="form-label mb-1">Status</label> {{-- Reduced bottom margin --}}
                                        @php
                                            $status = old('status', $billingDetail->status);
                                            $badgeClass = match($status) {
                                                'Approved' => 'text-success',
                                                'Generated' => 'text-primary',
                                                'New' => 'text-warning',
                                                default => 'text-secondary',
                                            };
                                        @endphp
                                        <p class="fw-bold {{ $badgeClass }}" style="margin-bottom: 0;">{{ $status }}</p> {{-- Removed extra spacing --}}
                                        @error('status') 
                                            <div class="text-danger mt-1">{{ $message }}</div> 
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    @if($billingDetail->status == 'Approved') 
                                        <a href="{{ asset('storage/billing_pdfs/' . $billingDetail->pdf_path) }}" class="btn material-btn d-flex align-items-center justify-content-center p-4 w-100 rounded-lg border-0 text-white shadow-lg hover-shadow transition-all" target="_blank">
                                            <i class="fas fa-file-pdf fa-2x mr-3 text-white"></i> 
                                            <span class="fw-bold mx-3">Download PDF</span>
                                        </a>
                                    @endif
                                </div>
                                
                                
                                
                                
                            </div>

                            {{-- Bill Summary --}}
                            <div class="bill_card">
                                <div class="receipt">
                                    <header class="receipt__header">
                                        <p class="receipt__title">Bill Summary</p>
                                        <p class="receipt__date">{{ now()->format('d F Y') }}</p>
                                    </header>
                                    <dl class="receipt__list">
                                        <div class="receipt__list-row">
                                            <dt class="receipt__item">Last Units</dt>
                                            <dd class="receipt__cost"><span id="last_units">0</span></dd>
                                        </div>
                                        <div class="receipt__list-row">
                                            <dt class="receipt__item">Total Units</dt>
                                            <dd class="receipt__cost"><span id="total_units">0</span></dd>
                                        </div>
                                        <div class="receipt__list-row">
                                            <dt class="receipt__item">After Remission</dt>
                                            <dd class="receipt__cost"><span id="total_after_remission">0</span></dd>
                                        </div>
                                        <div class="receipt__list-row">
                                            <dt class="receipt__item">Current Amount</dt>
                                            <dd class="receipt__cost"><span id="currentAmount">₹ 0</span></dd>
                                        </div>
                                        <div class="receipt__list-row">
                                            <dt class="receipt__item">Outstanding Dues</dt>
                                            <dd class="receipt__cost"><span id="outstanding_dues_span">₹ 0</span></dd>
                                        </div>

                                        @foreach ($taxation as $tax)
                                            <div class="receipt__list-row">
                                                <dt class="receipt__item">{{ $tax->tax_name }} ({{ $tax->tax_percentage }}%)</dt>
                                                <dd class="receipt__cost"><span id="tax_{{ $tax->id }}">₹ 0</span></dd>
                                            </div>
                                        @endforeach

                                        <div class="receipt__list-row receipt__list-row--total">
                                            <dt class="receipt__item">Total Bill + Tax</dt>
                                            <dd class="receipt__cost"><span id="total_bill_with_tax">₹ 0</span></dd>
                                        </div>
                                    </dl>
                                    <div class="d-flex justify-content-center mt-3">
                                        <input type="hidden" name="status" id="statusInput">
                                        @if ($billingDetail->status === 'New')
                                            <button type="submit" class="btn btn-primary mx-2" id="generateBtn" onclick="setStatus('Generated')">Generate</button>
                                        @elseif ($billingDetail->status === 'Generated')
                                            <button type="submit" class="btn btn-primary mx-2" id="generateBtn" onclick="setStatus('Generated')">Generate</button>
                                            <button type="submit" class="btn btn-success mx-2" id="approveBtn" onclick="setStatus('Approved')">Approve</button>
                                        @endif
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

{{-- Scripts --}}
<script>
    const billingDetails = @json($billingDetail);
    const amout = @json($unitRate);
    const taxes = @json($taxation);
    const occupants = @json($occupants);
    $(document).ready(function () {
        function calculateSummary() {
            let current = parseFloat($('#current_reading').val()) || 0;
            let last = parseFloat($('#last_reading').val()) || 0;
            let remission = parseFloat($('#remission').val()) || 0;
            let dues = parseFloat($('#outstanding_dues').val()) || 0;

            let totalUnits = current + last;
            let afterRemission = current - remission;
            let baseAmount = afterRemission * amout;

            let taxTotal = 0;
            taxes.forEach(tax => {
                let taxAmt = (baseAmount * tax.tax_percentage) / 100;
                taxTotal += taxAmt;
                $(`#tax_${tax.id}`).text(`₹ ${taxAmt.toFixed(2)}`);
            });

            $('#last_units').text(last);
            $('#total_units').text(totalUnits);
            $('#total_after_remission').text(afterRemission);
            $('#currentAmount').text(`₹ ${baseAmount.toFixed(2)}`);
            $('#outstanding_dues_span').text(`₹ ${dues.toFixed(2)}`);
            $('#total_bill_with_tax').text(`₹ ${(baseAmount + taxTotal + dues).toFixed(2)}`);
        }

        $('#current_reading, #last_reading, #remission, #outstanding_dues').on('input', calculateSummary);
        calculateSummary();
    });
        document.getElementById('approveBtn').addEventListener('click', function () {
        const current = parseFloat($('#current_reading').val()) || 0;
        const last = parseFloat($('#last_reading').val()) || 0;
        const remission = parseFloat($('#remission').val()) || 0;
        const dues = parseFloat($('#outstanding_dues').val()) || 0;

        const afterRemission = current - remission;
        const baseAmount = afterRemission * amout;

        const data = {
            house_id: $('#house_id').val(),
            occupant_id: $('#hidden_occupant_id').val(),
            current_reading: current,
            last_reading: last,
            remission: remission,
            outstanding_dues: dues,
            currentAmount: baseAmount,
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
   
    function setStatus(status) {
        document.getElementById('statusInput').value = status;
  }
</script>
@endsection
