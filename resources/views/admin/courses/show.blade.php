@extends('admin.layouts.main')

@section('title','مشاهده دوره')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>{{ $course->title }}</h5>
        <p>ظرفیت: {{ $course->capacity }}</p>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">بازگشت</a>
        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-primary">ویرایش</a>
    </div>
</div>
@endsection
