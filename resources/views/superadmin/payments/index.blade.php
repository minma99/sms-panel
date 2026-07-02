@extends('admin.layouts.main')

@section('content')

<div class="container-fluid">

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>

        </div>
    @endif


    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                لیست پرداخت‌ها
            </h5>

            <a href="{{ route('admin.payments.create') }}"
               class="btn btn-sm btn-primary">
                ثبت پرداخت جدید
            </a>

        </div>


        <div class="card-body">

            {{-- اگر فیلتر بر اساس کارآموز فعال باشد --}}
            @if(request('trainee_id'))
                <div class="alert alert-info d-flex justify-content-between align-items-center">

                    <span>
                        در حال نمایش پرداخت‌های:
                        <strong>{{ $filteredTrainee->full_name ?? 'کارآموز انتخاب‌شده' }}</strong>
                    </span>

                    <a href="{{ route('admin.payments.index') }}"
                       class="btn btn-sm btn-secondary">
                        نمایش همه
                    </a>

                </div>
            @endif


            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>کارآموز</th>
                            <th>دوره</th>
                            <th>مبلغ</th>
                            <th>تاریخ پرداخت</th>
                            <th>باقی‌مانده</th>
                            <th>توضیحات</th>
                            <th>تاریخ ثبت</th>
                            <th width="220">عملیات</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($payments as $payment)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="text-nowrap fw-semibold">
                                {{ $payment->trainee->full_name ?? '—' }}
                            </td>

                            <td>
                                {{ $payment->trainee->course->title ?? '—' }}
                            </td>

                            <td class="text-success fw-bold">
                                {{ number_format($payment->amount ?? 0) }}
                            </td>

                            <td>
                                {{ $payment->payment_date_shamsi ?? '—' }}
                            </td>

                            <td>
                                @if(($payment->remaining_amount ?? 0) > 0)
                                    <span class="badge bg-danger">
                                        {{ number_format($payment->remaining_amount) }}
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        تسویه
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $payment->description ?? '—' }}
                            </td>

                            <td>
                                {{ \Morilog\Jalali\Jalalian::fromCarbon($payment->created_at)->format('Y/m/d') }}
                            </td>

                            <td class="text-nowrap">

                                <div class="d-flex justify-content-center gap-1">

                                    <a href="{{ route('admin.payments.show', $payment->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                        نمایش
                                    </a>

                                    <a href="{{ route('admin.payments.edit', $payment->id) }}"
                                       class="btn btn-sm btn-warning text-white">
                                        ویرایش
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-muted py-4">
                                هیچ پرداختی ثبت نشده است
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            <div class="mt-3">
                {{ $payments->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
