@extends('superadmin.layouts.main')

@section('title','افزودن دوره')
@section('page_title','افزودن دوره')

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

<form action="{{ route('superadmin.courses.store') }}" method="POST">
@csrf

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">عنوان دوره</label>
<input type="text" name="title" class="form-control" value="{{ old('title') }}">
</div>

<div class="col-md-6">
<label class="form-label">قیمت</label>
<input type="text" id="price" name="price"
class="form-control"
value="{{ old('price') }}"
placeholder="مثلاً 1,500,000">
</div>

<div class="col-md-6">
<label class="form-label">ظرفیت</label>
<input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}">
</div>

<div class="col-md-6">
<label class="form-label">مدت دوره</label>
<input type="number" name="duration" class="form-control" value="{{ old('duration') }}">
</div>

<div class="col-md-6">
<label class="form-label">تاریخ شروع</label>
<input type="text" name="start_date" class="form-control"
placeholder="1405/04/10"
value="{{ old('start_date') }}">
</div>

<div class="col-md-6">
<label class="form-label">تاریخ پایان</label>
<input type="text" name="end_date" class="form-control"
placeholder="1405/05/10"
value="{{ old('end_date') }}">
</div>

<div class="col-md-12">
<label class="form-label">توضیحات</label>
<textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
</div>

</div>

<button type="submit" class="btn btn-success mt-3">ثبت</button>
<a href="{{ route('superadmin.courses.index') }}" class="btn btn-secondary mt-3">بازگشت</a>

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
