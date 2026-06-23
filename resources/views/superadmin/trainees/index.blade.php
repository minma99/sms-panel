@extends('superadmin.layouts.main')

@section('title','کارآموزان')
@section('page_title','لیست کارآموزان')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<h4>همه کارآموزان</h4>
<!-- دکمه گزارش -->
        <a href="{{ route('superadmin.reports.download') }}" class="btn btn-success">
            <i class="fa fa-download"></i> دانلود گزارش PDF
        </a>

<a href="{{ route('trainees.create') }}" class="btn btn-primary">
افزودن کارآموز
</a>

</div>

<div class="card shadow-sm">

<div class="table-responsive">

<table class="table table-bordered table-hover mb-0">

<thead class="table-light">

<tr>
<th>ID</th>
<th>نام</th>
<th>کد ملی</th>
<th>دوره</th>
<th>شهریه</th>
<th>پرداخت شده</th>
<th>باقی مانده</th>
<th width="180">عملیات</th>
</tr>

</thead>

<tbody>

@forelse($trainees as $trainee)

@php
$discount = ($trainee->total_fee * $trainee->discount_percent) / 100;
$final_fee = $trainee->total_fee - $discount;
$paid = $trainee->payments->sum('amount');
$remaining = $final_fee - $paid;
@endphp

<tr>

<td>{{ $trainee->id }}</td>

<td>{{ $trainee->first_name }} {{ $trainee->last_name }}</td>

<td>{{ $trainee->national_code }}</td>

<td>{{ $trainee->course->title ?? '-' }}</td>

<td>{{ number_format($final_fee) }}</td>

<td class="text-success">
{{ number_format($paid) }}
</td>

<td class="text-danger">
{{ number_format($remaining) }}
</td>

<td>

<a href="{{ route('trainees.show',$trainee->id) }}"
class="btn btn-sm btn-info">
نمایش
</a>

<a href="{{ route('trainees.edit',$trainee->id) }}"
class="btn btn-sm btn-warning">
ویرایش
</a>

<form action="{{ route('trainees.destroy',$trainee->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
onclick="return confirm('حذف شود؟')">
حذف
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="8" class="text-center p-4">
هیچ کارآموزی ثبت نشده
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="mt-4">
{{ $trainees->links() }}
</div>

@endsection
