@extends('admin.layouts.main')

@section('title','داشبورد')
@section('page_title','داشبورد مدیریت')

@section('content')

<div class="row g-4 mb-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">تعداد دوره‌ها</h6>
                <h3>{{ $coursesCount }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">کارآموزان</h6>
                <h3>{{ $traineesCount }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">کاربران</h6>
                <h3>{{ $usersCount }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6 class="text-muted">پرداخت‌ها</h6>
                <h3>{{ number_format($paymentsSum) }}</h3>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                کارآموزان اخیر
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>نام کاربری</th>
                            <th>دوره</th>
                            <th>موبایل</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTrainees as $u)
                        <tr>
                            <td>{{ $u->name ?? 'بدون نام' }}</td>
                            <td>{{ $u->trainee->course->title ?? '-' }}</td>
                            <td dir="ltr">{{ $u->phone }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">داده‌ای وجود ندارد</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                پرداخت‌های اخیر
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>کارآموز</th>
                            <th>مبلغ</th>
                            <th>وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                        <tr>
                            <td>
                                {{ $payment->trainee->name ?? ($payment->trainee->user->name ?? '-') }}
                            </td>
                            <td>
                                {{ number_format($payment->amount) }}
                            </td>
                            <td>
                                @if($payment->status == 'completed')
                                    <span class="badge bg-success">موفق</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge bg-warning text-dark">در انتظار</span>
                                @else
                                    <span class="badge bg-danger">ناموفق</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">
                                پرداختی ثبت نشده
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
