@extends('layouts.dashboard-layout')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Karyawan</h5>
        <a href="#" class="btn btn-primary btn-sm">+ Tambah Karyawan</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Email</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <div>text</div>
            </tbody>
        </table>
    </div>
</div>
@endsection
