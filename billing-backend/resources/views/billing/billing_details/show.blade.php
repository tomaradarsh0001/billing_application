@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-6">
        <div class="card_box box_shadow position-relative">
            <div class="white_box_tittle">
                <div class="main-title2">
                    <h4 class="nowrap">Billing Detail</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered">
                    <tr>
                        <th>House Number</th>
                        <td>{{ $billingDetail->houseDetail->hno }}</td>
                    </tr>
                    <tr>
                        <th>Last Reading</th>
                        <td>{{ $billingDetail->last_reading }}</td>
                    </tr>
                    <tr>
                        <th>Outstanding Dues</th>
                        <td>{{ $billingDetail->outstanding_dues }}</td>
                    </tr>
                    <tr>
                        <th>Current Reading</th>
                        <td>{{ $billingDetail->current_reading }}</td>
                    </tr>
                    <tr>
                        <th>Current Charges</th>
                        <td>{{ $billingDetail->current_charges }}</td>
                    </tr>
                    <tr>
                        <th>Pay Date</th>
                        <td>{{ $billingDetail->pay_date }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ ucfirst($billingDetail->status) }}</td>
                    </tr>
                </table>
                <a href="{{ route('billing_details.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
