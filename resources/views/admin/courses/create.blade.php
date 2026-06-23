@extends('admin.layouts.main')

@section('title','افزودن دوره')
@section('page_title','افزودن دوره')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.courses.store') }}" method="POST">

            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label>عنوان دوره</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title') }}">
                </div>

                <div class="col-md-6">
                    <label>ظرفیت</label>
                    <input type="number"
                           name="capacity"
                           class="form-control"
                           value="{{ old('capacity') }}">
                </div>

            </div>

            <button type="submit" class="btn btn-success mt-3">
                ثبت
            </button>

            <a href="{{ route('admin.courses.index') }}"
               class="btn btn-secondary mt-3">
                بازگشت
            </a>

        </form>

    </div>
</div>

@endsection
