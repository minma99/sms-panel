@extends('admin.layouts.main')

@section('title','دوره‌ها')
@section('page_title','مدیریت دوره‌ها')

@section('content')

<div class="card shadow-sm border-0">

    {{-- Header --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <div>
            <h5 class="mb-0 fw-bold">لیست دوره‌ها</h5>
            <small class="text-muted">
                مدیریت و مشاهده دوره‌های ثبت شده
            </small>
        </div>

        <a href="{{ route('admin.courses.create') }}"
           class="btn btn-primary">

            افزودن دوره
        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))

        <div class="alert alert-success m-3 mb-0">
            {{ session('success') }}
        </div>

    @endif

    {{-- Table --}}
    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>قیمت</th>
                        <th>مدت</th>
                        <th>ظرفیت</th>
                        <th>تاریخ شروع</th>
                        <th>تاریخ پایان</th>
                        <th width="220" class="text-center">عملیات</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($courses as $course)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="fw-semibold">
                                {{ $course->title }}
                            </td>

                            <td>
                                {{ number_format($course->price ?? 0) }}
                            </td>

                            <td>
                                {{ $course->duration ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $course->capacity }}
                                </span>
                            </td>

                            <td>
                                {{ $course->start_date_shamsi ?? '-' }}
                            </td>

                            <td>
                                {{ $course->end_date_shamsi ?? '-' }}
                            </td>

                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- Show --}}
                                    <a href="{{ route('admin.courses.show',$course->id) }}"
                                       class="btn btn-sm btn-info">

                                        مشاهده
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.courses.edit',$course->id) }}"
                                       class="btn btn-sm btn-warning">

                                        ویرایش
                                    </a>
                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center p-4 text-muted">

                                هیچ دوره‌ای ثبت نشده است

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    @if($courses->hasPages())

        <div class="card-footer bg-white">

            {{ $courses->links() }}

        </div>

    @endif

</div>

@endsection
