@extends('layouts.dashboard-layout')

@section('title', 'User Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Role:</div>
                        <div class="col-md-8">
                            <span class="badge badge-{{ $user->role === 'mentor' ? 'primary' : 'info' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Created At:</div>
                        <div class="col-md-8">{{ $user->created_at->format('d M Y H:i:s') }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 font-weight-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('d M Y H:i:s') }}</div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <div>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 