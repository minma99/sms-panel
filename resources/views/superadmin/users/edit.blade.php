@extends('superadmin.layouts.main')

@section('title','Edit User')
@section('page_title','ویرایش کاربر')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update',$user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">نام</label>
                <input type="text"
                       name="name"
                       value="{{ old('name',$user->name) }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">شماره موبایل</label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone',$user->phone) }}"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">نقش</label>

                <select name="role" class="form-control" required>
                    <option value="admin" {{ old('role',$user->role) == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="super_admin" {{ old('role',$user->role) == 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                </select>
            </div>

            <button class="btn btn-success">
                بروزرسانی کاربر
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                بازگشت
            </a>

        </form>

    </div>
</div>

@endsection
