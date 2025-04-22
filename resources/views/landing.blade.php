@extends('layouts.landing-layout')

@section('title', 'InternConnect')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                @guest
                    Welcome to InternConnect!
                @else
                    Welcome, {{ Auth::user()->name }}!
                @endguest
            </div>

            <div class="card-body">
                <h4>Internship Management System</h4>
                <p>InternConnect helps you manage your internship program efficiently. Here you can:</p>
                <ul>
                    <li>View available internship programs</li>
                    <li>Submit internship applications</li>
                    <li>Track your internship progress</li>
                    <li>Submit reports and evaluations</li>
                </ul>

                @guest
                    <div class="text-center mt-4">
                        <a href="{{ route('auth.login') }}" class="btn btn-primary mr-2">Login</a>
                        <a href="{{ route('auth.register') }}" class="btn btn-secondary">Register</a>
                    </div>
                @else
                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</div>

@auth
    @if(auth()->user()->role === 'magang')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Available Internship Programs</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Duration</th>
                                        <th>Max Participants</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($programs as $program)
                                        <tr>
                                            <td>{{ $program->title }}</td>
                                            <td>{{ Str::limit($program->description, 100) }}</td>
                                            <td>{{ $program->location }}</td>
                                            <td>{{ $program->start_date->format('M d, Y') }} - {{ $program->end_date->format('M d, Y') }}</td>
                                            <td>{{ $program->max_participants }}</td>
                                            <td>
                                                <span class="badge badge-{{ $program->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($program->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($program->status === 'active')
                                                    <a href="{{ route('internship-programs.show', $program->id) }}" class="btn btn-sm btn-info">View Details</a>
                                                    @if(!$program->hasApplied(auth()->id()))
                                                        <a href="{{ route('internship-programs.apply', $program->id) }}" class="btn btn-sm btn-primary">Apply</a>
                                                    @else
                                                        <span class="badge badge-success">Applied</span>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth
@endsection 