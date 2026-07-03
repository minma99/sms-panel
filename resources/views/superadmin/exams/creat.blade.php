@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 max-w-2xl mx-auto">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary fw-bold">
                {{ isset($prefilled_exam) ? 'معرفی مجدد به آزمون جدید' : 'ثبت آزمون جدید' }}
            </h5>
            @if(isset($prefilled_exam))
                <small class="text-danger">به عنوان آزمون مجدد برای کارآموز: {{ $prefilled_exam->trainee->name }}</small>
            @endif
        </div>
        <div class="card-body">
            <form action="{{ route('superadmin.exams.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">انتخاب کارآموز</label>
                    <select name="trainee_id" class="form-select @error('trainee_id') is-invalid @enderror">
                        <option value="">انتخاب کنید...</option>
                        @foreach($trainees as $trainee)
                            <option value="{{ $trainee->id }}" {{ (old('trainee_id', $selected_trainee) == $trainee->id) ? 'selected' : '' }}>
                                {{ $trainee->name }} (کد ملی: {{ $trainee->national_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('trainee_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">عنوان آزمون</label>
                        <input type="text" name="exam_title" class="form-control @error('exam_title') is-invalid @enderror" value="{{ old('exam_title', $prefilled_exam->exam_title ?? '') }}" required placeholder="مثال: آزمون کتبی فنی حرفه ای">
                        @error('exam_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع آزمون</label>
                        <select name="exam_type" class="form-select @error('exam_type') is-invalid @enderror">
                            <option value="dakheli" {{ old('exam_type', $prefilled_exam->exam_type ?? '') == 'dakheli' ? 'selected' : '' }}>داخلی</option>
                            <option value="fanni-herfei" {{ old('exam_type', $prefilled_exam->exam_type ?? '') == 'fanni-herfei' ? 'selected' : '' }}>فنی و حرفه‌ای</option>
                        </select>
                        @error('exam_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">تاریخ برگزاری</label>
                        <input type="date" name="exam_date" class="form-control @error('exam_date') is-invalid @enderror" value="{{ old('exam_date') }}" required>
                        @error('exam_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">ساعت شروع</label>
                        <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $prefilled_exam->start_time ?? '') }}">
                        @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">ساعت پایان</label>
                        <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $prefilled_exam->end_time ?? '') }}">
                        @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">محل برگزاری</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $prefilled_exam->location ?? '') }}" placeholder="مثال: مرکز شماره یک فنی حرفه‌ای">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">وضعیت آزمون</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در انتظار برگزاری</option>
                            <option value="passed" {{ old('status') == 'passed' ? 'selected' : '' }}>قبول شده</option>
                            <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>مردود</option>
                            <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>غایب</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">توضیحات</label>
                    <textarea name="note" class="form-control" rows="3" placeholder="توضیحات اختیاری...">{{ old('note') }}</textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('superadmin.exams.index') }}" class="btn btn-outline-secondary">انصراف</a>
                    <button type="submit" class="btn btn-primary">ثبت اطلاعات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
