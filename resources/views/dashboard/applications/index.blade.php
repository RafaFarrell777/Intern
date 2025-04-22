@extends('layouts.dashboard-layout')

@section('title', 'Manage Applications')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Internship Applications</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="applicationsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Program</th>
                            <th>Applicant</th>
                            <th>Email</th>
                            <th>Resume</th>
                            <th>Status</th>
                            <th>Applied At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>{{ $application->program->title }}</td>
                                <td>{{ $application->user->name }}</td>
                                <td>{{ $application->user->email }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="btn btn-sm btn-info">
                                        View Resume
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $application->status === 'accepted' ? 'success' : 
                                        ($application->status === 'rejected' ? 'danger' : 'warning') 
                                    }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                                <td>{{ $application->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    @if($application->status === 'pending')
                                        <form action="{{ route('applications.update', $application->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>
                                        <form action="{{ route('applications.update', $application->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#applicationModal{{ $application->id }}">
                                        View Details
                                    </button>
                                </td>
                            </tr>

                            <!-- Application Details Modal -->
                            <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1" role="dialog" aria-labelledby="applicationModalLabel{{ $application->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="applicationModalLabel{{ $application->id }}">Application Details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Program Information</h6>
                                                    <ul class="list-unstyled">
                                                        <li><strong>Title:</strong> {{ $application->program->title }}</li>
                                                        <li><strong>Location:</strong> {{ $application->program->location }}</li>
                                                        <li><strong>Duration:</strong> {{ $application->program->start_date->format('M d, Y') }} - {{ $application->program->end_date->format('M d, Y') }}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Applicant Information</h6>
                                                    <ul class="list-unstyled">
                                                        <li><strong>Name:</strong> {{ $application->user->name }}</li>
                                                        <li><strong>Email:</strong> {{ $application->user->email }}</li>
                                                        <li><strong>Applied On:</strong> {{ $application->created_at->format('M d, Y H:i') }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h6>Resume</h6>
                                                <iframe src="{{ asset('storage/' . $application->resume) }}" width="100%" height="500px"></iframe>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#applicationsTable').DataTable({
            "order": [[5, "desc"]]
        });
    });
</script>
@endpush 