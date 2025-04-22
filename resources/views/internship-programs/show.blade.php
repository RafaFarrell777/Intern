@extends('layouts.landing-layout')

@section('title', $internshipProgram->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $internshipProgram->title }}</h4>
                    @if(auth()->user()->role === 'magang' && $internshipProgram->status === 'active' && !$internshipProgram->hasApplied(auth()->id()))
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#applyModal">Apply Now</button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Description:</strong></p>
                            <p>{{ $internshipProgram->description }}</p>
                            
                            <p><strong>Mentor:</strong></p>
                            <p>{{ $internshipProgram->mentor->name }}</p>
                            
                            <p><strong>Location:</strong></p>
                            <p>{{ $internshipProgram->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Start Date:</strong></p>
                            <p>{{ $internshipProgram->start_date->format('M d, Y') }}</p>
                            
                            <p><strong>End Date:</strong></p>
                            <p>{{ $internshipProgram->end_date->format('M d, Y') }}</p>
                            
                            <p><strong>Max Participants:</strong></p>
                            <p>{{ $internshipProgram->max_participants }}</p>
                            
                            <p><strong>Status:</strong></p>
                            <p>
                                <span class="badge badge-{{ $internshipProgram->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($internshipProgram->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Requirements</h5>
                            <p>{{ $internshipProgram->requirements }}</p>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Benefits</h5>
                            <p>{{ $internshipProgram->benefits }}</p>
                        </div>
                    </div>
                    
                    @if(auth()->user()->role === 'mentor')
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5>Applications</h5>
                                @if($internshipProgram->applications->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Status</th>
                                                    <th>Applied At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($internshipProgram->applications as $application)
                                                    <tr>
                                                        <td>{{ $application->siswa->name }}</td>
                                                        <td>
                                                            <span class="badge badge-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                                                {{ ucfirst($application->status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                                        <td>
                                                            <a href="{{ route('application.show', $application) }}" class="btn btn-sm btn-info">View</a>
                                                            <a href="{{ route('application.edit', $application) }}" class="btn btn-sm btn-primary">Update Status</a>
                                                            <a href="{{ route('application.download-resume', $application) }}" class="btn btn-sm btn-secondary">Download Resume</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No applications yet.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role === 'magang' && $internshipProgram->status === 'active' && !$internshipProgram->hasApplied(auth()->id()))
    <!-- Application Modal -->
    <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Apply for Internship</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('internship-programs.apply') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="program_id" value="{{ $internshipProgram->id }}">
                        <div class="form-group">
                            <label for="resume">Upload Resume (PDF only, max 2MB)</label>
                            <input type="file" class="form-control" id="resume" name="resume" accept=".pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection 