@extends('layouts.auth-layout')

@section('title', 'Register')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9fafb;
    }

    .register-container {
        background: linear-gradient(135deg, #6366f1 0%, #e91e63 100%);
    }

    .form-container {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@section('content')
    <div class="flex w-full max-w-5xl overflow-hidden rounded-2xl shadow-lg">
        <div class="register-container hidden md:flex md:w-1/2 flex-col justify-between p-12 text-white">
            <div>
                <h1 class="text-4xl font-bold mb-6">InternConnect</h1>
                <p class="text-xl mb-2">Portal Magang Perusahaan</p>
                <p class="text-gray-200">Daftarkan perusahaan Anda dan mulai rekrut bakat terbaik untuk program magang.
                </p>
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
                    <p>Profil perusahaan yang menarik</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Sistem manajemen lamaran yang efisien</p>
                </div>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <p>Analitik dan laporan performa lengkap</p>
                </div>
            </div>
        </div>

        <div class="form-container w-full md:w-1/2 bg-white p-8 md:p-12 overflow-y-auto max-h-screen">
            <div class="flex justify-between items-center mb-6">
                <a href="http://127.0.0.1:8000/landing" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
                <img src="{{ asset('img/undraw_rocket.svg') }}" alt="InternConnect Logo" class="h-24">
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Akun Perusahaan</h2>

            <form method="POST" action="{{ route('auth.register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        autofocus
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-3">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah memiliki akun?
                    <a href="{{ route('auth.login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Masuk
                    </a>
                </p>
            </div>

            <div class="mt-8">
                <p class="text-xs text-gray-500 text-center">
                    Dengan mendaftar, Anda menyetujui <a href="#" class="text-indigo-600">Syarat dan
                        Ketentuan</a> serta <a href="#" class="text-indigo-600">Kebijakan Privasi</a> kami.
                </p>
            </div>
        </div>
    </div>
@endsection
