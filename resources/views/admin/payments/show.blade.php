@extends('admin.layouts.main')

@section('title', 'جزئیات پرداخت')
@section('page_title', 'جزئیات پرداخت')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">جزئیات پرداخت</h5>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                بازگشت
            </a>
        </div>

        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-bold">نام کارآموز</label>
                    <div class="form-control bg-light">
                        {{ $payment->trainee->full_name ?? trim(($payment->trainee->first_name ?? '') . ' ' . ($payment->trainee->last_name ?? '')) ?: '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">دوره</label>
                    <div class="form-control bg-light">
                        {{ $payment->trainee->course->title ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">مبلغ پرداخت</label>
                    <div class="form-control bg-light">
                        {{ number_format($payment->amount) }} تومان
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">باقی‌مانده بعد از پرداخت</label>
                    <div class="form-control bg-light">
                        {{ number_format($payment->remaining_after_payment ?? 0) }} تومان
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">نوع پرداخت</label>
                    <div class="form-control bg-light">
                        @if($payment->payment_type == 'full')
                            کامل
                        @elseif($payment->payment_type == 'installment')
                            قسطی
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">روش پرداخت</label>
                    <div class="form-control bg-light">
                        @if($payment->payment_method == 'cash')
                            نقدی
                        @elseif($payment->payment_method == 'card')
                            کارت
                        @elseif($payment->payment_method == 'online')
                            آنلاین
                        @else
                            -
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">تاریخ پرداخت</label>
                    <div class="form-control bg-light">
                        {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">تاریخ شمسی</label>
                    <div class="form-control bg-light">
                        {{ $payment->payment_date_shamsi ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-bold">کد پیگیری</label>
                    <div class="form-control bg-light">
                        {{ $payment->tracking_code ?? '-' }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label fw-bold">توضیحات</label>
                    <div class="form-control bg-light" style="min-height: 100px;">
                        {{ $payment->note ?? '-' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
