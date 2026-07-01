<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // شمارش تعداد دوره‌ها
        $coursesCount = Schema::hasTable('courses') ? Course::count() : 0;
        
        // شمارش کاربران با نقش کارآموز
        $traineesCount = User::where('role', 'trainee')->count();
        
        // کل کاربران سیستم
        $usersCount = User::count();
        
        // مجموع مبلغ پرداخت‌های موفق
        $paymentsSum = 0;
        if (Schema::hasTable('payments')) {
            $paymentsSum = Payment::where('status', 'completed')->sum('amount') ?? 0;
        }

        // دریافت آخرین کاربران کارآموز ثبت‌نام شده به همراه اطلاعات کارآموزی و دوره مربوطه
        $recentTrainees = User::where('role', 'trainee')
            ->with('trainee.course')
            ->latest()
            ->take(5)
            ->get();

        // دریافت آخرین پرداخت‌ها
        $recentPayments = collect();
        if (Schema::hasTable('payments')) {
            $recentPayments = Payment::with('trainee')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('admin.dashboard', compact(
            'coursesCount',
            'traineesCount',
            'usersCount',
            'paymentsSum',
            'recentTrainees',
            'recentPayments'
        ));
    }
}
