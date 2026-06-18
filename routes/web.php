<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\TraineeController;
use App\Http\Controllers\SuperAdmin\UserController;

Route::prefix('superadmin')
    ->middleware(['auth', 'role:super_admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('courses', CourseController::class);

        Route::resource('payments', PaymentController::class)
            ->only(['index', 'create', 'store', 'destroy']);

        Route::resource('trainees', TraineeController::class);

        Route::resource('users', UserController::class)
            ->except(['show']);

    });
