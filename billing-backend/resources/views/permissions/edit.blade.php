@extends('layouts.app')

@section('content')
<div class="main_content_iner mt-5">
    <div class="col-lg-6">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">    
                <h4>Edit Permission</h4>

                <form action="{{ route('permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Permission Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
