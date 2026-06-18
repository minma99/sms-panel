@extends('layouts.main')

@section('title','Trainee Details')
@section('page_title','Trainee Details')

@section('content')

<div class="max-w-4xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-xl font-semibold mb-6">
{{ $trainee->first_name }} {{ $trainee->last_name }}
</h2>

<div class="grid grid-cols-2 gap-6">

<div>
<label>Father Name</label>
<p>{{ $trainee->father_name }}</p>
</div>

<div>
<label>National Code</label>
<p>{{ $trainee->national_code }}</p>
</div>

<div>
<label>Phone</label>
<p>{{ $trainee->phone }}</p>
</div>

<div>
<label>Birth Date</label>
<p>{{ $trainee->birth_date }}</p>
</div>

<div>
<label>Course</label>
<p>{{ $trainee->course->title ?? '-' }}</p>
</div>

<div>
<label>Registration Status</label>
<p>{{ $trainee->registration_status }}</p>
</div>

<div>
<label>Exam Status</label>
<p>{{ $trainee->exam_status }}</p>
</div>

<div>
<label>Certificate Status</label>
<p>{{ $trainee->certificate_status }}</p>
</div>

<div>
<label>Total Fee</label>
<p>{{ $trainee->total_fee }}</p>
</div>

<div>
<label>Discount Percent</label>
<p>{{ $trainee->discount_percent }}%</p>
</div>

<div>
<label>Exam Fee</label>
<p>{{ $trainee->exam_fee }}</p>
</div>

<div>
<label>Exam Date</label>
<p>{{ $trainee->exam_date }}</p>
</div>

<div>
<label>Exam Date Shamsi</label>
<p>{{ $trainee->exam_date_shamsi }}</p>
</div>

<div>
<label>Image</label>

@if($trainee->image)
<img src="{{ asset('storage/'.$trainee->image) }}" class="w-24">
@endif

</div>

<div>
<label>File</label>

@if($trainee->file)
<a href="{{ asset('storage/'.$trainee->file) }}" class="text-blue-600">
Download
</a>
@endif

</div>

<div class="col-span-2">
<label>Note</label>
<p>{{ $trainee->note }}</p>
</div>

</div>

<div class="mt-6 flex gap-3">

<a href="{{ route('trainees.edit',$trainee->id) }}"
class="bg-yellow-500 text-white px-4 py-2 rounded">
Edit
</a>

<a href="{{ route('trainees.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded">
Back
</a>

</div>

</div>

</div>

@endsection
