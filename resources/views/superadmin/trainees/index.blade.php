@extends('superadmin.layouts.main')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h5 class="mb-0">لیست کارآموزان</h5>

            <a href="{{ route('superadmin.trainees.create') }}"
               class="btn btn-sm btn-primary">
                <i class="fa fa-plus me-1"></i>
                افزودن کارآموز
            </a>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('superadmin.trainees.index') }}" class="row g-2 align-items-center mb-3">
    <div class="col-12 col-md-6 col-lg-4">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            class="form-control"
            placeholder="جستجو: نام، نام خانوادگی، کد ملی یا موبایل...">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            جستجو
        </button>
        <a href="{{ route('superadmin.trainees.index') }}" class="btn btn-outline-secondary">
            پاک کردن
        </a>
    </div>

    @if(request('q'))
        <div class="col-12">
            <small class="text-muted">
                نتیجه جستجو برای: <strong>{{ request('q') }}</strong>
            </small>
        </div>
    @endif
</form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="min-width: 180px;">کارآموز</th>
                            <th style="min-width: 160px;">دوره</th>
                            <th style="min-width: 160px;">آخرین آزمون</th>
                            <th style="min-width: 130px;">تاریخ آزمون</th>
                            <th style="min-width: 120px;">وضعیت آزمون</th>
                            <th style="min-width: 130px;">شهریه نهایی</th>
                            <th style="min-width: 120px;">پرداخت شده</th>
                            <th style="min-width: 120px;">باقی‌مانده</th>
                            <th style="min-width: 420px;">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($trainees as $trainee)
                        @php
                            $latestExam = $trainee->latestExam;
                            $remaining = $trainee->remaining_amount ?? 0;
                        @endphp

                        <tr>
                            <td>
                                {{ ($trainees->currentPage() - 1) * $trainees->perPage() + $loop->iteration }}
                            </td>

                            <td class="text-nowrap">
                                <div class="fw-semibold">
                                    {{ $trainee->full_name ?? (($trainee->first_name ?? '') . ' ' . ($trainee->last_name ?? '')) }}
                                </div>
                                <small class="text-muted d-block mt-1">
                                    {{ $trainee->phone ?? '—' }}
                                </small>
                            </td>

                            <td>
                                {{ $trainee->course->title ?? '—' }}
                            </td>

                            <td>
                                {{ $latestExam->exam_title ?? '—' }}
                            </td>

                            <td>
                                {{ $latestExam->exam_date ?? '—' }}
                            </td>

                            <td>
                                @if($latestExam)
                                    @if($latestExam->status === 'passed')
                                        <span class="badge bg-success">قبول</span>
                                    @elseif($latestExam->status === 'failed')
                                        <span class="badge bg-danger">مردود</span>
                                    @elseif($latestExam->status === 'absent')
                                        <span class="badge bg-warning text-dark">غایب</span>
                                    @elseif($latestExam->status === 'pending')
                                        <span class="badge bg-secondary">در انتظار</span>
                                    @else
                                        <span class="badge bg-light text-dark">
                                            {{ $latestExam->status }}
                                        </span>
                                    @endif
                                @else
                                    —
                                @endif
                            </td>

                            <td class="fw-bold text-primary">
                                {{ number_format($trainee->final_fee ?? 0) }}
                            </td>

                            <td class="text-success fw-semibold">
                                {{ number_format($trainee->paid_amount ?? 0) }}
                            </td>

                            <td>
                                @if($remaining > 0)
                                    <span class="badge bg-danger">
                                        {{ number_format($remaining) }}
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        تسویه
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-wrap justify-content-center gap-1">

                                    <a href="{{ route('superadmin.trainees.show', $trainee->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                        <i class="fa fa-eye me-1"></i>
                                        نمایش
                                    </a>

                                    <a href="{{ route('superadmin.trainees.edit', $trainee->id) }}"
                                       class="btn btn-sm btn-warning text-white">
                                        <i class="fa fa-edit me-1"></i>
                                        ویرایش
                                    </a>

                                    <a href="{{ route('superadmin.payments.create', ['trainee_id' => $trainee->id]) }}"
                                       class="btn btn-sm btn-success">
                                        <i class="fa fa-credit-card me-1"></i>
                                        ثبت پرداخت
                                    </a>

                                    <a href="{{ route('superadmin.payments.index', ['trainee_id' => $trainee->id]) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fa fa-list me-1"></i>
                                        لیست پرداخت‌ها
                                    </a>

                                    <a href="{{ route('superadmin.exams.index', ['trainee_id' => $trainee->id]) }}"
                                       class="btn btn-sm btn-secondary">
                                        <i class="fa fa-file-alt me-1"></i>
                                        سوابق آزمون
                                    </a>

                                    <a href="{{ route('superadmin.exams.create', ['trainee_id' => $trainee->id]) }}"
                                       class="btn btn-sm btn-dark">
                                        <i class="fa fa-plus me-1"></i>
                                        ثبت آزمون
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-muted py-4 text-center">
                                هیچ کارآموزی یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($trainees->hasPages())
                <div class="mt-3">
                    {{ $trainees->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
