@extends('admin.layouts.main')

@section('title','لیست پرداخت‌ها')
@section('page_title','لیست پرداخت‌ها')

@section('content')

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="mb-0">پرداخت‌ها</h5>

<a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
ثبت پرداخت
</a>
</div>

<div class="card-body p-0">

<table class="table table-bordered text-center">

<thead>
<tr>
<th>ID</th>
<th>کارآموز</th>
<th>مبلغ</th>
<th>روش</th>
<th>تاریخ</th>
<th>عملیات</th>
</tr>
</thead>

<tbody>

@foreach($payments as $payment)

<tr>

<td>{{ $payment->id }}</td>
<td>{{ $payment->trainee->name ?? '-' }}</td>
<td>{{ number_format($payment->amount) }}</td>
<td>{{ $payment->payment_method }}</td>
<td>{{ $payment->created_at->format('Y-m-d') }}</td>

<td>

<a href="{{ route('admin.payments.show',$payment->id) }}" class="btn btn-sm btn-info">
مشاهده
</a>

<a href="{{ route('admin.payments.edit',$payment->id) }}" class="btn btn-sm btn-warning">
ویرایش
</a>

<form action="{{ route('admin.payments.destroy',$payment->id) }}" method="POST" style="display:inline">
@csrf
@method('DELETE')

<button class="btn btn-sm btn-danger">
حذف
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

{{ $payments->links() }}

@endsection
