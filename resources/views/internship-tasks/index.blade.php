@extends('layouts.dashboard-layout')

@section('title', 'Tasks Management')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Internship Tasks</h1>
        <a href="{{ route('internship-tasks.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Create New Task
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Task List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Student</th>
                            <th>Program</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->application->siswa->name }}</td>
                                <td>{{ $task->application->program->title }}</td>
                                <td>{{ $task->deadline->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $task->status === 'approved' ? 'success' : ($task->status === 'rejected' ? 'danger' : ($task->status === 'submitted' ? 'info' : 'warning')) }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('internship-tasks.show', $task) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($task->status === 'submitted')
                                            <a href="{{ route('internship-tasks.review.form', $task) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-check"></i> Review
                                            </a>
                                        @endif
                                        @if($task->report_file)
                                            <a href="{{ route('internship-tasks.download', $task) }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('internship-tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('internship-tasks.destroy', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No tasks found.</td>
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