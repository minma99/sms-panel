@extends('layouts.main')

@section('title','Edit Trainee')
@section('page_title','Edit Trainee')

@section('content')

<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<form action="{{ route('trainees.update',$trainee->id) }}" method="POST">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-6">

<div>
<label>First Name</label>
<input type="text"
name="first_name"
value="{{ old('first_name',$trainee->first_name) }}"
class="w-full border rounded p-2">
</div>

<div>
<label>Last Name</label>
<input type="text"
name="last_name"
value="{{ old('last_name',$trainee->last_name) }}"
class="w-full border rounded p-2">
</div>

<div>
<label>National Code</label>
<input type="text"
name="national_code"
value="{{ old('national_code',$trainee->national_code) }}"
class="w-full border rounded p-2">
</div>

<div>
<label>Phone</label>
<input type="text"
name="phone"
value="{{ old('phone',$trainee->phone) }}"
class="w-full border rounded p-2">
</div>

<div class="col-span-2">

<label>Course</label>

<select name="course_id" class="w-full border rounded p-2">

<option value="">Select Course</option>

@foreach($courses as $course)

<option value="{{ $course->id }}"
{{ old('course_id',$trainee->course_id) == $course->id ? 'selected' : '' }}>

{{ $course->title }}

</option>

@endforeach

</select>

</div>

</div>

<div class="mt-6 flex gap-3">

<button type="submit"
class="bg-blue-600 text-white px-6 py-2 rounded">
Update
</button>

<a href="{{ route('trainees.index') }}"
class="bg-gray-500 text-white px-6 py-2 rounded">
Cancel
</a>

</div>

</form>

</div>

</div>

@endsection
