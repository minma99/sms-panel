<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کارآموز</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f4f7f6;
            font-family: Tahoma, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .card-header {
            background: #2c3e50;
            color: #fff;
            border-radius: 15px 15px 0 0 !important;
            font-weight: bold;
            padding: 15px;
        }

        .info-label {
            color: #7f8c8d;
            font-size: 0.85rem;
        }

        .info-value {
            font-weight: 700;
            color: #2c3e50;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }

        .section-title {
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 0;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-user-graduate"></i>
            پنل کاربری
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm" type="submit">
                <i class="fas fa-sign-out-alt"></i>
                خروج
            </button>
        </form>
    </div>
</nav>

<div class="container py-5">

    @if(!$trainee)
        <div class="alert alert-warning text-center">
            اطلاعات پرونده شما یافت نشد.
        </div>
    @else

        <div class="row g-4">

            <!-- پروفایل -->
            <div class="col-lg-4">
                <div class="card text-center p-4">

                    @if(!empty($trainee->image))
                        <img
                            src="{{ asset('storage/' . $trainee->image) }}"
                            class="rounded-circle shadow mx-auto mb-3 profile-image"
                            alt="profile"
                        >
                    @else
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center profile-image">
                            <i class="fas fa-user fa-3x text-muted"></i>
                        </div>
                    @endif

                    <h5 class="fw-bold">
                        {{ $trainee->first_name ?? '' }}
                        {{ $trainee->last_name ?? '' }}
                    </h5>

                    <div class="mt-2">
                        <span class="badge bg-primary">
                            {{ $trainee->course->title ?? 'بدون دوره' }}
                        </span>
                    </div>

                    <hr>

                    <div class="text-end">
                        <div class="mb-2">
                            <span class="info-label">شماره تماس:</span>
                            <div class="info-value">{{ $trainee->phone ?? '-' }}</div>
                        </div>

                        <div class="mb-2">
                            <span class="info-label">کد ملی:</span>
                            <div class="info-value">{{ $trainee->national_code ?? '-' }}</div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- اطلاعات اصلی -->
            <div class="col-lg-8">

                <!-- وضعیت مالی -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-wallet"></i>
                        وضعیت مالی
                    </div>

                    <div class="card-body">
                        <div class="row text-center g-3">

                            <div class="col-6 col-md-3">
                                <div class="info-label">شهریه کل</div>
                                <div class="info-value text-dark">
                                    {{ number_format($trainee->total_fee ?? $trainee->final_fee ?? 0) }}
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="info-label">تخفیف</div>
                                <div class="info-value text-warning">
                                    {{ number_format($trainee->discount_amount ?? 0) }}
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="info-label">پرداخت‌شده</div>
                                <div class="info-value text-success">
                                    {{ number_format($trainee->paid_amount ?? 0) }}
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="info-label">مانده بدهی</div>
                                <div class="info-value text-danger">
                                    {{ number_format($trainee->remaining_amount ?? 0) }}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- لیست پرداخت‌ها -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-receipt"></i>
                        لیست تراکنش‌ها
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>مبلغ</th>
                                        <th>تاریخ</th>
                                        <th>روش پرداخت</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @forelse($trainee->payments ?? [] as $payment)
                                    <tr>
                                        <td class="fw-bold text-success">
                                            {{ number_format($payment->amount ?? 0) }}
                                            تومان
                                        </td>
                                        <td>
                                            {{ $payment->payment_date_shamsi ?? $payment->payment_date ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $payment->payment_method ?? 'نامشخص' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            هیچ تراکنشی ثبت نشده است
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- سوابق آزمون‌ها -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-file-alt"></i>
                        سوابق آزمون‌ها
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>عنوان آزمون</th>
                                        <th>نوع</th>
                                        <th>تاریخ</th>
                                        <th>ساعت</th>
                                        <th>محل</th>
                                        <th>وضعیت</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @forelse($trainee->exams ?? [] as $exam)
                                    <tr>
                                        <td>{{ $exam->exam_title ?? '-' }}</td>

                                        <td>
                                            @php
                                                $examType = $exam->exam_type ?? '';
                                            @endphp

                                            @if($examType === 'fanni-herfei')
                                                <span class="badge bg-info text-dark">فنی و حرفه‌ای</span>
                                            @elseif($examType === 'dakheli')
                                                <span class="badge bg-secondary">داخلی</span>
                                            @elseif($examType === 'miandore')
                                                <span class="badge bg-warning text-dark">میان‌دوره</span>
                                            @elseif($examType === 'payan_dore')
                                                <span class="badge bg-primary">پایان‌دوره</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $examType ?: 'نامشخص' }}</span>
                                            @endif
                                        </td>

                                        <td>{{ $exam->exam_date ?? '-' }}</td>

                                        <td>
                                            {{ $exam->start_time ? substr($exam->start_time, 0, 5) : '-' }}
                                            تا
                                            {{ $exam->end_time ? substr($exam->end_time, 0, 5) : '-' }}
                                        </td>

                                        <td>{{ $exam->location ?? '-' }}</td>

                                        <td>
                                            @php
                                                $status = $exam->status ?? '';
                                            @endphp

                                            @if($status === 'passed')
                                                <span class="badge bg-success">قبول</span>
                                            @elseif($status === 'failed')
                                                <span class="badge bg-danger">مردود</span>
                                            @elseif($status === 'absent')
                                                <span class="badge bg-warning text-dark">غایب</span>
                                            @elseif($status === 'pending')
                                                <span class="badge bg-secondary">در انتظار</span>
                                            @else
                                                <span class="badge bg-light text-dark">{{ $status ?: 'نامشخص' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            هنوز هیچ آزمونی برای شما ثبت نشده است
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
