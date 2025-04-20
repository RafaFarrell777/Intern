@extends('layouts.dashboard-layout')

@section('title', 'Internship Application')

@section('content')
    <form action="{{ route('application.update', $application->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between">
                <span>
                    Edit Application
                </span>
                <div class="grid row-gap-4">
                    <a href="{{ route('application.table') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Resume</span>
                            <input type="file" id="resume" name="resume" class="form-control">
                            <input type="text" class="form-control" value="{{ $application->resume }}" readonly>
                            <span class="input-group-text" style="cursor: pointer;">
                                <a href="{{ URL::asset('storage/assets/' . $application->resume) }}" target="_blank">
                                    View
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Status</span>
                            <select name="status" id="status" class="form-control" disabled>
                                <option value="{{ $application->status }}">{{ ucwords($application->status) }}</option>
                                <option value="accepted">Accepted</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
