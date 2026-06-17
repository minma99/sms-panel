<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('super_admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('super_admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'duration' => 'nullable|string',
            'capacity' => 'nullable|integer',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index');
    }

    public function show(string $id)
    {
        $course = Course::with('trainees')->findOrFail($id);
        return view('super_admin.courses.show', compact('course'));
    }

    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('super_admin.courses.edit', compact('course'));
    }

    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index');
    }

    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index');
    }
}
