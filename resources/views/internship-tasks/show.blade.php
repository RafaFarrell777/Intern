@extends('layouts.dashboard-layout')

@section('title', 'Task Details')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Task Details</h1>
        <div>
            <a href="{{ route('internship-tasks.edit', $task) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Task
            </a>
            <a href="{{ route('internship-tasks.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Tasks
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Task Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Task Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5 class="font-weight-bold">{{ $task->title }}</h5>
                        <span class="badge badge-{{ $task->status === 'approved' ? 'success' : ($task->status === 'rejected' ? 'danger' : ($task->status === 'submitted' ? 'info' : 'warning')) }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Assigned To:</h6>
                            <p>{{ $task->application->siswa->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Program:</h6>
                            <p>{{ $task->application->program->title }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Deadline:</h6>
                            <p>{{ $task->deadline->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Created On:</h6>
                            <p>{{ $task->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="font-weight-bold">Task Description:</h6>
                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($task->description)) !!}
                        </div>
                    </div>

                    @if($task->status !== 'pending')
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Student Submission:</h6>
                            @if($task->report_file)
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('internship-tasks.download', $task) }}" class="btn btn-primary btn-sm mr-3">
                                        <i class="fas fa-download"></i> Download Submission
                                    </a>
                                    <span class="text-muted">Submitted on: {{ $task->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                            @else
                                <p class="text-muted">No file has been submitted yet.</p>
                            @endif
                        </div>
                    @endif

                    @if($task->comments)
                        <div class="mb-4">
                            <h6 class="font-weight-bold">Feedback Comments:</h6>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($task->comments)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Task Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('internship-tasks.edit', $task) }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-edit fa-fw text-primary mr-2"></i> Edit Task
                        </a>
                        
                        @if($task->status === 'submitted')
                            <a href="{{ route('internship-tasks.review.form', $task) }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-check-circle fa-fw text-success mr-2"></i> Review Submission
                            </a>
                        @endif
                        
                        @if($task->report_file)
                            <a href="{{ route('internship-tasks.download', $task) }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-download fa-fw text-info mr-2"></i> Download Submission
                            </a>
                        @endif
                        
                        <button type="button" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#deleteTaskModal">
                            <i class="fas fa-trash fa-fw text-danger mr-2"></i> Delete Task
                        </button>
                    </div>
                </div>
            </div>

            <!-- Student Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                </div>
                <div class="card-body">
                    <h6 class="font-weight-bold">{{ $task->application->siswa->name }}</h6>
                    <p class="text-muted">{{ $task->application->siswa->email }}</p>
                    
                    <h6 class="font-weight-bold mt-3">Application Status</h6>
                    <span class="badge badge-{{ $task->application->status === 'accepted' ? 'success' : ($task->application->status === 'rejected' ? 'danger' : 'warning') }}">
                        {{ ucfirst($task->application->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Task Modal -->
<div class="modal fade" id="deleteTaskModal" tabindex="-1" role="dialog" aria-labelledby="deleteTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTaskModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this task?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('internship-tasks.destroy', $task) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 