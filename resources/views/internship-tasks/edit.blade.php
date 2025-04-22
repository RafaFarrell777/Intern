@extends('layouts.dashboard-layout')

@section('title', 'Edit Task')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Task</h1>
        <a href="{{ route('internship-tasks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tasks
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Task Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('internship-tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="application_id">Assigned To:</label>
                    <select class="form-control @error('application_id') is-invalid @enderror" id="application_id" name="application_id" required>
                        <option value="">Select Intern</option>
                        @foreach($applications as $application)
                            <option value="{{ $application->id }}" {{ (old('application_id') ?? $task->application_id) == $application->id ? 'selected' : '' }}>
                                {{ $application->siswa->name }} - {{ $application->program->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('application_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="title">Task Title:</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') ?? $task->title }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="description">Task Description:</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="6" required>{{ old('description') ?? $task->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Provide clear instructions and requirements for the task.</small>
                </div>
                
                <div class="form-group">
                    <label for="deadline">Deadline:</label>
                    <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline') ?? $task->deadline->format('Y-m-d') }}" required>
                    @error('deadline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="pending" {{ (old('status') ?? $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="submitted" {{ (old('status') ?? $task->status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
                        <option value="approved" {{ (old('status') ?? $task->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ (old('status') ?? $task->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="comments">Feedback Comments:</label>
                    <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" rows="3">{{ old('comments') ?? $task->comments }}</textarea>
                    @error('comments')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Provide feedback for the student (optional unless status is Approved or Rejected).</small>
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="{{ route('internship-tasks.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 