@extends('layouts.dashboard-layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Details</div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <p>{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email:</label>
                        <p>{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role:</label>
                        <p>{{ ucfirst($user->role) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Created At:</label>
                        <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Last Updated:</label>
                        <p>{{ $user->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                        <div>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 