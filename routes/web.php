<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternshipApplicationsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InternshipProgramController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Models\InternshipApplications;
use App\Models\InternshipProgram;

// Public routes
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'signin'])->name('auth.signin');
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'signup'])->name('auth.signup');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Public landing page
Route::get('/landing', function () {
    $programs = \App\Models\InternshipProgram::where('status', 'active')->get();
    return view('landing', compact('programs'));
})->name('landing');

// Public program details route
Route::get('/program/{program}', function ($program) {
    $program = \App\Models\InternshipProgram::findOrFail($program);
    $programs = \App\Models\InternshipProgram::where('status', 'active')->get();
    return view('internship-programs.show', compact('program', 'programs'));
})->name('program.show');

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
        
        // Application management routes
        Route::prefix('application')->group(function () {
            Route::get('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->index();
            })->name('application.index');
            
            Route::get('/create', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->create();
            })->name('application.create');
            
            Route::post('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->store(request());
            })->name('application.store');
            
            Route::get('/{application}', function (InternshipApplications $application) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->show($application);
            })->name('application.show');
            
            Route::get('/{application}/edit', function (InternshipApplications $application) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->edit($application);
            })->name('application.edit');
            
            Route::put('/{application}', function (InternshipApplications $application) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->update(request(), $application);
            })->name('application.update');
            
            Route::delete('/{application}', function (InternshipApplications $application) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->destroy($application);
            })->name('application.destroy');
            
            Route::get('/{application}/download-resume', function (InternshipApplications $application) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipApplicationsController::class)->downloadResume($application);
            })->name('application.download-resume');
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
            
            Route::put('/{internshipProgram}', function (InternshipProgram $internshipProgram) {
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

    // Student routes
    Route::prefix('internship-programs')->group(function () {
        Route::get('/', function () {
            if (auth()->user()->role === 'magang') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->index();
        })->name('internship-programs.index');
        
        Route::get('/{program}', function ($program) {
            if (auth()->user()->role === 'magang') {
                return redirect()->route('landing');
            }
            $activePrograms = \App\Models\InternshipProgram::where('status', 'active')->get();
            $program = \App\Models\InternshipProgram::findOrFail($program);
            return view('internship-programs.show', compact('program', 'activePrograms'));
        })->name('internship-programs.show');
        
        Route::post('/apply', [InternshipProgramController::class, 'apply'])->name('internship-programs.apply');
    });

    // Landing page route
    Route::get('/', function () {
        if (auth()->user()->role === 'magang') {
            $programs = \App\Models\InternshipProgram::where('status', 'active')->get();
            return view('landing', compact('programs'));
        }
        return redirect()->route('dashboard');
    })->name('landing');

    // Dashboard route
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== 'mentor') {
            return redirect()->route('landing');
        }
        return view('dashboard');
    })->name('dashboard');

    // Internship Programs Routes (Admin only)
    Route::prefix('internship-programs')->name('internship-programs.')->group(function () {
        Route::get('/', function () {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->index();
        })->name('index');
        
        Route::get('/create', function () {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->create();
        })->name('create');
        
        Route::post('/', function () {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->store(request());
        })->name('store');
        
        Route::get('/{internshipProgram}', function (InternshipProgram $internshipProgram) {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->show($internshipProgram);
        })->name('show');
        
        Route::get('/{internshipProgram}/edit', function (InternshipProgram $internshipProgram) {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->edit($internshipProgram);
        })->name('edit');
        
        Route::put('/{internshipProgram}', function (InternshipProgram $internshipProgram) {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->update(request(), $internshipProgram);
        })->name('update');
        
        Route::delete('/{internshipProgram}', function (InternshipProgram $internshipProgram) {
            if (auth()->user()->role !== 'mentor') {
                return redirect()->route('landing');
            }
            return app(InternshipProgramController::class)->destroy($internshipProgram);
        })->name('destroy');
    });

    Route::get('/my-applications', [InternshipApplicationsController::class, 'studentIndex'])
        ->name('application.student-index');
});
