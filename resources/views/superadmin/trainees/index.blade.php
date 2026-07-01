@extends('superadmin.layouts.main')


@section('content')
<div class="container-fluid">
    {{-- نمایش پیام موفقیت (اختیاری) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">لیست کارآموزان</h5>
            <a href="{{ route('superadmin.trainees.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> افزودن کارآموز
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
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
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainees as $trainee)
                        <tr>
                            <td>{{ $loop->iteration }}</td> <!-- استفاده از loop برای شماره‌گذاری ردیف‌ها -->
                            <td class="text-nowrap">{{ $trainee->full_name }}</td>
                            <td>{{ $trainee->course->title ?? '—' }}</td>
                            <td>{{ number_format($trainee->total_fee) }}</td>
                            <td>
                                {{ number_format($trainee->discount_amount) }} 
                                <small class="text-muted">({{ $trainee->discount_percent }}%)</small>
                            </td>
                            <td class="fw-bold">{{ number_format($trainee->final_fee) }}</td>
                            <td class="text-success">{{ number_format($trainee->paid_amount) }}</td>
                            <td class="text-danger fw-bold">{{ number_format($trainee->remaining_amount) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('superadmin.trainees.show', $trainee->id) }}" 
                                       class="btn btn-info text-white" title="نمایش">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('superadmin.trainees.edit', $trainee->id) }}" 
                                       class="btn btn-warning text-white" title="ویرایش">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('superadmin.payments.create', ['trainee_id' => $trainee->id]) }}" 
                                       class="btn btn-success" title="ثبت پرداخت">
                                        <i class="fas fa-money-check-alt"></i>
                                    </a>
                                    <a href="{{ route('superadmin.payments.index', ['trainee_id' => $trainee->id]) }}" 
                                       class="btn btn-primary" title="لیست پرداخت‌ها">
                                        <i class="fas fa-list"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-muted py-4">هیچ کارآموزی یافت نشد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- صفحه بندی --}}
            <div class="mt-3">
                {{ $trainees->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
