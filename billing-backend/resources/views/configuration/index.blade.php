@extends('layouts.app')
@section('title', 'Configurations')
@section('content')
<title>Configurations</title>

<div class="main_content_iner  mt-5">
    <div class="col-lg-12">
        <div class="white_card card_height_100 p-4">
            <div class="white_card_body">
                <div class="QA_section">
                    @if(session('success'))
                    <div class="alert text-white bg-success alert-dismissible fade show" id="success-alert" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert text-white bg-danger alert-dismissible fade show" id="error-alert" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close text-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="white_box_tittle list_header">
                        <h4>Configurations List</h4>
                        <div class="box_right d-flex lms_block">
                            <div class="add_button ms-2">
                                <a href="{{route('configuration.create')}}" class="btn_1">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="QA_table mb_30">
                        @if($configurations->count() > 0)
                        <table class="table table-striped" id="configurationsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Application Name</th>
                                    <th>Logo</th>
                                    <th>Tagline</th>
                                    <th>Theme</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($configurations as $configuration)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $configuration->app_name }}</td>
                                    <td>
                                        @if($configuration->app_logo)
                                        <img src="{{ asset('storage/' . $configuration->app_logo) }}" alt="Logo" width="50">
                                        @else
                                        <span class="text-muted">No Logo</span>
                                        @endif
                                    </td>
                                    <td>{{ $configuration->app_tagline }}</td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $configuration->app_theme }};">
                                            {{ $configuration->app_theme }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('configuration.view', $configuration->id) }}" class="btn btn-primary rounded-pill mb-3">View</a>
                                        <a href="{{ route('configuration.edit', $configuration->id) }}" class="btn btn-warning rounded-pill mb-3">Edit</a>
                                        <form action="{{ route('configuration.destroy', $configuration->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger rounded-pill mb-3" onclick="return confirm('Are you sure you want to delete this configuration?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted text-center">No configurations found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#configurationsTable').DataTable({
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