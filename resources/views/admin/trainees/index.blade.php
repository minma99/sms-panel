@extends('admin.layouts.main')

@section('title','لیست کارآموزان')
@section('page_title','لیست کارآموزان')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">لیست کارآموزان</h5>

            <a href="{{ route('admin.trainees.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus me-1"></i>
                افزودن کارآموز
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="min-width: 180px;">کارآموز</th>
                            <th style="min-width: 160px;">دوره</th>
                            <th style="min-width: 160px;">آخرین آزمون</th>
                            <th style="min-width: 130px;">تاریخ آزمون</th>
                            <th style="min-width: 130px;">نوع آزمون</th>
                            <th style="min-width: 120px;">وضعیت آزمون</th>
                            <th style="min-width: 130px;">شهریه نهایی</th>
                            <th style="min-width: 120px;">پرداخت</th>
                            <th style="min-width: 120px;">مانده</th>
                            <th style="min-width: 340px;">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($trainees as $trainee)
                            @php
                                $latestExam = $trainee->latestExam;
                                $remain = $trainee->remaining_amount ?? 0;
                            @endphp

                            <tr>
                                <td>
                                    {{ ($trainees->currentPage() - 1) * $trainees->perPage() + $loop->iteration }}
                                </td>

                                <td class="text-nowrap">
                                    <div class="fw-bold">
                                        {{ $trainee->first_name }} {{ $trainee->last_name }}
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $trainee->phone ?? '-' }}
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
                                        @switch($latestExam->exam_type)
                                            @case('technical')
                                                فنی حرفه‌ای
                                                @break

                                            @case('internal')
                                                داخلی
                                                @break

                                            @case('midterm')
                                                میان‌دوره
                                                @break

                                            @case('final')
                                                پایان‌دوره
                                                @break

                                            @default
                                                {{ $latestExam->exam_type }}
                                        @endswitch
                                    @else
                                        —
                                    @endif
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

                                <td class="fw-bold">
                                    {{ number_format($trainee->final_fee ?? 0) }}
                                </td>

                                <td class="text-success fw-semibold">
                                    {{ number_format($trainee->paid_amount ?? 0) }}
                                </td>

                                <td>
                                    @if($remain > 0)
                                        <span class="badge bg-danger">
                                            {{ number_format($remain) }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            تسویه
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-1">

                                        <a href="{{ route('admin.trainees.show', $trainee->id) }}"
                                           class="btn btn-info btn-sm text-white">
                                            <i class="fa fa-eye me-1"></i>
                                            نمایش
                                        </a>

                                        @if(auth()->user()->role === 'super_admin')
                                            <a href="{{ route('admin.trainees.edit', $trainee->id) }}"
                                               class="btn btn-warning btn-sm text-white">
                                                <i class="fa fa-edit me-1"></i>
                                                ویرایش
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.payments.create', ['trainee_id' => $trainee->id]) }}"
                                           class="btn btn-success btn-sm">
                                            <i class="fa fa-credit-card me-1"></i>
                                            ثبت پرداخت
                                        </a>

                                        <a href="{{ route('admin.exams.index', ['trainee_id' => $trainee->id]) }}"
                                           class="btn btn-secondary btn-sm">
                                            <i class="fa fa-file-alt me-1"></i>
                                            سوابق آزمون
                                        </a>

                                        <a href="{{ route('admin.exams.create', ['trainee_id' => $trainee->id]) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fa fa-plus me-1"></i>
                                            ثبت آزمون
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    هیچ کارآموزی ثبت نشده است
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
