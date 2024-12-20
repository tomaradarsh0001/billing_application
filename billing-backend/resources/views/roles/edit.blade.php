@extends('layouts.app')

@section('content')
<div class="main_content_iner mt-5">
    <div class="col-lg-6">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">    
                <h4>Edit Role</h4>

                <!-- Form to edit the role -->
                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
