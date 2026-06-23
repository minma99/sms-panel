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
        $trainees = Trainee::with(['course', 'payments'])->latest()->paginate(10);

        return view('superadmin.trainees.index', compact('trainees'));
    }

    public function create()
    {
        $courses = Course::all();

        return view('superadmin.trainees.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'national_code' => 'required|unique:trainees,national_code',
            'phone' => 'required',
            'birth_date' => 'nullable|date',

            'registration_status' => 'nullable',
            'exam_status' => 'nullable',
            'certificate_status' => 'nullable',

            'total_fee' => 'nullable|numeric',
            'discount_percent' => 'nullable|numeric',
            'exam_fee' => 'nullable|numeric',

            'exam_date' => 'nullable|date',
            'exam_date_shamsi' => 'nullable|string',

            'image' => 'nullable|image|max:2048',
            'file' => 'nullable|file|max:4096',

            'note' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trainees', 'public');
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('trainees', 'public');
        }

        $trainee = Trainee::create($data);

        User::create([
            'name' => $trainee->first_name.' '.$trainee->last_name,
            'phone' => $trainee->phone,
            'role' => 'user',
            'trainee_id' => $trainee->id
        ]);

        return redirect()->route('trainees.index');
    }

    public function show($id)
    {
        $trainee = Trainee::with(['course','payments'])->findOrFail($id);

        return view('superadmin.trainees.show', compact('trainee'));
    }

    public function edit($id)
    {
        $trainee = Trainee::findOrFail($id);
        $courses = Course::all();

        return view('superadmin.trainees.edit', compact('trainee','courses'));
    }

    public function update(Request $request, $id)
    {
        $trainee = Trainee::findOrFail($id);

        $data = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'national_code' => 'required|unique:trainees,national_code,'.$trainee->id,
            'phone' => 'required',
            'birth_date' => 'nullable|date',

            'registration_status' => 'nullable',
            'exam_status' => 'nullable',
            'certificate_status' => 'nullable',

            'total_fee' => 'nullable|numeric',
            'discount_percent' => 'nullable|numeric',
            'exam_fee' => 'nullable|numeric',

            'exam_date' => 'nullable|date',
            'exam_date_shamsi' => 'nullable|string',

            'image' => 'nullable|image|max:2048',
            'file' => 'nullable|file|max:4096',

            'note' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trainees', 'public');
        }

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('trainees', 'public');
        }

        $trainee->update($data);

        return redirect()->route('trainees.index');
    }

    public function destroy($id)
    {
        $trainee = Trainee::findOrFail($id);
        $trainee->delete();

        return redirect()->route('trainees.index');
    }
}
