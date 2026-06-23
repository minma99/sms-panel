<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        @font-face {
            font-family: 'Vazir';
            /* استفاده از base64 برای جلوگیری از خطاهای مسیردهی در سیستم‌عامل‌های مختلف */
            src: url(data:font/ttf;base64,{{ base64_encode(file_get_contents(storage_path('fonts/Vazir.ttf'))) }}) format('truetype');
        }
        body { 
            font-family: 'Vazir', sans-serif; 
            direction: rtl; 
            margin: 20px;
            line-height: 1.6;
        }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .summary { margin-bottom: 25px; padding: 15px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dee2e6; padding: 8px; text-align: center; }
        th { background-color: #e9ecef; }
        .text-danger { color: #dc3545; }
        .text-success { color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h1>گزارش وضعیت مالی کارآموزان</h1>
        <p>تاریخ تهیه: {{ $date ?? date('Y-m-d') }}</p>
    </div>

    <div class="summary">
        <strong>تعداد کل کارآموزان:</strong> {{ $total_trainees }} |
        <strong>کل شهریه:</strong> {{ number_format($total_fee) }} |
        <strong>مجموع پرداخت‌ها:</strong> {{ number_format($total_paid) }} |
        <strong>باقی‌مانده:</strong> {{ number_format($total_remaining) }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ردیف</th><th>نام کارآموز</th><th>کد ملی</th><th>دوره</th><th>شهریه نهایی</th><th>پرداخت</th><th>باقی‌مانده</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trainees as $index => $trainee)
                @php
                    $final_fee = $trainee->total_fee - (($trainee->total_fee * $trainee->discount_percent) / 100);
                    $paid = $trainee->payments->sum('amount');
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $trainee->first_name }} {{ $trainee->last_name }}</td>
                    <td>{{ $trainee->national_code ?? '-' }}</td>
                    <td>{{ $trainee->course->title ?? '-' }}</td>
                    <td>{{ number_format($final_fee) }}</td>
                    <td class="text-success">{{ number_format($paid) }}</td>
                    <td class="text-danger">{{ number_format($final_fee - $paid) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
