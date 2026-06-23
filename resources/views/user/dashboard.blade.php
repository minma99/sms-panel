<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کاربر</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: tahoma, sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border: none;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            border-radius: 16px;
        }
        .card-header {
            background: #0d6efd;
            color: #fff;
            border-radius: 16px 16px 0 0 !important;
            font-weight: bold;
        }
        .info-label {
            color: #6c757d;
            font-size: 14px;
        }
        .info-value {
            font-size: 16px;
            font-weight: 600;
        }
        footer {
            margin-top: 40px;
            padding: 20px 0;
            color: #777;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">پنل کاربر</a>
        <div class="ms-auto">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-light btn-sm">خروج</button>
            </form>
        </div>
    </div>
</nav>

<div class="container py-4">

    <div class="mb-4">
        <h3 class="fw-bold">داشبورد کاربر</h3>
        <p class="text-muted mb-0">اطلاعات ثبت‌نام، پرداخت‌ها و فایل‌های شما در این بخش نمایش داده می‌شود.</p>
    </div>

    @if(!$trainee)
        <div class="alert alert-warning">
            اطلاعات کارآموزی برای شما ثبت نشده است.
        </div>
    @else

        <!-- اطلاعات کارآموز -->
        <div class="card mb-4">
            <div class="card-header">اطلاعات کارآموز</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-label">نام و نام خانوادگی</div>
                        <div class="info-value">{{ $trainee->first_name }} {{ $trainee->last_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">نام پدر</div>
                        <div class="info-value">{{ $trainee->father_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">شماره موبایل</div>
                        <div class="info-value">{{ $trainee->phone }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">دوره</div>
                        <div class="info-value">{{ $trainee->course->title ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- عکس -->
        @if($trainee->image)
        <div class="card mb-4">
            <div class="card-header">عکس کارآموز</div>
            <div class="card-body text-center">
                <img src="{{ asset('storage/'.$trainee->image) }}" class="img-fluid rounded" style="max-width: 220px;">
            </div>
        </div>
        @endif

        <!-- فایل -->
        @if($trainee->file)
        <div class="card mb-4">
            <div class="card-header">فایل شما</div>
            <div class="card-body">
                <a href="{{ asset('storage/'.$trainee->file) }}" class="btn btn-primary" download>
                    دانلود فایل
                </a>
            </div>
        </div>
        @endif

        <!-- مالی -->
        <div class="card mb-4">
            <div class="card-header">وضعیت مالی</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-label">شهریه کل</div>
                        <div class="info-value">{{ number_format($totalFee) }} تومان</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">مبلغ تخفیف</div>
                        <div class="info-value">{{ number_format($discount) }} تومان</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">شهریه نهایی</div>
                        <div class="info-value">{{ number_format($finalFee) }} تومان</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">پرداخت شده</div>
                        <div class="info-value text-success">{{ number_format($paid) }} تومان</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">باقی مانده</div>
                        <div class="info-value text-danger">{{ number_format($remaining) }} تومان</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- پرداخت‌ها -->
        <div class="card">
            <div class="card-header">پرداخت‌ها</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
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
                                    <td>{{ $payment->payment_date_shamsi ?? '-' }}</td>
                                    <td>{{ $payment->payment_method ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">پرداختی ثبت نشده</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif
</div>

<footer>
    © {{ date('Y') }} - تمامی حقوق محفوظ است
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
