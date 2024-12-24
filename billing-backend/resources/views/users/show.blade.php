@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<title>User Details</title>
    <div class="main_content_iner">
        <div class="col-lg-6">
            <div class="card_box box_shadow position-relative ">
                <div class="white_box_tittle">
                    <div class="main-title2">
                        <h4 class="nowrap">User Details</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Roles:</strong> 
                        <span>
                            @foreach ($user->roles as $role)
                                {{ $role->name }}@if (!$loop->last), @endif
                            @endforeach
                        </span>
                    </div>
                    <div class="mb-3">
    <strong>Created At:</strong> {{ $user->created_at->diffForHumans() }}
</div>
<div class="mb-3">
    <strong>Updated At:</strong> {{ $user->updated_at->diffForHumans() }}
</div>

                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
@endsection
