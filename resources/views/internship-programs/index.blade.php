@extends('layouts.dashboard-layout')

@section('title', 'Internship Programs')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Internship Programs</h1>
        <a href="{{ route('internship-programs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Program
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Mentor</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                            <tr>
                                <td>{{ $program->title }}</td>
                                <td>{{ $program->mentor->name }}</td>
                                <td>{{ $program->start_date->format('d M Y') }}</td>
                                <td>{{ $program->end_date->format('d M Y') }}</td>
                                <td>{{ $program->location }}</td>
                                <td>
                                    <span class="badge badge-{{ $program->status === 'active' ? 'success' : ($program->status === 'completed' ? 'secondary' : 'warning') }}">
                                        {{ ucfirst($program->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('internship-programs.edit', $program) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('internship-programs.destroy', $program) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush 