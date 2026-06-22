@extends('superadmin.layouts.main')


@section('title','کارآموزان')
@section('page_title','لیست کارآموزان')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

<h4>همه کارآموزان</h4>

<a href="{{ route('trainees.create') }}" class="btn btn-primary">
افزودن کارآموز
</a>

</div>

<div class="card shadow-sm">

<div class="table-responsive">

<table class="table table-bordered table-hover mb-0">

<thead class="table-light">

<tr>
<th>ID</th>
<th>نام</th>
<th>کد ملی</th>
<th>تلفن</th>
<th>دوره</th>
<th>وضعیت</th>
<th width="180">عملیات</th>
</tr>

</thead>

<tbody>

@forelse($trainees as $trainee)

<tr>

<td>{{ $trainee->id }}</td>

<td>
{{ $trainee->first_name }} {{ $trainee->last_name }}
</td>

<td>{{ $trainee->national_code }}</td>

<td>{{ $trainee->phone }}</td>

<td>
{{ $trainee->course->title ?? '-' }}
</td>

<td>{{ $trainee->registration_status }}</td>

<td>

<a href="{{ route('trainees.show',$trainee->id) }}"
class="btn btn-sm btn-info">
نمایش
</a>

<a href="{{ route('trainees.edit',$trainee->id) }}"
class="btn btn-sm btn-warning">
ویرایش
</a>

<form action="{{ route('trainees.destroy',$trainee->id) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger"
onclick="return confirm('حذف شود؟')">
حذف
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center p-4">
هیچ کارآموزی ثبت نشده
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="mt-4">
{{ $trainees->links() }}
</div>

@endsection
