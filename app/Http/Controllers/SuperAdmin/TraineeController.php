<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class TraineeController extends Controller
{
    public function index()
    {
        $trainees = Trainee::with('course')->latest()->paginate(10);
        return view('super_admin.trainees.index', compact('trainees'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('super_admin.trainees.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'national_code' => 'required|unique:trainees',
            'phone' => 'required',
        ]);

        $trainee = Trainee::create($request->all());

        User::create([
            'name' => $trainee->first_name . ' ' . $trainee->last_name,
            'phone' => $trainee->phone,
            'role' => 'user',
            'trainee_id' => $trainee->id
        ]);

        return redirect()->route('trainees.index');
    }

    public function show(string $id)
    {
        $trainee = Trainee::with(['course','payments'])->findOrFail($id);
        return view('super_admin.trainees.show', compact('trainee'));
    }

    public function edit(string $id)
    {
        $trainee = Trainee::findOrFail($id);
        $courses = Course::all();

        return view('super_admin.trainees.edit', compact('trainee','courses'));
    }

    public function update(Request $request, string $id)
    {
        $trainee = Trainee::findOrFail($id);

        $trainee->update($request->all());

        return redirect()->route('trainees.index');
    }

    public function destroy(string $id)
    {
        $trainee = Trainee::findOrFail($id);
        $trainee->delete();

        return redirect()->route('trainees.index');
    }
}
