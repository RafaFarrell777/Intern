@extends('layouts.landing-layout')

@section('title', 'InternConnect')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
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
                        <a href="{{ route('auth.login') }}" class="btn btn-primary">Login</a>
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
@endsection 