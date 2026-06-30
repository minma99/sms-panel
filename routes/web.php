<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\PaymentController;
use App\Http\Controllers\SuperAdmin\TraineeController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\ReportController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;

use App\Http\Controllers\Auth\SuperAdminAuthController;
use App\Http\Controllers\Auth\OtpLoginController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;


/*
|--------------------------------------------------------------------------
| Welcome
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome_new');
});


/*
|--------------------------------------------------------------------------
| SuperAdmin Auth (بدون OTP)
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
    ->name('superadmin.')
    ->middleware(['auth','role:super_admin'])
    ->group(function () {

    Route::get('/', [DashboardController::class,'index'])
        ->name('dashboard');

    Route::resource('courses', CourseController::class);
    Route::resource('trainees', TraineeController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('users', UserController::class);

    Route::get('/reports/download', [ReportController::class, 'downloadPdf'])
        ->name('reports.download');

    Route::get('/settings', [App\Http\Controllers\Admin\SmsSettingController::class, 'index'])
        ->name('settings');

    Route::post('/settings', [App\Http\Controllers\Admin\SmsSettingController::class, 'update'])
        ->name('update');
});


/*
|--------------------------------------------------------------------------
| Admin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin'])
    ->group(function () {

    Route::get('/', [AdminDashboardController::class,'index'])
        ->name('dashboard');

    Route::resource('courses', AdminCourseController::class);
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class);
    Route::resource('trainees', \App\Http\Controllers\Admin\TraineeController::class);
});


/*
|--------------------------------------------------------------------------
| OTP Login (برای admin و user)
|--------------------------------------------------------------------------
*/

Route::get('/login',[OtpLoginController::class,'showLogin'])
    ->name('login');

Route::post('/send-otp',[OtpLoginController::class,'sendOtp'])
    ->middleware('throttle:5,1');

Route::post('/verify-otp',[OtpLoginController::class,'verifyOtp'])
    ->middleware('throttle:10,1');


/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [UserDashboardController::class,'index'])
    ->middleware('auth')
    ->name('user.dashboard');
