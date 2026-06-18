<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\PaymentController;

Route::prefix('superadmin')->group(function () {

    Route::resource('courses', CourseController::class);

    Route::resource('payments', PaymentController::class)
        ->only(['index','create','store','destroy']);

});
