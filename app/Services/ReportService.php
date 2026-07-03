<?php

namespace App\Services;

use App\Models\Trainee;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * اعمال فیلترها روی کارآموزان و محاسبه مبالغ مالی
     */
    public function getFinancialReport(array $filters)
    {
        // کوئری پایه به همراه روابط مورد نیاز
        $query = Trainee::with(['course', 'payments'])
            ->withSum('payments', 'amount');

        // ۱. فیلتر بر اساس دوره آموزشی
        if (!empty($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        // ۲. محاسبه شهریه نهایی با اعمال درصد تخفیف به صورت خام در SQL (یا فیلتر وضعیت مالی)
        // وضعیت مالی: بدهکار (debtor) یا تسویه شده (paid)
        if (!empty($filters['status'])) {
            // فرمول محاسبه مانده بدهی کارآموز: (total_fee - (total_fee * discount_percent / 100)) - payments_sum_amount
            $remainingSql = "(total_fee - (total_fee * COALESCE(discount_percent, 0) / 100))";
            
            if ($filters['status'] === 'debtor') {
                $query->where(function($q) use ($remainingSql) {
                    $q->whereRaw("{$remainingSql} > (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.trainee_id = trainees.id)");
                });
            } elseif ($filters['status'] === 'paid') {
                $query->where(function($q) use ($remainingSql) {
                    $q->whereRaw("{$remainingSql} <= (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.trainee_id = trainees.id)");
                });
            }
        }

        // ۳. فیلتر بر اساس بازه تاریخ شمسی پرداخت‌ها
        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query->whereHas('payments', function ($q) use ($filters) {
                $q->whereBetween('payment_date_shamsi', [$filters['from_date'], $filters['to_date']]);
            });
        }

        $trainees = $query->get();

        // محاسبات آماری نهایی برای خلاصه گزارش
        $totalFee = 0;
        $totalPaid = 0;

        foreach ($trainees as $trainee) {
            // محاسبه شهریه پس از اعمال تخفیف
            $discount = ($trainee->total_fee * ($trainee->discount_percent ?? 0)) / 100;
            $finalFee = $trainee->total_fee - $discount;
            $totalFee += $finalFee;

            // مجموع پرداختی‌های ثبت شده کارآموز
            $paid = $trainee->payments_sum_amount ?? 0;
            $totalPaid += $paid;

            // افزودن صفات داینامیک به مدل برای استفاده آسان در View
            $trainee->final_fee = $finalFee;
            $trainee->total_paid = $paid;
            $trainee->remaining_balance = $finalFee - $paid;
        }

        return [
            'trainees'        => $trainees,
            'courses'         => Course::all(),
            'total_trainees'  => $trainees->count(),
            'total_fee'       => $totalFee,
            'total_paid'      => $totalPaid,
            'total_remaining' => $totalFee - $totalPaid,
        ];
    }
}
