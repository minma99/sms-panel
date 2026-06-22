@extends('superadmin.layouts.main')

@section('title','Create User')
@section('page_title','ایجاد کاربر')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('users.store') }}" method="POST">

@csrf

<div class="mb-3">
<label class="form-label">نام</label>
<input type="text" name="name" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">تلفن</label>
<input type="text" name="phone" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">رمز عبور</label>
<input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">نقش کاربر</label>

<select name="role" class="form-control">

<option value="user">User</option>
<option value="admin">Admin</option>
<option value="super_admin">Super Admin</option>

</select>

</div>

<button class="btn btn-primary">
ایجاد کاربر
</button>

</form>

</div>
</div>

@endsection
