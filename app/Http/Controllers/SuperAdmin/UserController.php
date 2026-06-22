<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'role' => 'required|in:super_admin,admin',
        ]);

        User::create([
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'],
            'role' => $data['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'role' => 'required|in:super_admin,admin',
        ]);

        $user->update([
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'],
            'role' => $data['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'کاربر با موفقیت بروزرسانی شد');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'کاربر با موفقیت حذف شد');
    }
}
