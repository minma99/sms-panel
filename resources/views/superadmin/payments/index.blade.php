@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Payments</h1>

        <a href="{{ route('payments.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            New Payment
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Trainee</th>
                    <th class="p-3">Course</th>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                <tr class="border-t">
                    <td class="p-3">{{ $payment->id }}</td>
                    <td class="p-3">{{ $payment->trainee->name ?? '-' }}</td>
                    <td class="p-3">{{ $payment->course->title ?? '-' }}</td>
                    <td class="p-3">{{ number_format($payment->amount) }}</td>
                    <td class="p-3">{{ $payment->created_at->format('Y-m-d') }}</td>

                    <td class="p-3 flex gap-2">

                        <a href="{{ route('payments.show',$payment->id) }}"
                           class="text-blue-600 hover:underline">
                            View
                        </a>

                        <a href="{{ route('payments.edit',$payment->id) }}"
                           class="text-green-600 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('payments.destroy',$payment->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

    <div class="mt-6">
        {{ $payments->links() }}
    </div>

</div>

@endsection
