@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto py-6">

<h1 class="text-2xl font-bold mb-6">Create Payment</h1>

<form action="{{ route('payments.store') }}"
method="POST"
class="bg-white p-6 rounded shadow space-y-4">

@csrf

<div>

<label class="block mb-1 font-medium">
Trainee
</label>

<select name="trainee_id"
class="w-full border rounded px-3 py-2">

@foreach($trainees as $trainee)

<option value="{{ $trainee->id }}">
{{ $trainee->name }}
</option>

@endforeach

</select>

</div>

<div>

<label class="block mb-1 font-medium">
Amount
</label>

<input type="number"
name="amount"
class="w-full border rounded px-3 py-2">

</div>

<div>

<label class="block mb-1 font-medium">
Payment Method
</label>

<select name="payment_method"
class="w-full border rounded px-3 py-2">

<option value="cash">Cash</option>
<option value="card">Card</option>
<option value="online">Online</option>

</select>

</div>

<div>

<label class="block mb-1 font-medium">
Note
</label>

<textarea name="note"
class="w-full border rounded px-3 py-2"></textarea>

</div>

<div class="flex gap-3 pt-4">

<button
class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
Save
</button>

<a href="{{ route('payments.index') }}"
class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
Cancel
</a>

</div>

</form>

</div>

@endsection
