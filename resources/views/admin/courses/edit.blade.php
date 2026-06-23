@extends('admin.layouts.main')

@section('title','ویرایش دوره')
@section('page_title','ویرایش دوره')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.courses.update',$course->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label>عنوان دوره</label>

                    <input type="text"
                           name="title"
                           value="{{ old('title',$course->title) }}"
                           class="form-control">
                </div>

                <div class="col-md-6">
                    <label>ظرفیت</label>

                    <input type="number"
                           name="capacity"
                           value="{{ old('capacity',$course->capacity) }}"
                           class="form-control">
                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary mt-3">
                بروزرسانی
            </button>

            <a href="{{ route('admin.courses.index') }}"
               class="btn btn-secondary mt-3">
                بازگشت
            </a>

        </form>

    </div>
</div>

@endsection
