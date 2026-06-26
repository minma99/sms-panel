<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('trainee')->latest()->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $trainees = Trainee::latest()->get();
        return view('superadmin.users.create', compact('trainees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'trainee'])],
            'trainee_id' => ['nullable', 'exists:trainees,id', function ($attribute, $value, $fail) use ($request) {
                if ($request->role === 'trainee' && empty($value)) {
                    $fail('The trainee field is required when role is Trainee.');
                }
                if (!empty($value) && User::where('trainee_id', $value)->exists()) {
                     $fail('This trainee is already associated with another user.');
                }
            }],
        ]);

        $finalTraineeId = ($data['role'] === 'trainee') ? ($data['trainee_id'] ?? null) : null;

        User::create([
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'],
            'role' => $data['role'],
            'trainee_id' => $finalTraineeId,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $trainees = Trainee::latest()->get();
        return view('superadmin.users.edit', compact('user', 'trainees'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'role' => ['required', Rule::in(['super_admin', 'admin', 'trainee'])],
            'trainee_id' => ['nullable', 'exists:trainees,id', function ($attribute, $value, $fail) use ($request, $user) {
                if ($request->role === 'trainee' && empty($value)) {
                    $fail('The trainee field is required when role is Trainee.');
                }
                if (!empty($value) && User::where('trainee_id', $value)->where('id', '!=', $user->id)->exists()) {
                     $fail('This trainee is already associated with another user.');
                }
            }],
        ]);

        $finalTraineeId = ($data['role'] === 'trainee') ? ($data['trainee_id'] ?? null) : null;

        $user->update([
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'],
            'role' => $data['role'],
            'trainee_id' => $finalTraineeId,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
