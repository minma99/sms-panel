<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\TraineeController;

Route::prefix('superadmin')->group(function () {

    Route::resource('courses', CourseController::class);

    Route::resource('payments', PaymentController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    Route::resource('trainees', TraineeController::class);

});
