@extends('superadmin.layouts.main')

@section('title', 'داشبورد')
@section('page_title', 'داشبورد مدیریت')

@section('content')
<!-- آمار کل -->
<div class="row g-4 mb-4">
    @foreach(['تعداد دوره‌ها' => $coursesCount, 'کارآموزان' => $traineesCount, 'کاربران' => $usersCount, 'جمع پرداخت‌ها' => number_format($paymentsSum)] as $label => $value)
        <div class="col-md-3">
            <div class="card shadow-sm text-center p-3">
                <h6 class="text-muted">{{ $label }}</h6>
                <h3>{{ $value }}</h3>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">کارآموزان اخیر</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>نام</th><th>دوره</th><th>وضعیت</th></tr></thead>
                    <tbody>
                        @foreach($recentTrainees as $trainee)
                        <tr>
                            <td>{{ $trainee->full_name }}</td>
                            <td>{{ $trainee->course->title ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $trainee->registration_status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">پرداخت‌های اخیر</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>کارآموز</th><th>مبلغ</th><th>وضعیت</th></tr></thead>
                    <tbody>
                        @foreach($recentPayments as $payment)
                        <tr>
                            <td>{{ $payment->trainee->full_name ?? 'نامشخص' }}</td>
                            <td>{{ number_format($payment->amount) }}</td>
                            <td>
                                <span class="badge {{ $payment->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $payment->status == 'completed' ? 'موفق' : 'در انتظار' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
