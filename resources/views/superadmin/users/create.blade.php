@extends('superadmin.layouts.main')

@section('title','Create User')
@section('page_title','ایجاد کاربر')

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

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">نام</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">شماره موبایل</label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone') }}"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">نقش کاربر</label>

                <select name="role" class="form-control" required>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                </select>
            </div>

            <button class="btn btn-primary">
                ایجاد کاربر
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                بازگشت
            </a>

        </form>

    </div>
</div>

@endsection
