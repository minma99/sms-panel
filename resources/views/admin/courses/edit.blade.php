@extends('admin.layouts.main')

@section('title','ویرایش دوره')
@section('page_title','ویرایش دوره')

@section('content')
<div class="bg-white p-6 rounded-xl shadow max-w-3xl">
    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label>عنوان دوره</label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" class="form-control">
            </div>
            <div>
                <label>ظرفیت</label>
                <input type="number" name="capacity" value="{{ old('capacity', $course->capacity) }}" class="form-control">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn btn-primary">بروزرسانی</button>
            <a href="{{ route('courses.index') }}" class="btn btn-secondary">بازگشت</a>
        </div>
    </form>
</div>
@endsection
