@extends('admin.layouts.main')

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

<form action="{{ route('admin.courses.update',$course->id) }}" method="POST">
@csrf
@method('PUT')

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">عنوان دوره</label>
<input type="text"
       name="title"
       class="form-control"
       value="{{ old('title',$course->title) }}">
</div>

<div class="col-md-6">
<label class="form-label">قیمت</label>
<input type="text"
       id="price"
       name="price"
       class="form-control"
       value="{{ old('price', number_format($course->price)) }}">
</div>

<div class="col-md-6">
<label class="form-label">مدت دوره</label>
<input type="number"
       name="duration"
       class="form-control"
       value="{{ old('duration',$course->duration) }}">
</div>

<div class="col-md-6">
<label class="form-label">ظرفیت</label>
<input type="number"
       name="capacity"
       class="form-control"
       value="{{ old('capacity',$course->capacity) }}">
</div>

<div class="col-md-6">
<label class="form-label">تاریخ شروع</label>
<input type="text"
       name="start_date"
       class="form-control"
       value="{{ old('start_date',$course->start_date_shamsi) }}">
</div>

<div class="col-md-6">
<label class="form-label">تاریخ پایان</label>
<input type="text"
       name="end_date"
       class="form-control"
       value="{{ old('end_date',$course->end_date_shamsi) }}">
</div>

<div class="col-md-12">
<label class="form-label">توضیحات</label>
<textarea name="description"
          class="form-control"
          rows="4">{{ old('description',$course->description) }}</textarea>
</div>

</div>

<button type="submit"
        class="btn btn-primary mt-3">

بروزرسانی
</button>

<a href="{{ route('admin.courses.index') }}"
   class="btn btn-secondary mt-3">

بازگشت
</a>

</form>

</div>
</div>

<script>

const priceInput = document.getElementById('price');

priceInput.addEventListener('input', function (e) {

let value = e.target.value.replace(/,/g, '').replace(/\D/g, '');

if (value) {
e.target.value = Number(value).toLocaleString('en-US');
} else {
e.target.value = '';
}

});

document.querySelector('form').addEventListener('submit', function () {

priceInput.value = priceInput.value.replace(/,/g, '');

});

</script>

@endsection
