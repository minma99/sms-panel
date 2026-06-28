@extends('superadmin.layouts.main')


@section('title','ویرایش کارآموز')
@section('page_title','ویرایش کارآموز')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('superadmin.trainees.update',$trainee->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row g-3">

<div class="col-md-6">
<label>نام</label>
<input type="text" name="first_name" value="{{ $trainee->first_name }}" class="form-control">
</div>

<div class="col-md-6">
<label>نام خانوادگی</label>
<input type="text" name="last_name" value="{{ $trainee->last_name }}" class="form-control">
</div>

<div class="col-md-6">
<label>کد ملی</label>
<input type="text" name="national_code" value="{{ $trainee->national_code }}" class="form-control">
</div>

<div class="col-md-6">
<label>تلفن</label>
<input type="text" name="phone" value="{{ $trainee->phone }}" class="form-control">
</div>

<div class="col-md-6">
<label>شهریه</label>
<input type="number" name="total_fee" value="{{ $trainee->total_fee }}" class="form-control">
</div>

<div class="col-md-6">
<label>درصد تخفیف</label>
<input type="number" name="discount_percent" value="{{ $trainee->discount_percent }}" class="form-control">
</div>

<div class="col-12">
<label>توضیحات</label>
<textarea name="note" class="form-control">{{ $trainee->note }}</textarea>
</div>

</div>

<button class="btn btn-primary mt-4">
بروزرسانی
</button>

</form>

</div>
</div>

@endsection
