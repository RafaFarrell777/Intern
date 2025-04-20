@extends('layouts.dashboard-layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Internship Programs</h3>
                    <a href="{{ route('internship-programs.create') }}" class="btn btn-primary">Create New Program</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Mentor</th>
                                    <th>Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($programs as $program)
                                    <tr>
                                        <td>{{ $program->title }}</td>
                                        <td>{{ $program->mentor->name }}</td>
                                        <td>{{ $program->location }}</td>
                                        <td>{{ $program->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $program->end_date->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('internship-programs.show', $program) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('internship-programs.edit', $program) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('internship-programs.destroy', $program) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this program?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $programs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 