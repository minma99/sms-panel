@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">لیست پرداخت‌ها</h5>
            <a href="{{ route('superadmin.payments.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> ثبت پرداخت جدید
            </a>
        </div>
        <div class="card-body">
            {{-- پیام فیلتر --}}
            @if(request('trainee_id'))
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-filter"></i>
                        در حال نمایش پرداخت‌های:
                        <strong>{{ $filteredTrainee->full_name ?? 'کارآموز انتخاب‌شده' }}</strong>
                    </span>
                    <a href="{{ route('superadmin.payments.index') }}" class="btn btn-sm btn-secondary">
                        نمایش همه پرداخت‌ها
                    </a>
                </div>
            @endif

            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>نام کارآموز</th>
                            <th>دوره</th>
                            <th>مبلغ پرداختی</th>
                            <th>تاریخ پرداخت (شمسی)</th>
                            <th>باقی‌مانده</th>
                            <th>توضیحات</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->trainee->full_name ?? '—' }}</td>
                            <td>{{ $payment->trainee->course->title ?? '—' }}</td>
                            <td class="text-success fw-bold">{{ number_format($payment->amount) }} تومان</td>
                            <td>{{ $payment->payment_date_shamsi ?? '—' }}</td>
                            <td class="text-danger">{{ number_format($payment->remaining_amount) }} تومان</td>
                            <td>{{ $payment->description ?? '—' }}</td>
                            <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($payment->created_at)->format('Y/m/d') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('superadmin.payments.edit', $payment->id) }}"
                                       class="btn btn-sm btn-warning text-white" title="ویرایش">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('superadmin.payments.destroy', $payment->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('آیا از حذف این پرداخت مطمئن هستید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">هیچ پرداختی ثبت نشده است.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
