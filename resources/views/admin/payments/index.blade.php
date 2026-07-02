@extends('admin.layouts.main')

@section('title', 'لیست پرداخت‌ها')
@section('page_title', 'لیست پرداخت‌ها')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">
                پرداخت‌ها 
                @if(isset($filteredTrainee))
                    (فیلتر شده برای: {{ $filteredTrainee->full_name }})
                @endif
            </h5>
            <div class="d-flex gap-2">
                @if(request()->filled('trainee_id'))
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm">
                        پاک کردن فیلتر
                    </a>
                @endif
                <a href="{{ route('admin.payments.create', ['trainee_id' => request('trainee_id')]) }}" class="btn btn-primary btn-sm">
                    ثبت پرداخت جدید
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle mb-0">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th>#</th>
                            <th>کارآموز</th>
                            <th>دوره</th>
                            <th>مبلغ (تومان)</th>
                            <th>روش پرداخت</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration + ($payments->firstItem() - 1) }}</td>
                                <td class="text-nowrap">{{ $payment->trainee->full_name ?? '-' }}</td>
                                <td>{{ $payment->trainee->course->title ?? '-' }}</td>
                                <td class="fw-bold text-success">{{ number_format($payment->amount) }}</td>
                                <td>
                                    @if($payment->payment_method == 'cash')
                                        نقدی
                                    @elseif($payment->payment_method == 'card')
                                        کارت
                                    @elseif($payment->payment_method == 'online')
                                        آنلاین
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $payment->payment_date_shamsi ?? $payment->created_at->format('Y-m-d') }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info text-white">
                                        مشاهده
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-muted">هیچ پرداختی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $payments->links() }}
    </div>
</div>
@endsection
