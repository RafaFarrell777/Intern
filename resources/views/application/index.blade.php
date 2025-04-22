@extends('layouts.dashboard-layout')

@section('title', 'Internship Applications')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Internship Applications</h6>
            <a href="{{ route('application.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Application
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Resume</th>
                            <th>Applied At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>{{ $application->siswa->name }}</td>
                                <td>{{ $application->program->title }}</td>
                                <td>
                                    <span class="badge badge-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('application.download-resume', $application) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </td>
                                <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('application.show', $application) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('application.edit', $application) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('application.destroy', $application) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this application?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $applications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false
        });
    });
</script>
@endpush 