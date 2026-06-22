@extends('superadmin.layouts.main')

@section('title','ثبت پرداخت')
@section('page_title','ثبت پرداخت')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('payments.store') }}" method="POST">

@csrf

<div class="row g-3">

<div class="col-md-6">

<label class="form-label">
کارآموز
</label>

<select name="trainee_id" class="form-select">

@foreach($trainees as $trainee)

<option value="{{ $trainee->id }}">
{{ $trainee->name }}
</option>

@endforeach

</select>

</div>

<div class="col-md-6">

<label class="form-label">
مبلغ
</label>

<input type="number"
name="amount"
class="form-control">

</div>

<div class="col-md-6">

<label class="form-label">
روش پرداخت
</label>

<select name="payment_method" class="form-select">

<option value="cash">نقدی</option>
<option value="card">کارت</option>
<option value="online">آنلاین</option>

</select>

</div>

<div class="col-md-12">

<label class="form-label">
توضیحات
</label>

<textarea name="note"
class="form-control"></textarea>

</div>

</div>

<div class="mt-4">

<button class="btn btn-success">
ذخیره
</button>

<a href="{{ route('payments.index') }}"
class="btn btn-secondary">
بازگشت
</a>

</div>

</form>

</div>
</div>

@endsection
