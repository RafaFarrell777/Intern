@extends('layouts.dashboard-layout')

@section('title', 'My Applications')

@section('content')
<div class="container-fluid">
    <!-- My Applications Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">My Applications</h6>
            <a href="{{ route('dashboard') }}" class="btn btn-danger">Back</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Form -->
            <form action="{{ route('application.student-index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by program name..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('application.student-index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $application)
                            <tr>
                                <td>{{ $application->program->title }}</td>
                                <td>
                                    <span class="badge badge-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('program.show', $application->program->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $applications->links() }}
            </div>
        </div>
    </div>

    <!-- Available Programs Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Available Programs</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($programs as $program)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $program->title }}</h5>
                                <p class="card-text">{{ Str::limit($program->description, 150) }}</p>
                                <ul class="list-unstyled">
                                    <li><strong>Location:</strong> {{ $program->location }}</li>
                                    <li><strong>Duration:</strong> {{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}</li>
                                    <li><strong>Max Participants:</strong> {{ $program->max_participants }}</li>
                                </ul>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('program.show', $program->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                @if(!$applications->contains('program_id', $program->id))
                                    <!-- <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#applyModal" data-program-id="{{ $program->id }}">
                                        Apply Now
                                    </button> -->
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No available programs at the moment.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 