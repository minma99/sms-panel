@extends('admin.layouts.main')

@section('title','مدیریت دوره‌ها')
@section('page_title','لیست دوره‌ها')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>دوره‌ها</h5>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">افزودن دوره</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>ظرفیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->capacity }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">ویرایش</a>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">حذف</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="text-center">هیچ دوره‌ای موجود نیست</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
