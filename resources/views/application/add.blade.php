@extends('layouts.dashboard-layout')

@section('title', 'Internship Application')

@section('content')
    <form action="{{route('application.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between">
                <span>
                    Add New Application
                </span>
                <div class="grid row-gap-4">
                    <a href="{{ route('application.table') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Resume</span>
                            <input type="file" id="resume" name="resume" class="form-control" placeholder="Insert File">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
