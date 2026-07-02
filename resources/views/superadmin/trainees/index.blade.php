@extends('superadmin.layouts.main')

@section('content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>

        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                لیست کارآموزان
            </h5>

            <a href="{{ route('superadmin.trainees.create') }}"
               class="btn btn-sm btn-primary">
                افزودن کارآموز
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle text-center">

                    <thead class="table-light">

                        <tr>
                            <th>#</th>
                            <th>نام و نام خانوادگی</th>
                            <th>دوره</th>
                            <th>شهریه کل</th>
                            <th>تخفیف</th>
                            <th>شهریه نهایی</th>
                            <th>پرداخت شده</th>
                            <th>باقی‌مانده</th>
                            <th width="320">عملیات</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($trainees as $trainee)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="text-nowrap fw-semibold">
                                {{ $trainee->full_name }}
                            </td>

                            <td>
                                {{ $trainee->course->title ?? '—' }}
                            </td>

                            <td>
                                {{ number_format($trainee->total_fee ?? 0) }}
                            </td>

                            <td>

                                {{ number_format($trainee->discount_amount ?? 0) }}

                                <br>

                                <small class="text-muted">
                                    {{ $trainee->discount_percent ?? 0 }}%
                                </small>

                            </td>

                            <td class="fw-bold text-primary">
                                {{ number_format($trainee->final_fee ?? 0) }}
                            </td>

                            <td class="text-success fw-semibold">
                                {{ number_format($trainee->paid_amount ?? 0) }}
                            </td>

                            <td>

                                @if(($trainee->remaining_amount ?? 0) > 0)

                                    <span class="badge bg-danger">
                                        {{ number_format($trainee->remaining_amount) }}
                                    </span>

                                @else

                                    <span class="badge bg-success">
                                        تسویه
                                    </span>

                                @endif

                            </td>

                            <td class="text-nowrap">

                                <div class="d-flex flex-wrap justify-content-center gap-1">

                                    <a href="{{ route('superadmin.trainees.show', $trainee->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                        نمایش
                                    </a>

                                    <a href="{{ route('superadmin.trainees.edit', $trainee->id) }}"
                                       class="btn btn-sm btn-warning text-white">
                                        ویرایش
                                    </a>

                                    <a href="{{ route('superadmin.payments.create', ['trainee_id' => $trainee->id]) }}"
                                       class="btn btn-sm btn-success">
                                        ثبت پرداخت
                                    </a>

                                    <a href="{{ route('superadmin.payments.index', ['trainee_id' => $trainee->id]) }}"
                                       class="btn btn-sm btn-primary">
                                        لیست پرداخت‌ها
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" class="text-muted py-4">

                                هیچ کارآموزی یافت نشد.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $trainees->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
