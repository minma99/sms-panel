@extends('layouts.main')

@section('title','Create Trainee')
@section('page_title','Add Trainee')

@section('content')

<div class="max-w-4xl mx-auto">
<div class="bg-white shadow rounded-lg p-6">

<form action="{{ route('trainees.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="grid grid-cols-2 gap-6">

<div>
<label>First Name</label>
<input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Last Name</label>
<input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Father Name</label>
<input type="text" name="father_name" value="{{ old('father_name') }}" class="w-full border rounded p-2">
</div>

<div>
<label>National Code</label>
<input type="text" name="national_code" value="{{ old('national_code') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Phone</label>
<input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Birth Date</label>
<input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Course</label>
<select name="course_id" class="w-full border rounded p-2">
<option value="">Select Course</option>
@foreach($courses as $course)
<option value="{{ $course->id }}" {{ old('course_id')==$course->id?'selected':'' }}>
{{ $course->title }}
</option>
@endforeach
</select>
</div>

<div>
<label>Registration Status</label>
<select name="registration_status" class="w-full border rounded p-2">
<option value="ثبت نام شده">ثبت نام شده</option>
<option value="انصراف داده">انصراف داده</option>
<option value="تکمیل شده">تکمیل شده</option>
</select>
</div>

<div>
<label>Exam Status</label>
<input type="text" name="exam_status" value="{{ old('exam_status') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Certificate Status</label>
<input type="text" name="certificate_status" value="{{ old('certificate_status') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Total Fee</label>
<input type="number" name="total_fee" value="{{ old('total_fee',0) }}" class="w-full border rounded p-2">
</div>

<div>
<label>Discount Percent</label>
<input type="number" name="discount_percent" value="{{ old('discount_percent',0) }}" class="w-full border rounded p-2">
</div>

<div>
<label>Exam Fee</label>
<input type="number" name="exam_fee" value="{{ old('exam_fee',0) }}" class="w-full border rounded p-2">
</div>

<div>
<label>Exam Date</label>
<input type="date" name="exam_date" value="{{ old('exam_date') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Exam Date (Shamsi)</label>
<input type="text" name="exam_date_shamsi" value="{{ old('exam_date_shamsi') }}" class="w-full border rounded p-2">
</div>

<div>
<label>Image</label>
<input type="file" name="image" class="w-full border rounded p-2">
</div>

<div>
<label>File</label>
<input type="file" name="file" class="w-full border rounded p-2">
</div>

<div class="col-span-2">
<label>Note</label>
<textarea name="note" class="w-full border rounded p-2">{{ old('note') }}</textarea>
</div>

</div>

<div class="mt-6">
<button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
Save Trainee
</button>
</div>

</form>

</div>
</div>

@endsection
