<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Trainee;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $coursesCount = Course::count();

        $traineesCount = Trainee::count();

        $paymentsSum = Payment::sum('amount');

        $activeCourses = Course::whereDate('start_date_gregorian','<=',now())
            ->whereDate('end_date_gregorian','>=',now())
            ->count();

        $latestTrainees = Trainee::with('course')
            ->latest()
            ->take(5)
            ->get();

        return view('super_admin.dashboard',compact(
            'coursesCount',
            'traineesCount',
            'paymentsSum',
            'activeCourses',
            'latestTrainees'
        ));
    }
}
