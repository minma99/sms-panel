@extends('super_admin.layouts.main')

@section('title','Create Course')

@section('page_title','Create Course')

@section('content')

<div class="bg-white p-6 rounded-xl shadow max-w-3xl">

<form action="{{ route('super_admin.courses.store') }}" method="POST">

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
<label class="block text-sm text-gray-600 mb-1">Course Title</label>
<input type="text" name="title" value="{{ old('title') }}"
class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

@error('title')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Capacity</label>
<input type="number" name="capacity" value="{{ old('capacity') }}"
class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

@error('capacity')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Start Date (Gregorian)</label>
<input type="date" name="start_date_gregorian" value="{{ old('start_date_gregorian') }}"
class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

@error('start_date_gregorian')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">End Date (Gregorian)</label>
<input type="date" name="end_date_gregorian" value="{{ old('end_date_gregorian') }}"
class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">

@error('end_date_gregorian')
<p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">Start Date (Shamsi)</label>
<input type="text" name="start_date_shamsi" value="{{ old('start_date_shamsi') }}"
class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
</div>


<div>
<label class="block text-sm text-gray-600 mb-1">End Date (Shamsi)</label>
<input type="text" name="end_date_shamsi" value="{{ old('end_date_shamsi') }}"
class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
</div>

</div>


<div class="mt-6 flex gap-3">

<button type="submit"
class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
Create Course
</button>

<a href="{{ route('super_admin.courses.index') }}"
class="bg-gray-300 px-5 py-2 rounded-lg hover:bg-gray-400">
Cancel
</a>

</div>

</form>

</div>

@endsection
