@extends('admin.layouts.main')

@section('title','ویرایش پرداخت')
@section('page_title','ویرایش پرداخت')

@section('content')

<form action="{{ route('admin.payments.update',$payment->id) }}" method="POST">

@csrf
@method('PUT')

<div class="card">
<div class="card-body">

<div class="row g-3">

<div class="col-md-6">
<label>کارآموز</label>

<select name="trainee_id" class="form-select">

@foreach($trainees as $trainee)

<option value="{{ $trainee->id }}"
{{ $payment->trainee_id == $trainee->id ? 'selected' : '' }}>

{{ $trainee->name }}

</option>

@endforeach

</select>
</div>

<div class="col-md-6">
<label>مبلغ</label>

<input type="number"
name="amount"
value="{{ $payment->amount }}"
class="form-control">
</div>

<div class="col-md-6">
<label>روش پرداخت</label>

<select name="payment_method" class="form-select">

<option value="cash" {{ $payment->payment_method=='cash'?'selected':'' }}>نقدی</option>
<option value="card" {{ $payment->payment_method=='card'?'selected':'' }}>کارت</option>
<option value="online" {{ $payment->payment_method=='online'?'selected':'' }}>آنلاین</option>

</select>
</div>

<div class="col-md-12">
<label>توضیحات</label>

<textarea name="note" class="form-control">

{{ $payment->note }}

</textarea>
</div>

</div>

<button class="btn btn-primary mt-3">
بروزرسانی
</button>

<a href="{{ route('admin.payments.index') }}" class="btn btn-secondary mt-3">
بازگشت
</a>

</div>
</div>

</form>

@endsection
