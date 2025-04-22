@extends('layouts.dashboard-layout')

@section('title', 'Submit Task')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Submit Task</h1>
        <a href="{{ route('internship-tasks.my-tasks') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tasks
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $task->title }}</h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Program:</h6>
                    <p>{{ $task->application->program->title }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Deadline:</h6>
                    <p>
                        {{ $task->deadline->format('M d, Y') }}
                        @if($task->isOverdue())
                            <span class="badge badge-danger">Overdue</span>
                        @elseif($task->deadline->diffInDays(now()) <= 3)
                            <span class="badge badge-warning">Due soon</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="font-weight-bold">Task Description:</h6>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($task->description)) !!}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <form action="{{ route('internship-tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="report_file">Upload Your Submission (PDF, DOC, DOCX, ZIP, RAR):</label>
                            <input type="file" class="form-control-file @error('report_file') is-invalid @enderror" id="report_file" name="report_file" required>
                            @error('report_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Max file size: 10MB</small>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to submit this task?')">
                                <i class="fas fa-paper-plane"></i> Submit Task
                            </button>
                            <a href="{{ route('internship-tasks.my-tasks') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 