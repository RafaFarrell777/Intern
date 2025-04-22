@extends('layouts.dashboard-layout')

@section('title', 'My Tasks')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Tasks</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Task List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Program</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr class="{{ $task->isOverdue() ? 'table-danger' : '' }}">
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->application->program->title }}</td>
                                <td>
                                    {{ $task->deadline->format('M d, Y') }}
                                    @if($task->isOverdue())
                                        <span class="badge badge-danger">Overdue</span>
                                    @elseif($task->deadline->diffInDays(now()) <= 3 && !$task->isSubmitted())
                                        <span class="badge badge-warning">Due soon</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $task->status === 'approved' ? 'success' : ($task->status === 'rejected' ? 'danger' : ($task->status === 'submitted' ? 'info' : 'warning')) }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#taskDetailsModal-{{ $task->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        
                                        @if($task->status === 'pending')
                                            <a href="{{ route('internship-tasks.submit.form', $task) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-paper-plane"></i> Submit
                                            </a>
                                        @endif
                                        
                                        @if($task->report_file)
                                            <a href="{{ route('internship-tasks.download', $task) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-download"></i> My Submission
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Task Details Modal -->
                            <div class="modal fade" id="taskDetailsModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="taskDetailsModalLabel-{{ $task->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="taskDetailsModalLabel-{{ $task->id }}">{{ $task->title }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <h6 class="font-weight-bold">Program:</h6>
                                                    <p>{{ $task->application->program->title }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="font-weight-bold">Deadline:</h6>
                                                    <p>{{ $task->deadline->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <h6 class="font-weight-bold">Status:</h6>
                                                    <p>
                                                        <span class="badge badge-{{ $task->status === 'approved' ? 'success' : ($task->status === 'rejected' ? 'danger' : ($task->status === 'submitted' ? 'info' : 'warning')) }}">
                                                            {{ ucfirst($task->status) }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="font-weight-bold">Assigned On:</h6>
                                                    <p>{{ $task->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <h6 class="font-weight-bold">Description:</h6>
                                                    <div class="p-3 bg-light rounded">
                                                        {!! nl2br(e($task->description)) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            @if($task->isSubmitted() && $task->comments)
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <h6 class="font-weight-bold">Mentor's Feedback:</h6>
                                                        <div class="p-3 bg-light rounded">
                                                            {!! nl2br(e($task->comments)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            @if($task->status === 'pending')
                                                <a href="{{ route('internship-tasks.submit.form', $task) }}" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Submit Task
                                                </a>
                                            @endif
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No tasks assigned to you yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 