@extends('layouts.dashboard-layout')

@section('title', 'Review Task')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Review Task Submission</h1>
        <a href="{{ route('internship-tasks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tasks
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <!-- Task Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Task Details</h6>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-bold">{{ $task->title }}</h5>
                    <div class="mb-3">
                        <span class="badge badge-info">Submitted</span>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Student:</h6>
                        <p>{{ $task->application->siswa->name }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Program:</h6>
                        <p>{{ $task->application->program->title }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Deadline:</h6>
                        <p>{{ $task->deadline->format('M d, Y') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Submitted On:</h6>
                        <p>{{ $task->updated_at->format('M d, Y H:i:s') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Task Description:</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($task->description)) !!}
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="font-weight-bold">Submission:</h6>
                        <a href="{{ route('internship-tasks.download', $task) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i> Download Submission
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Review Form -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Review Submission</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('internship-tasks.review.submit', $task) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="status">Assessment:</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Assessment</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approve - Task Completed Successfully</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Reject - Needs Revision</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="comments">Feedback Comments:</label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" rows="5" required>{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Provide constructive feedback to the student about their submission.</small>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                            <a href="{{ route('internship-tasks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 