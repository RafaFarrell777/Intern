@extends('layouts.dashboard-layout')

@section('title', 'Internship Application')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-row justify-content-between">
            <span>
                Application Lists
            </span>
            <div class="grid row-gap-4">
                <a href="{{ route('dashboard') }}" class="btn btn-danger">Back</a>
                @if (Auth::user()->role == 'magang')
                    <a href="{{route('application.add')}}">
                        <button class="btn btn-primary">
                            Add
                        </button>
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Siswa</th>
                        <th scope="col">Status</th>
                        <th scope="col">Resume</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($applications as $app)
                        <tr>
                            <td class="text-center">
                                1
                            </td>
                            <td>{{ $app->siswa->name }}</td>
                            <td>{{ $app->status }}</td>
                            <td>{{ $app->resume }}</td>
                            <td class="text-center d-flex gap-1 justify-content-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                    action="{{ route('application.destroy', $app->id) }}" method="POST">
                                    <a href="{{ route('application.edit', $app->id) }}"
                                        class="btn btn-sm btn-primary">EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-danger">
                            Data Applications belum Tersedia.
                        </div>
                    @endforelse
                </tbody>
            </table>
            {{ $applications->links() }}
        </div>
    </div>
@endsection
