@extends('superadmin.layouts.main')

@section('title','لیست پرداخت‌ها')
@section('page_title','لیست پرداخت‌ها')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="mb-0">پرداخت‌ها</h5>

<a href="{{ route('payments.create') }}" class="btn btn-primary">
ثبت پرداخت
</a>
</div>

<div class="card-body p-0">

<div class="table-responsive">

<table class="table table-bordered table-hover text-center mb-0">

<thead class="table-light">
<tr>
<th>ID</th>
<th>کارآموز</th>
<th>مبلغ</th>
<th>روش پرداخت</th>
<th>تاریخ</th>
<th width="180">عملیات</th>
</tr>
</thead>

<tbody>

@forelse($payments as $payment)

<tr>

<td>{{ $payment->id }}</td>

<td>{{ $payment->trainee->name ?? '-' }}</td>

<td>{{ number_format($payment->amount) }}</td>

<td>{{ $payment->payment_method ?? '-' }}</td>

<td>{{ $payment->created_at->format('Y-m-d') }}</td>

<td class="d-flex justify-content-center gap-2">

<a href="{{ route('payments.show',$payment->id) }}"
class="btn btn-sm btn-info">
مشاهده
</a>

<a href="{{ route('payments.edit',$payment->id) }}"
class="btn btn-sm btn-warning">
ویرایش
</a>

<form action="{{ route('payments.destroy',$payment->id) }}" method="POST">
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
<td colspan="6" class="text-muted py-4">
پرداختی ثبت نشده
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

<div class="mt-4">
{{ $payments->links() }}
</div>

@endsection
