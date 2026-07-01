<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\CourseController;
use App\Http\Controllers\SuperAdmin\PaymentController as SuperAdminPaymentController;
use App\Http\Controllers\SuperAdmin\TraineeController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\ReportController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\TraineeController as AdminTraineeController;
use App\Http\Controllers\Admin\SmsSettingController;

use App\Http\Controllers\Auth\SuperAdminAuthController;
use App\Http\Controllers\Auth\OtpLoginController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;


/*
|--------------------------------------------------------------------------
| Welcome / Login
|--------------------------------------------------------------------------
*/

Route::get('/', [OtpLoginController::class, 'showLogin'])
    ->name('login');


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
        Route::resource('payments', SuperAdminPaymentController::class);
        Route::resource('users', UserController::class);

        Route::get('/reports/download', [ReportController::class, 'downloadPdf'])
            ->name('reports.download');

        Route::get('/settings', [SmsSettingController::class, 'index'])
            ->name('settings');

        Route::post('/settings', [SmsSettingController::class, 'update'])
            ->name('settings.update');
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

        Route::resource('payments', AdminPaymentController::class);

        // Admin اجازه حذف کارآموز ندارد
        Route::resource('trainees', AdminTraineeController::class)
            ->except(['destroy']);
});


/*
|--------------------------------------------------------------------------
| OTP Login (Admin + User)
|--------------------------------------------------------------------------
*/

// ارسال OTP
Route::post('/send-otp', [OtpLoginController::class, 'sendOtp']);

// تایید OTP
Route::post('/verify-otp', [OtpLoginController::class, 'verifyOtp']);


/*
|--------------------------------------------------------------------------
| User Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [UserDashboardController::class,'index'])
    ->middleware('auth')
    ->name('user.dashboard');


/*
|--------------------------------------------------------------------------
| Test Route
|--------------------------------------------------------------------------
*/

Route::get('/test-route', function () {
    return "Route is working!";
});
