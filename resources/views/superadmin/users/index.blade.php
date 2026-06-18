@extends('layouts.main')

@section('title','Users')
@section('page_title','Users List')

@section('content')

<div class="flex justify-between mb-6">
<h2 class="text-xl font-semibold">Users</h2>

<a href="{{ route('users.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded-lg">
Add User
</a>
</div>

<div class="bg-white shadow rounded-lg overflow-x-auto">

<table class="w-full text-sm text-left">

<thead class="bg-gray-100">
<tr>
<th class="p-3">ID</th>
<th class="p-3">Name</th>
<th class="p-3">Phone</th>
<th class="p-3">Role</th>
<th class="p-3">Created</th>
<th class="p-3">Actions</th>
</tr>
</thead>

<tbody>

@forelse($users as $user)

<tr class="border-t">

<td class="p-3">{{ $user->id }}</td>

<td class="p-3">{{ $user->name }}</td>

<td class="p-3">{{ $user->phone }}</td>

<td class="p-3">{{ $user->role }}</td>

<td class="p-3">{{ $user->created_at }}</td>

<td class="p-3 flex gap-3">

<a href="{{ route('users.edit',$user->id) }}"
class="text-blue-600">Edit</a>

<form action="{{ route('users.destroy',$user->id) }}" method="POST">

@csrf
@method('DELETE')

<button class="text-red-600">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="p-4 text-center">
No users found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">
{{ $users->links() }}
</div>

@endsection
