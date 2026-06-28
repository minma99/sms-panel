@extends('superadmin.layouts.main')

@section('title','ویرایش دوره')
@section('page_title','ویرایش دوره')

@section('content')

<div class="card">
<div class="card-body">

@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form action="{{ route('superadmin.courses.update',$course->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row g-3">

<div class="col-md-6">
<label>عنوان دوره</label>
<input type="text" name="title" class="form-control"
value="{{ old('title',$course->title) }}">
</div>

<div class="col-md-6">
<label>قیمت</label>
<input type="number" name="price" class="form-control"
value="{{ old('price',$course->price) }}">
</div>

<div class="col-md-6">
<label>مدت دوره</label>
<input type="number" name="duration" class="form-control"
value="{{ old('duration',$course->duration) }}">
</div>

<div class="col-md-6">
<label>ظرفیت</label>
<input type="number" name="capacity" class="form-control"
value="{{ old('capacity',$course->capacity) }}">
</div>

<div class="col-md-6">
<label>تاریخ شروع</label>
<input type="date" name="start_date" class="form-control"
value="{{ old('start_date',$course->start_date) }}">
</div>

<div class="col-md-6">
<label>تاریخ پایان</label>
<input type="date" name="end_date" class="form-control"
value="{{ old('end_date',$course->end_date) }}">
</div>

<div class="col-md-12">
<label>توضیحات</label>
<textarea name="description" class="form-control">{{ old('description',$course->description) }}</textarea>
</div>

</div>

<button class="btn btn-primary mt-3">بروزرسانی</button>
<a href="{{ route('superadmin.courses.index') }}" class="btn btn-secondary mt-3">بازگشت</a>

</form>

</div>
</div>

@endsection
