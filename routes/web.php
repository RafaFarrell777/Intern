<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternshipApplicationsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InternshipProgramController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'signin'])->name('auth.signin');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'signup'])->name('auth.signup');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Public landing page
Route::get('/landing', function () {
    return view('landing');
})->name('landing');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Admin routes (mentor only)
    Route::middleware(['auth'])->group(function () {
        // Check if user is mentor
        Route::get('/', function () {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(DashboardController::class)->index();
        })->name('dashboard');
        
        Route::prefix('application')->group(function () {
            Route::get('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->index();
            })->name('application.table');
            
            Route::get('add', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->create();
            })->name('application.add');
            
            Route::post('add', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->store(request());
            })->name('application.store');
            
            Route::get('edit/{id}', function ($id) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->edit($id);
            })->name('application.edit');
            
            Route::put('edit/{id}', function ($id) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->update(request(), $id);
            })->name('application.update');
            
            Route::delete('delete/{id}', function ($id) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->destroy($id);
            })->name('application.destroy');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->index();
            })->name('users.index');
            
            Route::get('/create', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->create();
            })->name('users.create');
            
            Route::post('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->store(request());
            })->name('users.store');
            
            Route::get('/{user}', function ($user) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->show($user);
            })->name('users.show');
            
            Route::get('/{user}/edit', function ($user) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->edit($user);
            })->name('users.edit');
            
            Route::put('/{user}', function ($user) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->update(request(), $user);
            })->name('users.update');
            
            Route::delete('/{user}', function ($user) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(UserController::class)->destroy($user);
            })->name('users.destroy');
        });

        Route::prefix('internship-programs')->group(function () {
            Route::get('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->index();
            })->name('internship-programs.index');
            
            Route::get('/create', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->create();
            })->name('internship-programs.create');
            
            Route::post('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->store(request());
            })->name('internship-programs.store');
            
            Route::get('/{internshipProgram}', function ($internshipProgram) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->show($internshipProgram);
            })->name('internship-programs.show');
            
            Route::get('/{internshipProgram}/edit', function ($internshipProgram) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->edit($internshipProgram);
            })->name('internship-programs.edit');
            
            Route::put('/{internshipProgram}', function ($internshipProgram) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->update(request(), $internshipProgram);
            })->name('internship-programs.update');
            
            Route::delete('/{internshipProgram}', function ($internshipProgram) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipProgramController::class)->destroy($internshipProgram);
            })->name('internship-programs.destroy');
        });
    });
});
