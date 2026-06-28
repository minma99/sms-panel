@extends('superadmin.layouts.main')

@section('title','ویرایش پرداخت')
@section('page_title','ویرایش پرداخت')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('payments.update',$payment->id) }}" method="POST">

@csrf
@method('PUT')

<div class="row g-3">

<div class="col-md-6">

<label class="form-label">
کارآموز
</label>

<select name="trainee_id" class="form-select">
    @foreach($trainees as $trainee)
        <option value="{{ $trainee->id }}"
            {{ $payment->trainee_id == $trainee->id ? 'selected' : '' }}>
            {{ $trainee->full_name }}
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
value="{{ $payment->amount }}"
class="form-control">

</div>

<div class="col-md-6">

<label class="form-label">
روش پرداخت
</label>

<select name="payment_method" class="form-select">

<option value="cash"
{{ $payment->payment_method=='cash'?'selected':'' }}>
نقدی
</option>

<option value="card"
{{ $payment->payment_method=='card'?'selected':'' }}>
کارت
</option>

<option value="online"
{{ $payment->payment_method=='online'?'selected':'' }}>
آنلاین
</option>

</select>

</div>

<div class="col-md-12">

<label class="form-label">
توضیحات
</label>

<textarea name="note"
class="form-control">{{ $payment->note }}</textarea>

</div>

</div>

<div class="mt-4">

<button class="btn btn-primary">
بروزرسانی
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
