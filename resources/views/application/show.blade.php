@extends('layouts.dashboard-layout')

@section('title', 'Application Details')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Application Details</h6>
            <div>
                <a href="{{ route('application.edit', $application) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('application.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <h5>Student Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $application->siswa->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $application->siswa->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ ucfirst($application->siswa->role) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Program Information</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Program Title</th>
                            <td>{{ $application->program->title }}</td>
                        </tr>
                        <tr>
                            <th>Mentor</th>
                            <td>{{ $application->program->mentor->name }}</td>
                        </tr>
                        <tr>
                            <th>Location</th>
                            <td>{{ $application->program->location }}</td>
                        </tr>
                        <tr>
                            <th>Duration</th>
                            <td>{{ $application->program->start_date->format('M d, Y') }} - {{ $application->program->end_date->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Application Details</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Applied At</th>
                            <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $application->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Resume</th>
                            <td>
                                <a href="{{ route('application.download-resume', $application) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-download"></i> Download Resume
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Program Description</h5>
                    <div class="card">
                        <div class="card-body">
                            {!! nl2br(e($application->program->description)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5>Requirements</h5>
                    <div class="card">
                        <div class="card-body">
                            {!! nl2br(e($application->program->requirements)) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Benefits</h5>
                    <div class="card">
                        <div class="card-body">
                            {!! nl2br(e($application->program->benefits)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 