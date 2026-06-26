<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TraineeController extends Controller
{
    public function index()
    {
        $trainees = Trainee::with(['course', 'payments', 'user'])->latest()->paginate(10);
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
            'national_code' => 'required|string|max:10|unique:trainees,national_code',
            'phone' => 'required|string|max:20',
            'birth_date' => 'nullable|date',
            'registration_status' => 'nullable|string|max:50',
            'exam_status' => 'nullable|string|max:50',
            'certificate_status' => 'nullable|string|max:50',
            'total_fee' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'exam_fee' => 'nullable|numeric|min:0',
            'exam_date' => 'nullable|date',
            'exam_date_shamsi' => 'nullable|string|max:20',
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

        $existingUser = User::where('phone', $trainee->phone)->first();

        if ($existingUser) {
            $existingUser->update([
                'name' => $trainee->full_name,
                'role' => 'trainee',
                'trainee_id' => $trainee->id,
                'password' => $existingUser->password ?? Hash::make('password'),
            ]);
        } else {
            User::create([
                'name' => $trainee->full_name,
                'phone' => $trainee->phone,
                'password' => Hash::make('password'),
                'role' => 'trainee',
                'trainee_id' => $trainee->id,
            ]);
        }

        return redirect()->route('trainees.index')->with('success', 'Trainee created successfully.');
    }

    public function show(string $id)
    {
        $trainee = Trainee::with(['course', 'payments', 'user'])->findOrFail($id);
        return view('superadmin.trainees.show', compact('trainee'));
    }

    public function edit(string $id)
    {
        $trainee = Trainee::findOrFail($id);
        $courses = Course::all();
        return view('superadmin.trainees.edit', compact('trainee', 'courses'));
    }

    public function update(Request $request, string $id)
    {
        $trainee = Trainee::findOrFail($id);

        $data = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'national_code' => 'required|string|max:10|unique:trainees,national_code,' . $trainee->id,
            'phone' => 'required|string|max:20',
            'birth_date' => 'nullable|date',
            'registration_status' => 'nullable|string|max:50',
            'exam_status' => 'nullable|string|max:50',
            'certificate_status' => 'nullable|string|max:50',
            'total_fee' => 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'exam_fee' => 'nullable|numeric|min:0',
            'exam_date' => 'nullable|date',
            'exam_date_shamsi' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
            'file' => 'nullable|file|max:4096',
            'note' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($trainee->image && Storage::disk('public')->exists($trainee->image)) {
                Storage::disk('public')->delete($trainee->image);
            }
            $data['image'] = $request->file('image')->store('trainees', 'public');
        }

        if ($request->hasFile('file')) {
            if ($trainee->file && Storage::disk('public')->exists($trainee->file)) {
                Storage::disk('public')->delete($trainee->file);
            }
            $data['file'] = $request->file('file')->store('trainees', 'public');
        }

        $oldPhone = $trainee->phone;
        $trainee->update($data);

        $user = User::where('trainee_id', $trainee->id)->first()
            ?? User::where('phone', $oldPhone)->first();

        if ($user) {
            $user->update([
                'name' => $trainee->full_name,
                'phone' => $trainee->phone,
                'role' => 'trainee',
                'trainee_id' => $trainee->id,
            ]);
        } else {
            User::create([
                'name' => $trainee->full_name,
                'phone' => $trainee->phone,
                'password' => Hash::make('password'),
                'role' => 'trainee',
                'trainee_id' => $trainee->id,
            ]);
        }

        return redirect()->route('trainees.index')->with('success', 'Trainee updated successfully.');
    }

    public function destroy(string $id)
    {
        $trainee = Trainee::findOrFail($id);

        if ($trainee->image && Storage::disk('public')->exists($trainee->image)) {
            Storage::disk('public')->delete($trainee->image);
        }

        if ($trainee->file && Storage::disk('public')->exists($trainee->file)) {
            Storage::disk('public')->delete($trainee->file);
        }

        $user = User::where('trainee_id', $trainee->id)->first();
        if ($user) {
            $user->delete();
        }

        $trainee->delete();

        return redirect()->route('trainees.index')->with('success', 'Trainee deleted successfully.');
    }
}
