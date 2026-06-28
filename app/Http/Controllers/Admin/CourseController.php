<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);

        return view('admin.superadmin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'start_date_gregorian' => 'nullable|date',
            'end_date_gregorian' => 'nullable|date',
            'start_date_shamsi' => 'nullable|string',
            'end_date_shamsi' => 'nullable|string',
        ]);

        Course::create($data);

        return redirect()
            ->route('superadmin.courses.index')
            ->with('success','Course created successfully');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        return view('admin.courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'start_date_gregorian' => 'nullable|date',
            'end_date_gregorian' => 'nullable|date',
            'start_date_shamsi' => 'nullable|string',
            'end_date_shamsi' => 'nullable|string',
        ]);

        $course->update($data);

        return redirect()
            ->route('superadmin.courses.index')
            ->with('success','Course updated successfully');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $course->delete();

        return redirect()
            ->route('superadmin.courses.index')
            ->with('success','Course deleted successfully');
    }
}
