@extends('superadmin.layouts.main')

@section('title','Users')
@section('page_title','لیست کاربران')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<h4 class="mb-0">کاربران سیستم</h4>

<a href="{{ route('users.create') }}" class="btn btn-primary">
<i class="bi bi-plus-lg"></i>
افزودن کاربر
</a>

</div>

<div class="card shadow-sm border-0">

<div class="table-responsive">

<table class="table table-hover align-middle mb-0">

<thead class="table-light">

<tr>
<th width="60">ID</th>
<th>کاربر</th>
<th>تلفن</th>
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

<div style="
width:35px;
height:35px;
border-radius:50%;
background:#0d6efd;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-weight:bold;
">

{{ strtoupper(substr($user->name,0,1)) }}

</div>

<div>

<div class="fw-semibold">
{{ $user->name }}
</div>

</div>

</div>

</td>

<td>{{ $user->phone }}</td>

<td>

@if($user->role == 'super_admin')

<span class="badge bg-danger">
Super Admin
</span>

@elseif($user->role == 'admin')

<span class="badge bg-warning text-dark">
Admin
</span>

@else

<span class="badge bg-secondary">
User
</span>

@endif

</td>

<td>

{{ $user->created_at->format('Y-m-d') }}

</td>

<td>

<a href="{{ route('users.edit',$user->id) }}"
class="btn btn-sm btn-warning">

<i class="bi bi-pencil"></i>
ویرایش

</a>

<form action="{{ route('users.destroy',$user->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
onclick="return confirm('کاربر حذف شود؟')">

<i class="bi bi-trash"></i>
حذف

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="6" class="text-center p-4">

هیچ کاربری ثبت نشده است

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="mt-4">

{{ $users->links() }}

</div>

@endsection
