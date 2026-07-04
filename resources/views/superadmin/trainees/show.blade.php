@extends('superadmin.layouts.main')

@section('title', 'مشاهده کارآموز')
@section('page_title', 'جزئیات کارآموز: ' . $trainee->full_name)

@section('content')

{{-- نمایش پیام‌های موفقیت سیستم --}}
@if(session('success') && !session('show_sms_box'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- باکس ارسال پیامک اختیاری --}}
@if(session('show_sms_box'))
    <div class="card border-primary shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 fs-6"><i class="bi bi-envelope-fill me-1"></i> ارسال پیامک اختیاری به کارآموز</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close" onclick="this.closest('.card').remove();"></button>
        </div>
        <div class="card-body bg-light">
            <p class="text-muted small">
                عملیات قبلی با موفقیت انجام شد. در صورت تمایل، می‌توانید پیامک زیر را به شماره همراه کارآموز 
                <strong>({{ $trainee->phone }})</strong> ارسال کنید.
            </p>
            <form action="{{ route('superadmin.trainees.send-sms', $trainee->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="sms_message" class="form-label fw-bold small">متن پیامک:</label>
                    <textarea class="form-control" id="sms_message" name="message" rows="3" required>{{ session('sms_message') }}</textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="this.closest('.card').remove();">انصراف و عدم ارسال</button>
                    <button type="submit" class="btn btn-success btn-sm px-4">ارسال پیامک</button>
                </div>
            </form>
        </div>
    </div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">اطلاعات کامل</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th width="30%">نام و نام خانوادگی:</th><td>{{ $trainee->full_name }}</td></tr>
                    <tr><th>نام پدر:</th><td>{{ $trainee->father_name ?? '-' }}</td></tr>
                    <tr><th>کد ملی:</th><td>{{ $trainee->national_code ?? '-' }}</td></tr>
                    <tr><th>تلفن:</th><td>{{ $trainee->phone ?? '-' }}</td></tr>
                    <tr><th>تاریخ تولد:</th><td>{{ $trainee->birth_date ?? '-' }}</td></tr>
                    <tr><th>دوره:</th><td>{{ $trainee->course->title ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tr><th width="30%">وضعیت ثبت‌نام:</th><td>{{ $trainee->registration_status ?? '-' }}</td></tr>
                    <tr><th>وضعیت آزمون:</th><td>{{ $trainee->exam_status ?? '-' }}</td></tr>
                    <tr><th>وضعیت مدرک:</th><td>{{ $trainee->certificate_status ?? '-' }}</td></tr>
                    <tr><th>شهریه کل:</th><td>{{ number_format($trainee->total_fee ?? 0) }} تومان</td></tr>
                    <tr><th>تخفیف:</th><td>{{ number_format($trainee->discount_amount ?? 0) }} تومان</td></tr>
                    <tr><th>مانده بدهی:</th><td class="text-danger fw-bold">{{ number_format($trainee->remaining_amount ?? 0) }} تومان</td></tr>
                </table>
            </div>
        </div>
        @if($trainee->note)
            <div class="alert alert-light border"><strong>یادداشت:</strong> {{ $trainee->note }}</div>
        @endif
    </div>
</div>

{{-- جدول پرداخت‌های این کارآموز --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">لیست پرداخت‌ها</div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>مبلغ</th>
                    <th>تاریخ پرداخت</th>
                    <th>روش پرداخت</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trainee->payments as $payment)
                    <tr>
                        <td>{{ number_format($payment->amount) }} تومان</td>
                        <td>{{ $payment->created_at->format('Y/m/d') }}</td>
                        <td>{{ $payment->payment_method ?? 'نامشخص' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted">پرداختی ثبت نشده است</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- جدول تاریخچه پیامک‌های ارسال شده --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-light">تاریخچه پیامک‌های ارسال شده</div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>فرستنده</th>
                    <th>متن پیامک</th>
                    <th>وضعیت</th>
                    <th>تاریخ ثبت</th>
                </tr>
            </thead>
            <tbody>
                @forelse($smsLogs as $log)
                    <tr>
                        <td>{{ $log->type == 'manual' ? 'دستی' : 'خودکار' }}</td>
                        <td title="{{ $log->message }}">{{ \Illuminate\Support\Str::limit($log->message, 50) }}</td>
                        <td>
                            @if($log->status == 'sent')
                                <span class="badge bg-success">ارسال شده</span>
                            @elseif($log->status == 'test')
                                <span class="badge bg-info text-dark">حالت تست</span>
                            @elseif($log->status == 'pending')
                                <span class="badge bg-warning text-dark">در انتظار</span>
                            @elseif($log->status == 'cancelled')
                                <span class="badge bg-secondary">لغو شده</span>
                            @else
                                <span class="badge bg-danger" title="{{ $log->error_message }}">ناموفق</span>
                            @endif
                        </td>
                        <td>{{ $log->created_at->format('Y/m/d H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted">هیچ پیامکی تا به حال ثبت نشده است.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('superadmin.trainees.index') }}" class="btn btn-secondary">بازگشت</a>
        <a href="{{ route('superadmin.trainees.edit', $trainee->id) }}" class="btn btn-warning">ویرایش</a>
    </div>
</div>

@endsection
