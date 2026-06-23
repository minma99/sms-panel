@extends('admin.layouts.main')

@section('title','جزئیات کارآموز')
@section('page_title','جزئیات کارآموز')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<h4 class="mb-4">
{{ $trainee->first_name }} {{ $trainee->last_name }}
</h4>

<table class="table table-bordered">

<tr>
<th>نام پدر</th>
<td>{{ $trainee->father_name }}</td>
</tr>

<tr>
<th>کد ملی</th>
<td>{{ $trainee->national_code }}</td>
</tr>

<tr>
<th>تلفن</th>
<td>{{ $trainee->phone }}</td>
</tr>

<tr>
<th>دوره</th>
<td>{{ $trainee->course->title ?? '-' }}</td>
</tr>

<tr>
<th>وضعیت ثبت نام</th>
<td>{{ $trainee->registration_status }}</td>
</tr>

<tr>
<th>شهریه</th>
<td>{{ number_format($trainee->total_fee) }}</td>
</tr>

</table>

<a href="{{ route('admin.trainees.edit',$trainee->id) }}"
class="btn btn-warning">
ویرایش
</a>

<a href="{{ route('admin.trainees.index') }}"
class="btn btn-secondary">
بازگشت
</a>

</div>
</div>

@endsection
