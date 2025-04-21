@extends('layouts.app')

@section('title', 'Edit Tax Charge')

@section('content')
<div class="main_content_iner">
    <div class="col-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div class="white_box_tittle list_header mb-3">
                        <h4>Edit Tax Charge</h4>
                    </div>

                    {{-- Error Alert --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('tax-charges.update', $tax_charge) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Tax Name</label>
                            <input type="text" name="tax_name" class="form-control" value="{{ old('tax_name', $tax_charge->tax_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tax Percentage</label>
                            <input type="number" name="tax_percentage" class="form-control" step="0.01" value="{{ old('tax_percentage', $tax_charge->tax_percentage) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" name="from_date" class="form-control" value="{{ old('from_date', $tax_charge->from_date) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Till Date</label>
                            <input type="date" name="till_date" class="form-control" value="{{ old('till_date', $tax_charge->till_date) }}" >
                        </div>

                     

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('tax-charges.index') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
