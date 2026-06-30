@php
    $fontPath = storage_path('fonts/Vazir.ttf');

    $vazirFont = file_exists($fontPath)
        ? 'data:font/truetype;charset=utf-8;base64,' . base64_encode(file_get_contents($fontPath))
        : null;
@endphp

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">

    <style>

        @if($vazirFont)

        @font-face {
            font-family: "Vazir";
            src: url("{{ $vazirFont }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @endif

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Vazir", "DejaVu Sans", sans-serif;
            direction: rtl;
            margin: 20px;
            line-height: 1.7;
            font-size: 12px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .summary {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            line-height: 2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 11px;
        }

        th {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }

        .empty-message {
            text-align: center;
            padding: 20px;
            color: #777;
        }

    </style>
</head>

<body>

    <div class="header">

        <h1>

            @if(($report_type ?? 'all') === 'monthly')

                گزارش مالی ماهانه کارآموزان

            @elseif(($report_type ?? 'all') === 'range')

                گزارش مالی بازه‌ای کارآموزان

            @else

                گزارش وضعیت مالی کارآموزان

            @endif

        </h1>

        <p>
            تاریخ تهیه:
            {{ $date ?? date('Y-m-d') }}
        </p>

        @if(($report_type ?? 'all') === 'monthly')

            <p>
                ماه گزارش:
                {{ $year }}/{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}
            </p>

        @endif

        @if(($report_type ?? 'all') === 'range')

            <p>
                بازه گزارش:
                از {{ $from_date }}
                تا {{ $to_date }}
            </p>

        @endif

    </div>

    <div class="summary">

        <strong>
            تعداد کارآموزان:
        </strong>

        {{ number_format($total_trainees ?? 0) }}

        |

        <strong>
            مجموع شهریه:
        </strong>

        {{ number_format($total_fee ?? 0) }}

        |

        <strong>
            مجموع پرداخت‌ها:
        </strong>

        {{ number_format($total_paid ?? 0) }}

        |

        <strong>
            باقی‌مانده:
        </strong>

        {{ number_format($total_remaining ?? 0) }}

    </div>

    <table>

        <thead>

            <tr>

                <th>ردیف</th>

                <th>نام کارآموز</th>

                <th>کد ملی</th>

                <th>دوره</th>

                <th>شهریه نهایی</th>

                <th>پرداخت</th>

                <th>باقی‌مانده</th>

            </tr>

        </thead>

        <tbody>

            @forelse($trainees as $index => $trainee)

                @php

                    $totalFee =
                        $trainee->total_fee ?? 0;

                    $discountPercent =
                        $trainee->discount_percent ?? 0;

                    $finalFee =
                        $totalFee -
                        (($totalFee * $discountPercent) / 100);

                    $paid =
                        $trainee->payments->sum('amount');

                    $remaining =
                        $finalFee - $paid;

                @endphp

                <tr>

                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $trainee->full_name ?? ($trainee->first_name . ' ' . $trainee->last_name) }}
                    </td>

                    <td>
                        {{ $trainee->national_code ?? '-' }}
                    </td>

                    <td>
                        {{ $trainee->course->title ?? '-' }}
                    </td>

                    <td>
                        {{ number_format($finalFee) }}
                    </td>

                    <td class="text-success">
                        {{ number_format($paid) }}
                    </td>

                    <td class="text-danger">
                        {{ number_format($remaining) }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="empty-message">

                        هیچ داده‌ای برای این گزارش وجود ندارد.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</body>
</html>
