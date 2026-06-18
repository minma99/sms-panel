@extends('layouts.main')

@section('title','Edit User')
@section('page_title','Edit User')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 shadow rounded-lg">

<form action="{{ route('users.update',$user->id) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-4">
<label>Name</label>
<input type="text" name="name"
value="{{ old('name',$user->name) }}"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Phone</label>
<input type="text" name="phone"
value="{{ old('phone',$user->phone) }}"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Password</label>
<input type="password" name="password"
class="w-full border p-2 rounded">

<p class="text-sm text-gray-500 mt-1">
Leave blank if you don't want to change password
</p>
</div>

<div class="mb-4">
<label>Role</label>

<select name="role" class="w-full border p-2 rounded">

<option value="user"
@if($user->role=='user') selected @endif>
User
</option>

<option value="admin"
@if($user->role=='admin') selected @endif>
Admin
</option>

<option value="super_admin"
@if($user->role=='super_admin') selected @endif>
Super Admin
</option>

</select>

</div>

<button class="bg-green-600 text-white px-6 py-2 rounded">
Update User
</button>

</form>

</div>

@endsection
