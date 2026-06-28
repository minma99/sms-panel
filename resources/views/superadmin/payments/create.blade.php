@extends('superadmin.layouts.main')

@section('title', 'Create Payment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ثبت پرداخت جدید</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('superadmin.payments.store') }}">
                        @csrf

                        <div class="row g-3">

                            {{-- کارآموز --}}
                            <div class="col-md-6">
                                <label class="form-label">کارآموز</label>
                                <select name="trainee_id" class="form-select" required>
<option value="">انتخاب کارآموز</option>

@foreach($trainees as $trainee)
<option value="{{ $trainee->id }}"
{{ old('trainee_id', $selectedTrainee ?? null) == $trainee->id ? 'selected' : '' }}>
{{ $trainee->full_name }}
</option>
@endforeach

</select>

                                @error('trainee_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- تخفیف --}}
                            <div class="col-md-6">
                                <label class="form-label">تخفیف (%)</label>
                                <input
                                    type="number"
                                    name="discount_percent"
                                    value="{{ old('discount_percent') }}"
                                    class="form-control"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                >
                                @error('discount_percent')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- اطلاعات مالی کارآموز --}}
                            <div class="col-12">
                                <div class="border rounded p-3 bg-light">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>کل شهریه:</strong>
                                            <span id="total_fee">-</span>
                                        </div>

                                        <div class="col-md-4">
                                            <strong>کل پرداخت شده:</strong>
                                            <span id="paid_amount">-</span>
                                        </div>

                                        <div class="col-md-4">
                                            <strong>باقی‌مانده:</strong>
                                            <span id="remaining_amount">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- مبلغ پرداخت --}}
                            <div class="col-md-6">
                                <label class="form-label">مبلغ پرداخت</label>
                                <input
                                    type="number"
                                    name="amount"
                                    value="{{ old('amount') }}"
                                    class="form-control"
                                    required
                                    min="0"
                                    step="0.01"
                                >
                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- نوع پرداخت --}}
                            <div class="col-md-6">
                                <label class="form-label">نوع پرداخت</label>
                                <select name="payment_type" class="form-select">
                                    <option value="installment" {{ old('payment_type') == 'installment' ? 'selected' : '' }}>قسطی</option>
                                    <option value="full" {{ old('payment_type') == 'full' ? 'selected' : '' }}>کامل</option>
                                </select>
                                @error('payment_type')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- روش پرداخت --}}
                            <div class="col-md-6">
                                <label class="form-label">روش پرداخت</label>
                                <select name="payment_method" class="form-select">
                                    <option value="">انتخاب کنید</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>نقدی</option>
                                    <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>کارت</option>
                                    <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>آنلاین</option>
                                </select>
                                @error('payment_method')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- کد رهگیری --}}
                            <div class="col-md-6">
                                <label class="form-label">کد رهگیری</label>
                                <input
                                    type="text"
                                    name="tracking_code"
                                    value="{{ old('tracking_code') }}"
                                    class="form-control"
                                >
                                @error('tracking_code')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- تاریخ میلادی --}}
                            <div class="col-md-6">
                                <label class="form-label">تاریخ پرداخت</label>
                                <input
                                    type="date"
                                    name="payment_date"
                                    value="{{ old('payment_date') }}"
                                    class="form-control"
                                >
                                @error('payment_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- تاریخ شمسی --}}
                            <div class="col-md-6">
                                <label class="form-label">تاریخ شمسی</label>
                                <input
                                    type="text"
                                    name="payment_date_shamsi"
                                    value="{{ old('payment_date_shamsi') }}"
                                    class="form-control"
                                >
                                @error('payment_date_shamsi')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- توضیحات --}}
                            <div class="col-12">
                                <label class="form-label">توضیحات</label>
                                <textarea name="note" class="form-control" rows="4">{{ old('note') }}</textarea>
                                @error('note')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">
                                ثبت پرداخت
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const trainees = @json($trainees);
    const select = document.querySelector('[name="trainee_id"]');

    const totalFeeEl = document.getElementById('total_fee');
    const paidAmountEl = document.getElementById('paid_amount');
    const remainingAmountEl = document.getElementById('remaining_amount');

    function formatNumber(value) {
        return new Intl.NumberFormat('en-US').format(value ?? 0);
    }

    function updateFinancialInfo() {
        const trainee = trainees.find(t => String(t.id) === String(select.value));

        if (!trainee) {
            totalFeeEl.textContent = '-';
            paidAmountEl.textContent = '-';
            remainingAmountEl.textContent = '-';
            return;
        }

        totalFeeEl.textContent = formatNumber(trainee.final_fee);
        paidAmountEl.textContent = formatNumber(trainee.paid_amount);
        remainingAmountEl.textContent = formatNumber(trainee.remaining_amount);
    }

    select.addEventListener('change', updateFinancialInfo);

    updateFinancialInfo();
});
</script>
@endsection
