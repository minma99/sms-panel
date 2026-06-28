content = '''@extends('superadmin.layouts.main')

@section('title','کارآموزان')
@section('page_title','مدیریت کارآموزان')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
        <h5 class="mb-0">لیست همه کارآموزان</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('superadmin.reports.download') }}" class="btn btn-outline-success">
                <i class="fa fa-file-pdf-o"></i> دانلود گزارش PDF
            </a>
            <a href="{{ route('superadmin.trainees.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> افزودن کارآموز
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>نام و نام خانوادگی</th>
                        <th>کد ملی</th>
                        <th>تلفن</th>
                        <th>دوره</th>
                        <th>شهریه کل</th>
                        <th>تخفیف</th>
                        <th>قابل پرداخت</th>
                        <th>پرداخت شده</th>
                        <th>باقی‌مانده</th>
                        <th width="200">عملیات</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($trainees as $trainee)

                        @php
                            $discount_amount = ($trainee->total_fee * $trainee->discount_percent) / 100;
                            $final_fee = $trainee->total_fee - $discount_amount;
                            $paid = $trainee->payments->sum('amount');
                            $remaining = $final_fee - $paid;
                        @endphp

                        <tr>
                            <td class="fw-bold">
                                {{ $trainee->first_name }} {{ $trainee->last_name }}
                            </td>

                            <td>{{ $trainee->national_code }}</td>

                            <td>
                                {{ $trainee->phone ?? '-' }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark">
                                    {{ $trainee->course->title ?? '-' }}
                                </span>
                            </td>

                            <td>{{ number_format($trainee->total_fee) }}</td>

                            <td class="text-secondary">
                                {{ number_format($discount_amount) }}
                                <small>({{ $trainee->discount_percent }}%)</small>
                            </td>

                            <td class="fw-bold">
                                {{ number_format($final_fee) }}
                            </td>

                            <td class="text-success fw-bold">
                                {{ number_format($paid) }}
                            </td>

                            <td class="text-danger fw-bold">
                                {{ number_format($remaining) }}
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <a href="{{ route('superadmin.trainees.show',$trainee->id) }}"
                                       class="btn btn-sm btn-info text-white">
                                       نمایش
                                    </a>

                                    <a href="{{ route('superadmin.trainees.edit',$trainee->id) }}"
                                       class="btn btn-sm btn-warning text-white">
                                       ویرایش
                                    </a>

                                    <a href="{{ route('superadmin.payments.create',['trainee_id'=>$trainee->id]) }}"
                                       class="btn btn-sm btn-success">
                                       پرداخت
                                    </a>

                                    <form action="{{ route('superadmin.trainees.destroy',$trainee->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('آیا مطمئن هستید؟')">

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
                            <td colspan="10" class="text-center p-5 text-muted">
                                هیچ کارآموزی در سیستم ثبت نشده است.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $trainees->links() }}
</div>

@endsection
'''
