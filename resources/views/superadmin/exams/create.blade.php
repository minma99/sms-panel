@extends('superadmin.layouts.main')

@section('page_title', 'ثبت آزمون جدید')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ثبت آزمون جدید</h5>
            <a href="{{ route('superadmin.exams.index') }}" class="btn btn-sm btn-secondary">
                بازگشت به لیست
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('superadmin.exams.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <!-- انتخاب کارآموز -->
                    <div class="col-md-6">
                        <label for="trainee_id" class="form-label fw-bold">انتخاب کارآموز <span class="text-danger">*</span></label>
                        <select name="trainee_id" id="trainee_id" class="form-select @error('trainee_id') is-invalid @enderror" required>
                            <option value="">انتخاب کنید...</option>
                            @foreach($trainees as $trainee)
                                <option value="{{ $trainee->id }}" 
                                    {{ (old('trainee_id', $selected_trainee) == $trainee->id) ? 'selected' : '' }}>
                                    {{ $trainee->full_name ?? ($trainee->first_name . ' ' . $trainee->last_name) }} ({{ $trainee->phone ?? 'بدون شماره' }})
                                </option>
                            @endforeach
                        </select>
                        @error('trainee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- عنوان آزمون -->
                    <div class="col-md-6">
                        <label for="exam_title" class="form-label fw-bold">عنوان آزمون <span class="text-danger">*</span></label>
                        <input type="text" name="exam_title" id="exam_title" 
                               class="form-control @error('exam_title') is-invalid @enderror" 
                               value="{{ old('exam_title', $prefilled_exam ? $prefilled_exam->exam_title : '') }}" 
                               placeholder="مثال: آزمون کتبی فنی حرفه‌ای، آزمون نهایی داخلی" required>
                        @error('exam_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- تاریخ آزمون (عرض بزرگتر شده به علت حذف نوع آزمون) -->
                    <div class="col-md-6">
                        <label for="exam_date" class="form-label fw-bold">تاریخ آزمون <span class="text-danger">*</span></label>
                        <input type="text" name="exam_date" id="exam_date" 
                               class="form-control @error('exam_date') is-invalid @enderror" 
                               value="{{ old('exam_date', $prefilled_exam ? $prefilled_exam->exam_date : '') }}" 
                               placeholder="1402/08/15 یا YYYY-MM-DD" required>
                        @error('exam_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- وضعیت آزمون -->
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-bold">وضعیت آزمون <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در انتظار</option>
                            <option value="passed" {{ old('status') == 'passed' ? 'selected' : '' }}>قبول</option>
                            <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>مردود</option>
                            <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>غایب</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ساعت شروع -->
                    <div class="col-md-4">
                        <label for="start_time" class="form-label">ساعت شروع</label>
                        <input type="time" name="start_time" id="start_time" 
                               class="form-control @error('start_time') is-invalid @enderror" 
                               value="{{ old('start_time', $prefilled_exam ? $prefilled_exam->start_time : '') }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ساعت پایان -->
                    <div class="col-md-4">
                        <label for="end_time" class="form-label">ساعت پایان</label>
                        <input type="time" name="end_time" id="end_time" 
                               class="form-control @error('end_time') is-invalid @enderror" 
                               value="{{ old('end_time', $prefilled_exam ? $prefilled_exam->end_time : '') }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- مکان برگزاری -->
                    <div class="col-md-4">
                        <label for="location" class="form-label">مکان برگزاری</label>
                        <input type="text" name="location" id="location" 
                               class="form-control @error('location') is-invalid @enderror" 
                               value="{{ old('location', $prefilled_exam ? $prefilled_exam->location : '') }}" 
                               placeholder="مثال: کارگاه ۱">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- توضیحات -->
                    <div class="col-12">
                        <label for="note" class="form-label">توضیحات / یادداشت</label>
                        <textarea name="note" id="note" rows="3" 
                                  class="form-control @error('note') is-invalid @enderror" 
                                  placeholder="توضیحات اختیاری...">{{ old('note', $prefilled_exam ? $prefilled_exam->note : '') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa fa-save me-1"></i> ثبت آزمون
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
