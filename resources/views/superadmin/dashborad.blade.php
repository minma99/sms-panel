@extends('layouts.main')

@section('title','Dashboard')
@section('page_title','Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-gray-500 text-sm">Total Courses</p>
<h2 class="text-2xl font-bold mt-2">{{ $coursesCount }}</h2>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-gray-500 text-sm">Total Trainees</p>
<h2 class="text-2xl font-bold mt-2">{{ $traineesCount }}</h2>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-gray-500 text-sm">Total Payments</p>
<h2 class="text-2xl font-bold mt-2">{{ $paymentsSum }}</h2>
</div>

<div class="bg-white p-6 rounded-xl shadow">
<p class="text-gray-500 text-sm">Active Courses</p>
<h2 class="text-2xl font-bold mt-2">{{ $activeCourses }}</h2>
</div>

</div>


<div class="bg-white shadow rounded-xl p-6">

<h2 class="text-lg font-semibold mb-4">
Recent Trainees
</h2>

<table class="w-full text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Name</th>
<th class="p-3 text-left">Course</th>
<th class="p-3 text-left">Phone</th>
<th class="p-3 text-left">Registered</th>
</tr>
</thead>

<tbody>

@forelse($recentTrainees as $trainee)

<tr class="border-t">

<td class="p-3">
{{ $trainee->first_name }} {{ $trainee->last_name }}
</td>

<td class="p-3">
{{ $trainee->course->title ?? '-' }}
</td>

<td class="p-3">
{{ $trainee->phone }}
</td>

<td class="p-3">
{{ $trainee->created_at->format('Y-m-d') }}
</td>

</tr>

@empty

<tr>
<td colspan="4" class="p-4 text-center text-gray-500">
No trainees yet
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

@endsection
