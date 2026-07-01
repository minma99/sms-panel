@extends('admin.layouts.main')

@section('title', 'مشاهده کارآموز')
@section('page_title', 'جزئیات کارآموز: ' . $trainee->first_name . ' ' . $trainee->last_name)

@section('content')

<div class="card shadow-sm mb-4">

<div class="card-header bg-primary text-white">
اطلاعات کامل
</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<table class="table table-borderless">

<tr>
<th width="30%">نام و نام خانوادگی:</th>
<td>{{ $trainee->first_name }} {{ $trainee->last_name }}</td>
</tr>

<tr>
<th>نام پدر:</th>
<td>{{ $trainee->father_name ?? '-' }}</td>
</tr>

<tr>
<th>کد ملی:</th>
<td>{{ $trainee->national_code ?? '-' }}</td>
</tr>

<tr>
<th>تلفن:</th>
<td>{{ $trainee->phone ?? '-' }}</td>
</tr>

<tr>
<th>تاریخ تولد:</th>
<td>{{ $trainee->birth_date ?? '-' }}</td>
</tr>

<tr>
<th>دوره:</th>
<td>{{ $trainee->course->title ?? '-' }}</td>
</tr>

</table>

</div>


<div class="col-md-6">

<table class="table table-borderless">

<tr>
<th width="30%">وضعیت ثبت‌نام:</th>
<td>{{ $trainee->registration_status ?? '-' }}</td>
</tr>

<tr>
<th>شهریه کل:</th>
<td>{{ number_format($trainee->total_fee ?? 0) }} تومان</td>
</tr>

<tr>
<th>تخفیف:</th>
<td>{{ number_format($trainee->discount_amount ?? 0) }} تومان</td>
</tr>

<tr>
<th>شهریه نهایی:</th>
<td>{{ number_format($trainee->final_fee ?? 0) }} تومان</td>
</tr>

<tr>
<th>پرداخت شده:</th>
<td class="text-success">
{{ number_format($trainee->paid_amount ?? 0) }} تومان
</td>
</tr>

<tr>
<th>مانده بدهی:</th>
<td class="text-danger fw-bold">
{{ number_format($trainee->remaining_amount ?? 0) }} تومان
</td>
</tr>

</table>

</div>

</div>

@if($trainee->note)

<div class="alert alert-light border">
<strong>یادداشت:</strong>
{{ $trainee->note }}
</div>

@endif

</div>
</div>


<!-- جدول پرداخت‌ها -->

<div class="card shadow-sm">

<div class="card-header">
لیست پرداخت‌ها
</div>

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>
<th>مبلغ</th>
<th>تاریخ</th>
<th>روش پرداخت</th>
</tr>

</thead>

<tbody>

@forelse($trainee->payments as $payment)

<tr>

<td>
{{ number_format($payment->amount) }} تومان
</td>

<td>
{{ $payment->created_at->format('Y/m/d') }}
</td>

<td>
{{ $payment->payment_method ?? 'نامشخص' }}
</td>

</tr>

@empty

<tr>
<td colspan="3" class="text-center">
پرداختی ثبت نشده است
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="card-footer text-end">

<a href="{{ route('admin.trainees.index') }}"
class="btn btn-secondary">
بازگشت
</a>

<a href="{{ route('admin.trainees.edit', $trainee->id) }}"
class="btn btn-warning">
ویرایش
</a>

</div>

</div>

@endsection
