@extends('layouts.main')

@section('title','Trainees')
@section('page_title','Trainees List')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold">All Trainees</h2>

    <a href="{{ route('trainees.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Add Trainee
    </a>
</div>

<div class="bg-white shadow rounded-lg overflow-x-auto">

<table class="w-full text-sm text-left">

<thead class="bg-gray-100">
<tr>
<th class="p-3">ID</th>
<th class="p-3">Name</th>
<th class="p-3">National Code</th>
<th class="p-3">Phone</th>
<th class="p-3">Course</th>
<th class="p-3">Actions</th>
</tr>
</thead>

<tbody>

@forelse($trainees as $trainee)

<tr class="border-t">

<td class="p-3">{{ $trainee->id }}</td>

<td class="p-3">
{{ $trainee->first_name }} {{ $trainee->last_name }}
</td>

<td class="p-3">
{{ $trainee->national_code }}
</td>

<td class="p-3">
{{ $trainee->phone }}
</td>

<td class="p-3">
{{ $trainee->course->title ?? '-' }}
</td>

<td class="p-3 flex gap-3">

<a href="{{ route('trainees.show',$trainee->id) }}"
class="text-blue-600 hover:underline">
View
</a>

<a href="{{ route('trainees.edit',$trainee->id) }}"
class="text-green-600 hover:underline">
Edit
</a>

<form action="{{ route('trainees.destroy',$trainee->id) }}"
method="POST"
onsubmit="return confirm('Delete trainee?')">

@csrf
@method('DELETE')

<button class="text-red-600 hover:underline">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="6" class="p-4 text-center text-gray-500">
No trainees found
</td>
</tr>

@endforelse

</tbody>
</table>

</div>

<div class="mt-6">
{{ $trainees->links() }}
</div>

@endsection
