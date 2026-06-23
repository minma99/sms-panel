<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $coursesCount = Course::count();

        return view('admin.dashboard', compact('coursesCount'));
    }
}
