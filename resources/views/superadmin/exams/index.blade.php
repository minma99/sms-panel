@extends('superadmin.layouts.main')

@section('page_title', 'لیست آزمون‌ها')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- بخش فیلتر و جستجو -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('superadmin.exams.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label text-muted small">جستجوی کارآموز یا عنوان آزمون</label>
                    <input type="text" name="search" id="search" class="form-control" 
                           value="{{ request('search') }}" placeholder="نام کارآموز، کد ملی یا عنوان آزمون...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label text-muted small">وضعیت آزمون</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                        <option value="passed" {{ request('status') == 'passed' ? 'selected' : '' }}>قبول</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>مردود</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>غایب</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-filter me-1"></i> فیلتر اعمال کن
                    </button>
                    <a href="{{ route('superadmin.exams.index') }}" class="btn btn-outline-secondary w-100">
                        پاک کردن فیلترها
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- جدول لیست آزمون‌ها -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">لیست کل آزمون‌ها</h5>
            <a href="{{ route('superadmin.exams.create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus me-1"></i> ثبت آزمون جدید
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th style="min-width: 180px;">کارآموز</th>
                            <th style="min-width: 180px;">عنوان آزمون</th>
                            <th style="min-width: 130px;">تاریخ آزمون</th>
                            <th style="min-width: 120px;">ساعت برگزاری</th>
                            <th style="min-width: 120px;">مکان</th>
                            <th style="min-width: 110px;">وضعیت</th>
                            <th style="min-width: 180px;">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                            <tr>
                                <td>
                                    {{ ($exams->currentPage() - 1) * $exams->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $exam->trainee->full_name ?? (($exam->trainee->first_name ?? '') . ' ' . ($exam->trainee->last_name ?? '')) }}
                                    </div>
                                    <small class="text-muted d-block">
                                        {{ $exam->trainee->phone ?? '—' }}
                                    </small>
                                </td>
                                <td>{{ $exam->exam_title }}</td>
                                <td>{{ $exam->exam_date }}</td>
                                <td>
                                    @if($exam->start_time)
                                        {{ $exam->start_time }} {{ $exam->end_time ? ' تا ' . $exam->end_time : '' }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $exam->location ?? '—' }}</td>
                                <td>
                                    @if($exam->status === 'passed')
                                        <span class="badge bg-success">قبول</span>
                                    @elseif($exam->status === 'failed')
                                        <span class="badge bg-danger">مردود</span>
                                    @elseif($exam->status === 'absent')
                                        <span class="badge bg-warning text-dark">غایب</span>
                                    @else
                                        <span class="badge bg-secondary">در انتظار</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('superadmin.exams.edit', $exam->id) }}" 
                                           class="btn btn-sm btn-warning text-white">
                                            <i class="fa fa-edit"></i> ویرایش
                                        </a>
                                        <form action="{{ route('superadmin.exams.destroy', $exam->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('آیا از حذف این آزمون مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4 text-center">
                                    هیچ آزمونی ثبت نشده یا یافت نشد.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($exams->hasPages())
                <div class="mt-3">
                    {{ $exams->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
