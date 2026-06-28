@extends('superadmin.layouts.main')

@section('title','جزئیات دوره')
@section('page_title','جزئیات دوره')

@section('content')

<div class="card">

<div class="card-header">
<h5 class="mb-0">اطلاعات دوره</h5>
</div>

<div class="card-body">

<div class="row g-4">

<div class="col-md-6">
<label class="text-muted">عنوان دوره</label>
<div class="fw-bold">{{ $course->title }}</div>
</div>

<div class="col-md-6">
<label class="text-muted">قیمت</label>
<div class="fw-bold">{{ number_format($course->price) }}</div>
</div>

<div class="col-md-6">
<label class="text-muted">مدت دوره</label>
<div class="fw-bold">{{ $course->duration }}</div>
</div>

<div class="col-md-6">
<label class="text-muted">ظرفیت</label>
<div class="fw-bold">{{ $course->capacity }}</div>
</div>

<div class="col-md-6">
<label class="text-muted">تاریخ شروع</label>
<div class="fw-bold">{{ $course->start_date }}</div>
</div>

<div class="col-md-6">
<label class="text-muted">تاریخ پایان</label>
<div class="fw-bold">{{ $course->end_date }}</div>
</div>

<div class="col-md-12">
<label class="text-muted">توضیحات</label>
<div class="fw-bold">
{{ $course->description }}
</div>
</div>

</div>

</div>

<div class="card-footer">

<a href="{{ route('superadmin.courses.index') }}"
class="btn btn-secondary">
بازگشت
</a>

<a href="{{ route('superadmin.courses.edit',$course->id) }}"
class="btn btn-primary">
ویرایش
</a>

</div>

</div>

@endsection
