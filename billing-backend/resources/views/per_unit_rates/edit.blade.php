@extends('layouts.app')

@section('content')
<div class="main_content_iner">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <h4>Edit Per Unit Rate</h4>

                {{-- Show validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Show success message --}}
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('per_unit_rates.update', $rate->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="unit_rate" class="form-label">Unit Rate (Rs)</label>
                        <input 
                            type="number" 
                            name="unit_rate" 
                            id="unit_rate" 
                            step="0.01" 
                            class="form-control" 
                            value="{{ old('unit_rate', $rate->unit_rate) }}" 
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="from_date" class="form-label">From Date</label>
                        <input 
                            type="date" 
                            name="from_date" 
                            id="from_date" 
                            class="form-control" 
                            value="{{ old('from_date', $rate->from_date) }}" 
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="till_date" class="form-label">Till Date (optional)</label>
                        <input 
                            type="date" 
                            name="till_date" 
                            id="till_date" 
                            class="form-control" 
                            value="{{ old('till_date', $rate->till_date) }}">
                    </div>

                

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                    <a href="{{ route('per_unit_rates.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
