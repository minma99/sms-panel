@extends('layouts.main')

@section('title','Trainee Details')
@section('page_title','Trainee Details')

@section('content')

<div class="max-w-3xl mx-auto">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-xl font-semibold mb-6">
{{ $trainee->first_name }} {{ $trainee->last_name }}
</h2>

<div class="grid grid-cols-2 gap-6">

<div>
<label class="text-gray-500 text-sm">National Code</label>
<p>{{ $trainee->national_code }}</p>
</div>

<div>
<label class="text-gray-500 text-sm">Phone</label>
<p>{{ $trainee->phone }}</p>
</div>

<div>
<label class="text-gray-500 text-sm">Course</label>
<p>{{ $trainee->course->title ?? '-' }}</p>
</div>

<div>
<label class="text-gray-500 text-sm">Registration Status</label>
<p>{{ $trainee->registration_status }}</p>
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
