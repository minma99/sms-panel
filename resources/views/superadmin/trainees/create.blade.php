@extends('layouts.main')

@section('title','Create Trainee')
@section('page_title','Add Trainee')

@section('content')

<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<form action="{{ route('trainees.store') }}" method="POST">

@csrf

<div class="grid grid-cols-2 gap-6">

<div>
<label>First Name</label>
<input type="text" name="first_name"
value="{{ old('first_name') }}"
class="w-full border rounded p-2">

@error('first_name')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

<div>
<label>Last Name</label>
<input type="text" name="last_name"
value="{{ old('last_name') }}"
class="w-full border rounded p-2">

@error('last_name')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

<div>
<label>National Code</label>
<input type="text" name="national_code"
value="{{ old('national_code') }}"
class="w-full border rounded p-2">

@error('national_code')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

<div>
<label>Phone</label>
<input type="text" name="phone"
value="{{ old('phone') }}"
class="w-full border rounded p-2">

@error('phone')
<p class="text-red-500 text-sm">{{ $message }}</p>
@enderror
</div>

<div class="col-span-2">

<label>Course</label>

<select name="course_id" class="w-full border rounded p-2">

<option value="">Select Course</option>

@foreach($courses as $course)

<option value="{{ $course->id }}"
{{ old('course_id') == $course->id ? 'selected' : '' }}>

{{ $course->title }}

</option>

@endforeach

</select>

</div>

</div>

<div class="mt-6">

<button type="submit"
class="bg-blue-600 text-white px-6 py-2 rounded">
Save Trainee
</button>

</div>

</form>

</div>

</div>

@endsection
