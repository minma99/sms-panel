@extends('superadmin.layouts.main')

@section('title','Users')
@section('page_title','User Management')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">System Users</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add User
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60">ID</th>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Created Date</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-sm rounded-circle" style="background-color: #0d6efd; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $user->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @switch($user->role)
                                @case('super_admin')
                                    <span class="badge bg-danger">Super Admin</span>
                                    @break
                                @case('admin')
                                    <span class="badge bg-warning text-dark">Admin</span>
                                    @break
                                @case('trainee')
                                    <span class="badge bg-info text-dark">Trainee</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">Other</span>
                            @endswitch
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $users->links() }}
</div>

@endsection
