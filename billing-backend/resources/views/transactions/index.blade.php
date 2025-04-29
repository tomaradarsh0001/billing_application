@extends('layouts.app')
@section('title', 'Transactions List')
@section('content')
@include('include.alerts.delete-confirmation')

<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <!-- Success and Error messages -->
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

                    
                    <div class="QA_table mb_30">
                        @if($transactions->count() > 0)
                        <table class="table table-striped" id="transactionsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Occupant</th>
                                    <th>Status</th>
                                    <th>Total Amount</th>
                                    <th>Payment ID</th>
                                    <th>Gateway</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>
                                        {{-- Accessing the occupant full name from the $occ_name variable --}}
                                        {{ $occ_name->firstWhere('transaction_id', $transaction->id)['occupant_full_name'] }}
                                    </td>
                                    <td>{{ $transaction->status }}</td>
                                    <td>${{ $transaction->amount }}</td>
                                    <td>{{ $transaction->gateway_transaction_id }}</td>
                                    <td>{{ $transaction->gateway_name }}</td>
                                    <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="" class="btn btn-info rounded-pill mb-2">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                        @else
                        <p class="text-muted text-center">No transactions found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#transactionsTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            autoWidth: false,
            responsive: true,
        });
    });
</script>

@endsection
