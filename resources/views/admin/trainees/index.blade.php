@extends('admin.layouts.main')

@section('title','کارآموزان')
@section('page_title','لیست کارآموزان')

@section('content')

<div class="d-flex justify-content-between mb-4">

<h4>همه کارآموزان</h4>

<a href="{{ route('admin.trainees.create') }}" class="btn btn-primary">
افزودن کارآموز
</a>

</div>

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>نام</th>
<th>کد ملی</th>
<th>تلفن</th>
<th>دوره</th>
<th>عملیات</th>
</tr>
</thead>

<tbody>

@foreach($trainees as $trainee)

<tr>

<td>{{ $trainee->id }}</td>

<td>
{{ $trainee->first_name }} {{ $trainee->last_name }}
</td>

<td>{{ $trainee->national_code }}</td>

<td>{{ $trainee->phone }}</td>

<td>{{ $trainee->course->title ?? '-' }}</td>

<td>

<a href="{{ route('admin.trainees.show',$trainee->id) }}"
class="btn btn-sm btn-info">
نمایش
</a>

<a href="{{ route('admin.trainees.edit',$trainee->id) }}"
class="btn btn-sm btn-warning">
ویرایش
</a>

<form action="{{ route('admin.trainees.destroy',$trainee->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
حذف
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

@endsection
