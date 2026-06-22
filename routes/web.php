<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\TraineeController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\Auth\SuperAdminAuthController;

/*
|--------------------------------------------------------------------------
| SuperAdmin Auth
|--------------------------------------------------------------------------
*/

Route::get('/superadmin/login', [SuperAdminAuthController::class, 'showLoginForm'])
    ->name('superadmin.login');

Route::post('/superadmin/login', [SuperAdminAuthController::class, 'login'])
    ->name('superadmin.login.submit');

Route::post('/superadmin/logout', [SuperAdminAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('superadmin.logout');


/*
|--------------------------------------------------------------------------
| SuperAdmin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('superadmin')
    ->middleware(['auth','role:super_admin'])
    ->group(function () {

    Route::get('/', [DashboardController::class,'index'])
        ->name('dashboard');

    Route::resource('courses', CourseController::class);
    Route::resource('trainees', TraineeController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('users', UserController::class);

});
