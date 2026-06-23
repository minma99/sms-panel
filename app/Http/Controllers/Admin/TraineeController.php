<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\Course;
use Illuminate\Http\Request;

class TraineeController extends Controller
{
    public function index()
    {
        $trainees = Trainee::with(['course', 'payments'])
            ->latest()
            ->paginate(10);

        return view('admin.trainees.index', compact('trainees'));
    }

    public function create()
    {
        $courses = Course::all();

        return view('admin.trainees.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'national_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'course_id' => 'nullable|exists:courses,id',
            'total_fee' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        Trainee::create($data);

        return redirect()
            ->route('admin.trainees.index')
            ->with('success', 'کارآموز ایجاد شد');
    }

    public function show(Trainee $trainee)
    {
        $trainee->load(['course', 'payments']);

        return view('admin.trainees.show', compact('trainee'));
    }

    public function edit(Trainee $trainee)
    {
        $courses = Course::all();

        return view('admin.trainees.edit', compact('trainee', 'courses'));
    }

    public function update(Request $request, Trainee $trainee)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'national_code' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'course_id' => 'nullable|exists:courses,id',
            'total_fee' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        $trainee->update($data);

        return redirect()
            ->route('admin.trainees.index')
            ->with('success', 'ویرایش انجام شد');
    }

    public function destroy(Trainee $trainee)
    {
        $trainee->delete();

        return redirect()
            ->route('admin.trainees.index')
            ->with('success', 'حذف شد');
    }
}
