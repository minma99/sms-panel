@extends('superadmin.layouts.main')

@section('title','کاربران')
@section('page_title','مدیریت کاربران')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">کاربران سیستم</h4>
    <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> افزودن کاربر
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60">شناسه</th>
                    <th>کاربر</th>
                    <th>شماره تلفن</th>
                    <th>نقش</th>
                    <th>تاریخ ایجاد</th>
                    <th width="180">عملیات</th>
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
                                    <div class="fw-semibold">{{ $user->name ?? 'نامشخص' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @switch($user->role)
                                @case('super_admin')
                                    <span class="badge bg-danger">سوپر ادمین</span>
                                    @break
                                @case('admin')
                                    <span class="badge bg-warning text-dark">ادمین</span>
                                    @break
                                @case('trainee')
                                    <span class="badge bg-info text-dark">کارآموز</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">سایر</span>
                            @endswitch
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('superadmin.users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bi bi-pencil"></i> ویرایش
                            </a>
                            <form action="{{ route('superadmin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('آیا از حذف این کاربر مطمئن هستید؟');">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4">هیچ کاربری یافت نشد.</td>
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
