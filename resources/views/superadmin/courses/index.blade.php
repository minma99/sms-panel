@extends('superadmin.layouts.main')

@section('title','دوره‌ها')
@section('page_title','مدیریت دوره‌ها')

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="mb-0">لیست دوره‌ها</h5>

<a href="{{ route('superadmin.courses.create') }}" class="btn btn-primary">
افزودن دوره
</a>
</div>

<div class="card-body p-0">

<table class="table table-striped mb-0">

<thead class="table-light">
<tr>
<th>عنوان</th>
<th>قیمت</th>
<th>مدت</th>
<th>ظرفیت</th>
<th>تاریخ شروع</th>
<th>تاریخ پایان</th>
<th width="180">عملیات</th>
</tr>
</thead>

<tbody>

@forelse($courses as $course)

<tr>

<td>{{ $course->title }}</td>

<td>{{ number_format($course->price) }}</td>

<td>{{ $course->duration }}</td>

<td>{{ $course->capacity }}</td>

<td>{{ $course->start_date_shamsi }}</td>
<td>{{ $course->end_date_shamsi }}</td>


<td>

<div class="d-flex gap-2">

<a href="{{ route('superadmin.courses.show',$course->id) }}"
class="btn btn-sm btn-info">
مشاهده
</a>

<a href="{{ route('superadmin.courses.edit',$course->id) }}"
class="btn btn-sm btn-warning">
ویرایش
</a>

<form action="{{ route('superadmin.courses.destroy',$course->id) }}"
method="POST"
onsubmit="return confirm('آیا از حذف این دوره مطمئن هستید؟')">

@csrf
@method('DELETE')

<button type="submit" class="btn btn-sm btn-danger">
حذف
</button>

</form>

</div>

</td>


</tr>

@empty

<tr>
<td colspan="7" class="text-center p-4 text-muted">
هیچ دوره‌ای ثبت نشده است
</td>
</tr>

@endforelse

</tbody>

</table>

</div>
</div>

@endsection
