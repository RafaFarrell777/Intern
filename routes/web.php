<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InternshipApplicationsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InternshipProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InternshipTasksController;
use Illuminate\Support\Facades\Route;
use App\Models\InternshipApplications;
use App\Models\InternshipProgram;
use App\Models\InternshipTask;

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
    // Landing page route
    Route::get('/', function () {
        if (auth()->user()->role === 'magang') {
            $programs = \App\Models\InternshipProgram::where('status', 'active')->get();
            return view('landing', compact('programs'));
        }
        return redirect()->route('dashboard');
    })->name('landing');
    
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes (mentor only)
    Route::middleware(['auth'])->group(function () {
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
        
        // Internship Tasks routes for mentors (admin)
        Route::prefix('internship-tasks')->name('internship-tasks.')->group(function () {
            Route::get('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->index();
            })->name('index');
            
            Route::get('/create', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->create();
            })->name('create');
            
            Route::post('/', function () {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->store(request());
            })->name('store');
            
            Route::get('/{task}', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->show($task);
            })->name('show');
            
            Route::get('/{task}/edit', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->edit($task);
            })->name('edit');
            
            Route::put('/{task}', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->update(request(), $task);
            })->name('update');
            
            Route::delete('/{task}', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->destroy($task);
            })->name('destroy');
            
            Route::get('/{task}/review', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->reviewForm($task);
            })->name('review.form');
            
            Route::post('/{task}/review', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor') {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->review(request(), $task);
            })->name('review.submit');
            
            Route::get('/{task}/download', function (InternshipTask $task) {
                if (auth()->user()->role !== 'mentor' && $task->application->siswa_id !== auth()->id()) {
                    return redirect()->route('landing');
                }
                return app(InternshipTasksController::class)->downloadReport($task);
            })->name('download');
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

    Route::get('/my-applications', [InternshipApplicationsController::class, 'studentIndex'])
        ->name('application.student-index');

    // Internship Tasks routes for students
    Route::get('/my-tasks', function () {
        if (auth()->user()->role !== 'magang') {
            return redirect()->route('landing');
        }
        return app(InternshipTasksController::class)->myTasks();
    })->name('internship-tasks.my-tasks');
    
    Route::get('/my-tasks/{task}/submit', function (InternshipTask $task) {
        if (auth()->user()->role !== 'magang') {
            return redirect()->route('landing');
        }
        return app(InternshipTasksController::class)->submitForm($task);
    })->name('internship-tasks.submit.form');
    
    Route::post('/my-tasks/{task}/submit', function (InternshipTask $task) {
        if (auth()->user()->role !== 'magang') {
            return redirect()->route('landing');
        }
        return app(InternshipTasksController::class)->submit(request(), $task);
    })->name('internship-tasks.submit');
});
