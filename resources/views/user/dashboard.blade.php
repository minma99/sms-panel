<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کارآموز</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; font-family: Tahoma, sans-serif; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .card-header { background: #2c3e50; color: #fff; border-radius: 15px 15px 0 0 !important; font-weight: bold; padding: 15px; }
        .info-label { color: #7f8c8d; font-size: 0.85rem; }
        .info-value { font-weight: 700; color: #2c3e50; }
        .bg-gradient-blue { background: linear-gradient(45deg, #0d6efd, #0dcaf0); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-user-graduate"></i> پنل کاربری</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm"><i class="fas fa-sign-out-alt"></i> خروج</button>
        </form>
    </div>
</nav>

<div class="container py-5">
    @if(!$trainee)
        <div class="alert alert-warning text-center">اطلاعات پرونده شما یافت نشد. با پشتیبانی تماس بگیرید.</div>
    @else
        <div class="row">
            <!-- پروفایل -->
            <div class="col-lg-4">
                <div class="card mb-4 text-center p-3">
                    @if($trainee->image)
                        <img src="{{ asset('storage/'.$trainee->image) }}" class="rounded-circle mb-3 shadow" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;"><i class="fas fa-user fa-3x text-muted"></i></div>
                    @endif
                    <h5>{{ $trainee->first_name }} {{ $trainee->last_name }}</h5>
                    <span class="badge bg-primary">{{ $trainee->course->title ?? 'بدون دوره' }}</span>
                </div>
            </div>

            <!-- وضعیت مالی -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-wallet"></i> وضعیت مالی</div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="info-label">شهریه کل</div>
                                <div class="info-value text-dark">{{ number_format($trainee->total_fee) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">تخفیف</div>
                                <div class="info-value text-warning">{{ number_format($trainee->discount_amount) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">پرداخت‌شده</div>
                                <div class="info-value text-success">{{ number_format($trainee->paid_amount) }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">مانده بدهی</div>
                                <div class="info-value text-danger">{{ number_format($trainee->remaining_amount) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تاریخچه پرداخت‌ها -->
                <div class="card">
                    <div class="card-header"><i class="fas fa-receipt"></i> لیست تراکنش‌ها</div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>مبلغ</th>
                                    <th>تاریخ</th>
                                    <th>روش</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trainee->payments as $payment)
                                    <tr>
                                        <td>{{ number_format($payment->amount) }} تومان</td>
                                        <td>{{ $payment->payment_date_shamsi ?? '-' }}</td>
                                        <td>{{ $payment->payment_method ?? 'نامشخص' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center text-muted">تراکنشی ثبت نشده است</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
