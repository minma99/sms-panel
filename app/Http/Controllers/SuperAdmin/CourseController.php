<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('superadmin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('superadmin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'nullable|integer',
            'capacity' => 'nullable|integer',
            'start_date' => 'nullable|string',
            'end_date' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->start_date) {
            $data['start_date'] = Jalalian::fromFormat('Y/m/d', $request->start_date)
                ->toCarbon()
                ->toDateString();
        }

        if ($request->end_date) {
            $data['end_date'] = Jalalian::fromFormat('Y/m/d', $request->end_date)
                ->toCarbon()
                ->toDateString();
        }

        Course::create($data);

        return redirect()->route('superadmin.courses.index');
    }

    public function show(string $id)
    {
        $course = Course::with('trainees')->findOrFail($id);
        return view('superadmin.courses.show', compact('course'));
    }

    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('superadmin.courses.edit', compact('course'));
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'nullable|integer',
            'capacity' => 'nullable|integer',
            'start_date' => 'nullable|string',
            'end_date' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->start_date) {
            $data['start_date'] = Jalalian::fromFormat('Y/m/d', $request->start_date)
                ->toCarbon()
                ->toDateString();
        }

        if ($request->end_date) {
            $data['end_date'] = Jalalian::fromFormat('Y/m/d', $request->end_date)
                ->toCarbon()
                ->toDateString();
        }

        $course->update($data);

        return redirect()->route('superadmin.courses.index');
    }

    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('superadmin.courses.index');
    }
}
