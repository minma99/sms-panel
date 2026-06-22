@extends('superadmin.layouts.main')

@section('title','دوره‌ها')

@section('page_title','مدیریت دوره‌ها')

@section('content')

<div class="bg-white rounded shadow">

    <div class="d-flex justify-content-between align-items-center p-3 border-bottom">

        <h5 class="mb-0">لیست دوره‌ها</h5>

        <a href="{{ route('courses.create') }}"
           class="btn btn-primary">
            افزودن دوره
        </a>

    </div>

    <div class="table-responsive">

        <table class="table table-hover mb-0">

            <thead class="table-light">
                <tr>
                    <th>عنوان دوره</th>
                    <th>ظرفیت</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th width="150">عملیات</th>
                </tr>
            </thead>

            <tbody>

                @forelse($courses as $course)

                <tr>

                    <td>{{ $course->title }}</td>

                    <td>{{ $course->capacity }}</td>

                    <td>{{ $course->start_date_gregorian }}</td>

                    <td>{{ $course->end_date_gregorian }}</td>

                    <td>

                        <a href="{{ route('courses.edit',$course->id) }}"
                           class="btn btn-sm btn-warning">
                            ویرایش
                        </a>

                        <form action="{{ route('courses.destroy',$course->id) }}"
                              method="POST"
                              style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('آیا از حذف این دوره مطمئن هستید؟')">
                                حذف
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="5" class="text-center p-4 text-muted">
                        هیچ دوره‌ای ثبت نشده است
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
