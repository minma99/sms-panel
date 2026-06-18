@extends('super_admin.layouts.main')

@section('title','Course Details')

@section('page_title','Course Details')

@section('content')

<div class="bg-white p-6 rounded-xl shadow max-w-3xl">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
<p class="text-sm text-gray-500">Title</p>
<p class="text-lg font-semibold text-gray-800">
{{ $course->title }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">Capacity</p>
<p class="text-lg font-semibold text-gray-800">
{{ $course->capacity }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">Start Date (Gregorian)</p>
<p class="text-lg text-gray-800">
{{ $course->start_date_gregorian }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">End Date (Gregorian)</p>
<p class="text-lg text-gray-800">
{{ $course->end_date_gregorian }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">Start Date (Shamsi)</p>
<p class="text-lg text-gray-800">
{{ $course->start_date_shamsi }}
</p>
</div>

<div>
<p class="text-sm text-gray-500">End Date (Shamsi)</p>
<p class="text-lg text-gray-800">
{{ $course->end_date_shamsi }}
</p>
</div>

</div>

<div class="mt-6 flex gap-3">

<a href="{{ route('super_admin.courses.index') }}"
class="bg-gray-300 px-5 py-2 rounded-lg hover:bg-gray-400">
Back
</a>

<a href="{{ route('super_admin.courses.edit',$course->id) }}"
class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
Edit
</a>

</div>

</div>

@endsection
