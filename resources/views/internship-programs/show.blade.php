@extends('layouts.dashboard-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Internship Program Details</h3>
                    <div>
                        <a href="{{ route('internship-programs.edit', $internshipProgram) }}" class="btn btn-primary">Edit Program</a>
                        <a href="{{ route('internship-programs.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Title</th>
                                    <td>{{ $internshipProgram->title }}</td>
                                </tr>
                                <tr>
                                    <th>Mentor</th>
                                    <td>{{ $internshipProgram->mentor->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $internshipProgram->status === 'active' ? 'success' : ($internshipProgram->status === 'completed' ? 'secondary' : 'warning') }}">
                                            {{ ucfirst($internshipProgram->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td>{{ $internshipProgram->location }}</td>
                                </tr>
                                <tr>
                                    <th>Maximum Participants</th>
                                    <td>{{ $internshipProgram->max_participants }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>Program Schedule</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Start Date</th>
                                    <td>{{ $internshipProgram->start_date->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $internshipProgram->end_date->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ $internshipProgram->start_date->diffInDays($internshipProgram->end_date) }} days</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Description</h4>
                            <div class="card">
                                <div class="card-body">
                                    {!! nl2br(e($internshipProgram->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4>Requirements</h4>
                            <div class="card">
                                <div class="card-body">
                                    {!! nl2br(e($internshipProgram->requirements)) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4>Benefits</h4>
                            <div class="card">
                                <div class="card-body">
                                    {!! nl2br(e($internshipProgram->benefits)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>Applications</h4>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Applied At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($internshipProgram->applications as $application)
                                            <tr>
                                                <td>{{ $application->user->name }}</td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $application->status === 'approved' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No applications yet</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 