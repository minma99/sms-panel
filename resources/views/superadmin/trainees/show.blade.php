@extends('layouts.superadmin')

@section('title', 'مشاهده کارآموز')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                اطلاعات کارآموز
            </h5>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">نام و نام خانوادگی:</div>
                <div class="col-md-8">
                    {{ $trainee->full_name }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">کد ملی:</div>
                <div class="col-md-8">
                    {{ $trainee->national_code ?? '-' }}
                </div>
            </div>

            {{-- ✅ ستون جدید تلفن --}}
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">تلفن:</div>
                <div class="col-md-8">
                    {{ $trainee->phone ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">ایمیل:</div>
                <div class="col-md-8">
                    {{ $trainee->email ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">تاریخ ثبت:</div>
                <div class="col-md-8">
                    {{ $trainee->created_at ? $trainee->created_at->format('Y/m/d H:i') : '-' }}
                </div>
            </div>

        </div>

        <div class="card-footer text-end">
            <a href="{{ route('superadmin.trainees.index') }}" class="btn btn-secondary">
                بازگشت
            </a>

            <a href="{{ route('superadmin.trainees.edit', $trainee->id) }}" class="btn btn-warning">
                ویرایش
            </a>
        </div>
    </div>

</div>
@endsection
