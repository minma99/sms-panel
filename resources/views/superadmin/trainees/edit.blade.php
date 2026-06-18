@extends('layouts.main')

@section('title','Edit Trainee')
@section('page_title','Edit Trainee')

@section('content')

<div class="max-w-4xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<form action="{{ route('trainees.update',$trainee->id) }}" method="POST" enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-6">

<input type="text" name="first_name" value="{{ old('first_name',$trainee->first_name) }}" class="border p-2">

<input type="text" name="last_name" value="{{ old('last_name',$trainee->last_name) }}" class="border p-2">

<input type="text" name="father_name" value="{{ old('father_name',$trainee->father_name) }}" class="border p-2">

<input type="text" name="national_code" value="{{ old('national_code',$trainee->national_code) }}" class="border p-2">

<input type="text" name="phone" value="{{ old('phone',$trainee->phone) }}" class="border p-2">

<input type="date" name="birth_date" value="{{ old('birth_date',$trainee->birth_date) }}" class="border p-2">

<input type="text" name="exam_status" value="{{ old('exam_status',$trainee->exam_status) }}" class="border p-2">

<input type="text" name="certificate_status" value="{{ old('certificate_status',$trainee->certificate_status) }}" class="border p-2">

<input type="number" name="total_fee" value="{{ old('total_fee',$trainee->total_fee) }}" class="border p-2">

<input type="number" name="discount_percent" value="{{ old('discount_percent',$trainee->discount_percent) }}" class="border p-2">

<input type="number" name="exam_fee" value="{{ old('exam_fee',$trainee->exam_fee) }}" class="border p-2">

<input type="date" name="exam_date" value="{{ old('exam_date',$trainee->exam_date) }}" class="border p-2">

<input type="text" name="exam_date_shamsi" value="{{ old('exam_date_shamsi',$trainee->exam_date_shamsi) }}" class="border p-2">

<input type="file" name="image" class="border p-2">

<input type="file" name="file" class="border p-2">

<textarea name="note" class="border p-2 col-span-2">{{ old('note',$trainee->note) }}</textarea>

</div>

<div class="mt-6">

<button class="bg-blue-600 text-white px-6 py-2 rounded">
Update
</button>

</div>

</form>

</div>

</div>

@endsection
