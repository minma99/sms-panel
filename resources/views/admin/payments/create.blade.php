@extends('admin.layouts.main')

@section('title','ثبت پرداخت')
@section('page_title','ثبت پرداخت')

@section('content')

<form action="{{ route('admin.payments.store') }}" method="POST">

@csrf

<div class="card">
<div class="card-body">

<div class="row g-3">

<div class="col-md-6">
<label>کارآموز</label>

<select name="trainee_id" class="form-select">

@foreach($trainees as $trainee)

<option value="{{ $trainee->id }}">
{{ $trainee->name }}
</option>

@endforeach

</select>
</div>

<div class="col-md-6">
<label>مبلغ</label>

<input type="number"
name="amount"
class="form-control">
</div>

<div class="col-md-6">
<label>روش پرداخت</label>

<select name="payment_method" class="form-select">
<option value="cash">نقدی</option>
<option value="card">کارت</option>
<option value="online">آنلاین</option>
</select>
</div>

<div class="col-md-12">
<label>توضیحات</label>

<textarea name="note" class="form-control"></textarea>
</div>

</div>

<button class="btn btn-success mt-3">
ثبت پرداخت
</button>

<a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">
بازگشت
</a>

</div>
</div>

</form>

@endsection
