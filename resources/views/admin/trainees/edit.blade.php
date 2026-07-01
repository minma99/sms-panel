@extends('admin.layouts.main')

@section('title','ویرایش کارآموز')
@section('page_title','ویرایش کارآموز')

@section('content')

<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('admin.trainees.update',$trainee->id) }}" method="POST" enctype="multipart/form-data">

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
<label>نام پدر</label>
<input type="text" name="father_name" value="{{ $trainee->father_name }}" class="form-control">
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
<label>تاریخ تولد</label>
<input type="date" name="birth_date" value="{{ $trainee->birth_date }}" class="form-control">
</div>

<div class="col-md-6">
<label>دوره</label>

<select name="course_id" class="form-control">

<option value="">انتخاب دوره</option>

@foreach($courses as $course)

<option value="{{ $course->id }}"
{{ $trainee->course_id == $course->id ? 'selected' : '' }}>

{{ $course->title }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6">
<label>وضعیت ثبت نام</label>

<select name="registration_status" class="form-control">

<option value="ثبت نام شده"
{{ $trainee->registration_status == 'ثبت نام شده' ? 'selected' : '' }}>
ثبت نام شده
</option>

<option value="انصراف داده"
{{ $trainee->registration_status == 'انصراف داده' ? 'selected' : '' }}>
انصراف داده
</option>

<option value="تکمیل شده"
{{ $trainee->registration_status == 'تکمیل شده' ? 'selected' : '' }}>
تکمیل شده
</option>

</select>

</div>

<div class="col-md-6">
<label>شهریه کل</label>
<input type="number" name="total_fee" value="{{ $trainee->total_fee }}" class="form-control">
</div>

<div class="col-md-6">
<label>درصد تخفیف</label>
<input type="number" name="discount_percent" value="{{ $trainee->discount_percent }}" class="form-control">
</div>

<div class="col-md-6">
<label>عکس</label>
<input type="file" name="image" class="form-control">
</div>

<div class="col-md-6">
<label>فایل</label>
<input type="file" name="file" class="form-control">
</div>

<div class="col-12">
<label>توضیحات</label>
<textarea name="note" class="form-control">{{ $trainee->note }}</textarea>
</div>

</div>

<button class="btn btn-primary mt-4">
بروزرسانی
</button>

<a href="{{ route('admin.trainees.index') }}" class="btn btn-secondary mt-4">
بازگشت
</a>

</form>

</div>
</div>

@endsection
