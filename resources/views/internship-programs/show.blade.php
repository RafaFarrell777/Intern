@extends('layouts.program-layout')

@section('title', $program->title)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Program Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">{{ $program->title }}</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Program Description</h5>
                        <p>{{ $program->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Program Details</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                    <strong>Location:</strong> {{ $program->location }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                    <strong>Duration:</strong> 
                                    {{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-users text-primary mr-2"></i>
                                    <strong>Max Participants:</strong> {{ $program->max_participants }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-user-tie text-primary mr-2"></i>
                                    <strong>Mentor:</strong> {{ $program->mentor->name }}
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="font-weight-bold">Requirements</h5>
                            <div class="requirements">
                                {!! nl2br(e($program->requirements)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-weight-bold">Benefits</h5>
                        <div class="benefits">
                            {!! nl2br(e($program->benefits)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Application Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Apply for this Program</h5>
                </div>
                <div class="card-body">
                    @auth
                        @if(auth()->user()->role === 'magang')
                            @if($program->hasApplied(auth()->id()))
                                @php
                                    $application = $program->applications()->where('siswa_id', auth()->id())->first();
                                @endphp
                                @if($application->status === 'pending')
                                    <div class="alert alert-info">
                                        <i class="fas fa-clock mr-2"></i>
                                        Your application is currently being reviewed.
                                    </div>
                                @elseif($application->status === 'accepted')
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Congratulations! Your application has been accepted.
                                    </div>
                                @elseif($application->status === 'rejected')
                                    <div class="alert alert-danger">
                                        <i class="fas fa-times-circle mr-2"></i>
                                        Your application has been rejected.
                                    </div>
                                @endif
                            @else
                                <form action="{{ route('internship-programs.apply') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                                    <div class="form-group">
                                        <label for="resume">Upload Resume (PDF only)</label>
                                        <input type="file" class="form-control-file" id="resume" name="resume" accept=".pdf" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Submit Application</button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                Only students can apply for internship programs.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            Please <a href="{{ route('auth.login') }}">login</a> to apply for this program.
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Program Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary">Program Status</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            @if($program->status === 'active')
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            @elseif($program->status === 'inactive')
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            @else
                                <i class="fas fa-check-circle fa-2x text-info"></i>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-0">Status: {{ ucfirst($program->status) }}</h6>
                            <small class="text-muted">
                                @if($program->status === 'active')
                                    Accepting applications
                                @elseif($program->status === 'inactive')
                                    Not accepting applications
                                @else
                                    Program completed
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .requirements, .benefits {
        white-space: pre-line;
    }
    .card {
        border: none;
        border-radius: 10px;
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    .text-primary {
        color: #4e73df !important;
    }
</style>
@endsection