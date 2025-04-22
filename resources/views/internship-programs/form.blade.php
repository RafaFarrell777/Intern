@extends('layouts.dashboard-layout')

@section('title', isset($program) ? 'Edit Program' : 'Create Program')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isset($program) ? 'Edit Program' : 'Create Program' }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ isset($program) ? route('internship-programs.update', $program) : route('internship-programs.store') }}" method="POST">
                @csrf
                @if(isset($program))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $program->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $program->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mentor_id">Mentor</label>
                    <select class="form-control @error('mentor_id') is-invalid @enderror" id="mentor_id" name="mentor_id" required>
                        <option value="">Select Mentor</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}" {{ old('mentor_id', $program->mentor_id ?? '') == $mentor->id ? 'selected' : '' }}>
                                {{ $mentor->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('mentor_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', isset($program) ? $program->start_date->format('Y-m-d') : '') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', isset($program) ? $program->end_date->format('Y-m-d') : '') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $program->location ?? '') }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_participants">Maximum Participants</label>
                    <input type="number" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants" name="max_participants" value="{{ old('max_participants', $program->max_participants ?? '') }}" required>
                    @error('max_participants')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="requirements">Requirements</label>
                    <textarea class="form-control @error('requirements') is-invalid @enderror" id="requirements" name="requirements" rows="3" required>{{ old('requirements', $program->requirements ?? '') }}</textarea>
                    @error('requirements')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="benefits">Benefits</label>
                    <textarea class="form-control @error('benefits') is-invalid @enderror" id="benefits" name="benefits" rows="3" required>{{ old('benefits', $program->benefits ?? '') }}</textarea>
                    @error('benefits')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', $program->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $program->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="completed" {{ old('status', $program->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('internship-programs.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection 