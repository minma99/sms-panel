@extends('layouts.main')

@section('title','Dashboard')
@section('page_title','Dashboard')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow-sm flex items-center space-x-4">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Courses</p>
            <h2 class="text-2xl font-bold mt-2">{{ $coursesCount }}</h2>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm flex items-center space-x-4">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Trainees</p>
            <h2 class="text-2xl font-bold mt-2">{{ $traineesCount }}</h2>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm flex items-center space-x-4">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Payments</p>
            <h2 class="text-2xl font-bold mt-2">@currency($paymentsSum)</h2>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm flex items-center space-x-4">
        <div>
            <p class="text-gray-500 text-sm font-medium">Active Courses</p>
            <h2 class="text-2xl font-bold mt-2">{{ $activeCourses }}</h2>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm flex items-center space-x-4">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Users</p>
            <h2 class="text-2xl font-bold mt-2">{{ $usersCount }}</h2>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

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
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">
                            {{ $trainee->first_name ?? 'N/A'}} {{ $trainee->last_name ?? '' }}
                        </td>
                        <td class="p-3">
                            {{ $trainee->course->title ?? '-' }}
                        </td>
                        <td class="p-3">
                            {{ $trainee->phone ?? '-' }}
                        </td>
                        <td class="p-3">
                            {{ $trainee->created_at ? $trainee->created_at->format('Y-m-d') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            No trainees registered yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold mb-4">
            Recent Payments
        </h2>

        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Trainee</th>
                    <th class="p-3 text-left">Amount</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPayments as $payment)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3">
                            {{ $payment->trainee->first_name ?? 'N/A' }} {{ $payment->trainee->last_name ?? '' }}
                        </td>
                        <td class="p-3">
                            @currency($payment->amount)
                        </td>
                        <td class="p-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $payment->status === 'completed' ? 'bg-green-100 text-green-700' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : ($payment->status === 'failed' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700')) }}">
                                {{ ucfirst($payment->status ?? 'Unknown') }}
                            </span>
                        </td>
                        <td class="p-3">
                            {{ $payment->created_at ? $payment->created_at->format('Y-m-d') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            No payments recorded yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection

@once
    @push('scripts')
        <script>
            // Replace this with your actual currency formatting logic if @currency() is not a global helper
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[data-currency]').forEach(el => {
                    let amount = parseFloat(el.getAttribute('data-currency'));
                    el.textContent = formatCurrency(amount); // Assuming formatCurrency is defined globally
                });
            });

            // Placeholder for a potential global formatCurrency function
            function formatCurrency(amount) {
                // Example: return '$' + amount.toFixed(2);
                // Adapt this to your specific currency and locale formatting needs
                return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
            }
        </script>
    @endpush
@endonce
