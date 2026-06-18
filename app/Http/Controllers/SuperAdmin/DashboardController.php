<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $coursesCount = Course::count();
        $traineesCount = Trainee::count();
        $usersCount = User::count();
        $activeCourses = Course::whereDate('start_date_gregorian','<=',now())
            ->whereDate('end_date_gregorian','>=',now())
            ->count();
        $paymentsSum = Payment::where('status', 'completed')->sum('amount');
        $recentTrainees = Trainee::with('course')
            ->latest()
            ->take(5)
            ->get();
        $recentPayments = Payment::with('trainee')
            ->latest()
            ->take(5)
            ->get();

        return view('super_admin.dashboard', compact(
            'coursesCount',
            'traineesCount',
            'usersCount',
            'activeCourses',
            'paymentsSum',
            'recentTrainees',
            'recentPayments'
        ));
    }
}
