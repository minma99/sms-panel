@extends('superadmin.layouts.main')

@section('title','Edit User')
@section('page_title','ویرایش کاربر')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

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
<label class="form-label">تلفن</label>
<input type="text"
name="phone"
value="{{ old('phone',$user->phone) }}"
class="form-control">
</div>

<div class="mb-3">
<label class="form-label">رمز عبور</label>
<input type="password" name="password" class="form-control">

<small class="text-muted">
اگر نمی‌خواهید رمز تغییر کند این فیلد را خالی بگذارید
</small>

</div>

<div class="mb-3">
<label class="form-label">نقش</label>

<select name="role" class="form-control">

<option value="user" @if($user->role=='user') selected @endif>
User
</option>

<option value="admin" @if($user->role=='admin') selected @endif>
Admin
</option>

<option value="super_admin" @if($user->role=='super_admin') selected @endif>
Super Admin
</option>

</select>

</div>

<button class="btn btn-success">
بروزرسانی کاربر
</button>

</form>

</div>
</div>

@endsection
