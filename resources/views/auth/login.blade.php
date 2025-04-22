@extends('layouts.auth-layout')

@section('title', 'Login')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9fafb;
    }

    .login-container {
        background: linear-gradient(135deg, #6366f1 0%, #e91e63 100%);
    }

    .form-container {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@section('content')
    <div class="flex w-full max-w-5xl overflow-hidden rounded-2xl shadow-lg">
        <div class="login-container hidden md:flex md:w-1/2 flex-col justify-between p-12 text-white">
            <div>
                <h1 class="text-4xl font-bold mb-6">InternConnect</h1>
                <p class="text-xl mb-2">Portal Magang Perusahaan</p>
                <p class="text-gray-200">Hubungkan bakat terbaik dengan peluang magang di perusahaan Anda.</p>
            </div>
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/undraw_posting_photo.svg') }}" alt="InternConnect Logo" class="h-48">
            </div>
            <div class="space-y-6">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Akses ke ribuan kandidat magang berkualitas</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Posting dan kelola lowongan magang dengan mudah</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Pantau proses rekrutmen secara real-time</p>
                </div>
            </div>
        </div>

        <div class="form-container w-full md:w-1/2 bg-white p-8 md:p-12">
            <div class="flex justify-between items-center mb-6">
                <a href="http://127.0.0.1:8000/landing" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
                <img src="{{ asset('img/undraw_rocket.svg') }}" alt="InternConnect Logo" class="h-24">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Masuk ke Akun Anda</h2>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-pink-700 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a href="{{ route('auth.register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
