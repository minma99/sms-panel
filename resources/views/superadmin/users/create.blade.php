@extends('layouts.main')

@section('title','Create User')
@section('page_title','Create User')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 shadow rounded-lg">

<form action="{{ route('users.store') }}" method="POST">

@csrf

<div class="mb-4">
<label>Name</label>
<input type="text" name="name"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Phone</label>
<input type="text" name="phone"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Password</label>
<input type="password" name="password"
class="w-full border p-2 rounded">
</div>

<div class="mb-4">
<label>Role</label>

<select name="role" class="w-full border p-2 rounded">

<option value="user">User</option>
<option value="admin">Admin</option>
<option value="super_admin">Super Admin</option>

</select>

</div>

<button class="bg-blue-600 text-white px-6 py-2 rounded">
Create User
</button>

</form>

</div>

@endsection
