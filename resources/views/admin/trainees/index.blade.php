@extends('admin.layouts.main')

@section('title','کارآموزان')
@section('page_title','لیست کارآموزان')

@section('content')

<div class="container-fluid">

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
                لیست کارآموزان
            </h5>

            <a href="{{ route('admin.trainees.create') }}"
               class="btn btn-primary btn-sm">
                افزودن کارآموز
            </a>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle text-center">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>دوره</th>
                            <th>شهریه</th>
                            <th>تخفیف</th>
                            <th>شهریه نهایی</th>
                            <th>پرداخت</th>
                            <th>باقی‌مانده</th>
                            <th width="260">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($trainees as $trainee)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td class="text-nowrap fw-semibold">
                                {{ $trainee->first_name }} {{ $trainee->last_name }}
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

                                <div class="d-flex justify-content-center gap-1">

                                    <a href="{{ route('admin.trainees.show',$trainee->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                        نمایش
                                    </a>

                                    <a href="{{ route('admin.trainees.edit',$trainee->id) }}"
                                       class="btn btn-sm btn-warning text-white">
                                        ویرایش
                                    </a>

                                    <a href="{{ route('admin.payments.create',['trainee_id'=>$trainee->id]) }}"
                                       class="btn btn-sm btn-success">
                                        ثبت پرداخت
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                کارآموزی ثبت نشده است
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
