<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware"=> "guest", // untuk mencegah agar tidak bisa di buka saat telah memiliki session
], function() {
    Route::get("login", [AuthController::class, "login"])->name("auth.login");
    Route::post("login", [AuthController::class, "signin"])->name("auth.login");

    Route::get("register", [AuthController::class, "register"])->name("auth.register");
    Route::post("register", [AuthController::class, "signup"])->name("auth.register");
});

Route::group([
    "middleware"=> "auth", // untuk mencegah agar tidak bisa di buka saat belum memiliki session
], function() {
    Route::get('/logout', [AuthController::class,'logout'])->name('auth.logout');
});
