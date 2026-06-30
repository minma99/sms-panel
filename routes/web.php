<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpLoginController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;

// صفحه ورود
Route::get('/login', [OtpLoginController::class, 'showLogin'])->name('login');

// روت‌های OTP (بدون واسطه اضافی)
Route::post('/send-otp', [OtpLoginController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpLoginController::class, 'verifyOtp']);

// روت‌های پنل‌ها (بعد از لاگین)
Route::middleware(['auth'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminDashboard::class, 'index'])->name('superadmin.dashboard');
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/user/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
});

Route::get('/', function () {
    return view('welcome_new');
});
