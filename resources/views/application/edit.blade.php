@extends('layouts.dashboard-layout')

@section('title', 'Edit Application')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Application</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Application Details</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Student Name</th>
                            <td>{{ $application->siswa->name }}</td>
                        </tr>
                        <tr>
                            <th>Program</th>
                            <td>{{ $application->program->title }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Resume</th>
                            <td>
                                <a href="{{ route('application.download-resume', $application) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download"></i> Download Resume
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Update Status</h5>
                    <form action="{{ route('application.update', $application) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                        <a href="{{ route('application.index') }}" class="btn btn-secondary">Back to List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
