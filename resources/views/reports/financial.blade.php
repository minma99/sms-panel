@extends($layout)

@section('content')
<div class="container-fluid my-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i> گزارش‌گیری مالی کارآموزان</h5>
            <div>
                <!-- دکمه‌های دریافت خروجی -->
                <a href="{{ route($routePrefix . '.reports.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf me-1"></i> دانلود PDF
                </a>
                <a href="{{ route($routePrefix . '.reports.csv', request()->query()) }}" class="btn btn-success btn-sm ms-2">
                    <i class="fas fa-file-excel me-1"></i> خروجی CSV (Excel)
                </a>
            </div>
        </div>
        <div class="card-body bg-light">
            <!-- فرم فیلترهای پیشرفته -->
            <form method="GET" action="{{ route($routePrefix . '.reports.financial') }}" class="row g-3 align-items-end mb-4">
                <div class="col-md-3">
                    <label class="form-label font-weight-bold">انتخاب دوره آموزشی</label>
                    <select name="course_id" class="form-select">
                        <option value="">همه دوره‌ها</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" @selected(request('course_id') == $course->id)>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label font-weight-bold">وضعیت تسویه مالی</label>
                    <select name="status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="debtor" @selected(request('status') == 'debtor')>بدهکار</option>
                        <option value="paid" @selected(request('status') == 'paid')>تسویه شده</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label font-weight-bold">از تاریخ (شمسی)</label>
                    <input type="text" name="from_date" class="form-control shamsi-datepicker" placeholder="۱۴۰۲/۰۱/۰۱" value="{{ request('from_date') }}" autocomplete="off">
                </div>
                <div class="col-md-2">
                    <label class="form-label font-weight-bold">تا تاریخ (شمسی)</label>
                    <input type="text" name="to_date" class="form-control shamsi-datepicker" placeholder="۱۴۰۲/۱۲/۲۹" value="{{ request('to_date') }}" autocomplete="off">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i> اعمال فیلتر</button>
                </div>
            </form>

            <hr>

            <!-- باکس‌های آماری خلاصه مالی -->
            <div class="row text-center mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-white p-3">
                        <h6 class="text-muted">تعداد کارآموزان فیلتر شده</h6>
                        <h3 class="text-primary font-weight-bold">{{ number_format($total_trainees) }} نفر</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-white p-3">
                        <h6 class="text-muted">مجموع شهریه‌های نهایی</h6>
                        <h3 class="text-success font-weight-bold">{{ number_format($total_fee) }} ریال</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-white p-3">
                        <h6 class="text-muted">مجموع پرداختی کارآموزان</h6>
                        <h3 class="text-info font-weight-bold">{{ number_format($total_paid) }} ریال</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm bg-white p-3">
                        <h6 class="text-muted">کل مانده بدهی معوقه</h6>
                        <h3 class="text-danger font-weight-bold">{{ number_format($total_remaining) }} ریال</h3>
                    </div>
                </div>
            </div>

            <!-- جدول جزئیات کارآموزان -->
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">#</th>
                            <th>نام و نام خانوادگی</th>
                            <th>دوره آموزشی</th>
                            <th class="text-center">شهریه نهایی (با تخفیف)</th>
                            <th class="text-center">کل پرداخت شده</th>
                            <th class="text-center">باقی‌مانده</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainees as $trainee)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $trainee->name }} {{ $trainee->family }}</strong></td>
                                <td>{{ $trainee->course->title ?? '-' }}</td>
                                <td class="text-center text-secondary">{{ number_format($trainee->final_fee) }} ریال</td>
                                <td class="text-center text-success">{{ number_format($trainee->total_paid) }} ریال</td>
                                <td class="text-center text-danger font-weight-bold">
                                    {{ number_format($trainee->remaining_balance) }} ریال
                                </td>
                                <td class="text-center">
                                    @if($trainee->remaining_balance <= 0)
                                        <span class="badge bg-success-light text-success px-3 py-2 rounded-pill">تسویه</span>
                                    @else
                                        <span class="badge bg-danger-light text-danger px-3 py-2 rounded-pill">بدهکار</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">اطلاعاتی با فیلترهای اعمال شده یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
