@extends('admin.layouts.main')

@section('title','جزئیات کارآموز')
@section('page_title','جزئیات کارآموز')

@section('content')

@php
$discount = ($trainee->total_fee * $trainee->discount_percent) / 100;
$final_fee = $trainee->total_fee - $discount;
$paid = $trainee->payments->sum('amount');
$remaining = $final_fee - $paid;
@endphp

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
<th>شهریه کل</th>
<td>{{ number_format($trainee->total_fee) }}</td>
</tr>

<tr>
<th>درصد تخفیف</th>
<td>{{ $trainee->discount_percent }} %</td>
</tr>

<tr>
<th>مبلغ تخفیف</th>
<td>{{ number_format($discount) }}</td>
</tr>

<tr>
<th>شهریه نهایی</th>
<td>{{ number_format($final_fee) }}</td>
</tr>

<tr>
<th>مجموع پرداخت</th>
<td class="text-success">
{{ number_format($paid) }}
</td>
</tr>

<tr>
<th>باقی مانده</th>
<td class="text-danger">
{{ number_format($remaining) }}
</td>
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
