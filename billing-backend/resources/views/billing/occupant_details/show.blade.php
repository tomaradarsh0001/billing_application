@extends('layouts.app')
@section('title', 'Occupant Details')
@section('content')

<title>Occupant Details</title>
<div class="main_content_iner">
    <div class="col-lg-6">
        <div class="card_box box_shadow position-relative">
            <div class="white_box_tittle">
                <div class="main-title2">
                    <h4 class="nowrap">Occupant Details</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <strong>Unique ID:</strong> {{ $occupant->unique_id }}
                </div>
                <div class="mb-3">
                    <strong>Full Name:</strong> {{ $occupant->first_name . ' ' . ($occupant->last_name ?? '') }}
                </div>
                <div class="mb-3">
                    <strong>Email Address:</strong> {{ $occupant->email }}
                </div>
                <div class="mb-3">
                    <strong>Phone Number:</strong> 
                    {{ ( '+' .$occupant->phoneCode->phonecode ?? 'N/A') . ' ' . $occupant->mobile }}
                </div>
                <div class="mb-3">
                    <strong>Occupation Date:</strong> 
                    {{ \Carbon\Carbon::parse($occupant->occupation_date)->format('d M, Y') }}
                </div>
                <div class="mb-3">
                    <strong>Bungalow No:</strong> {{ $occupant->house->hno ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Created At:</strong> {{ $occupant->created_at->diffForHumans() }}
                </div>
                <div class="mb-3">
                    <strong>Updated At:</strong> {{ $occupant->updated_at->diffForHumans() }}
                </div>

                <a href="{{ route('occupants.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
