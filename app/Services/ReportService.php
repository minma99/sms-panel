<?php

namespace App\Services;

use App\Models\Trainee;
use Carbon\Carbon;

class ReportService
{
    /**
     * گزارش کلی
     */
    public function getFinancialSummary()
    {
        $trainees = Trainee::with([
            'payments',
            'course'
        ])->get();

        $totalFinalFee = 0;
        $totalPaid = 0;

        foreach ($trainees as $trainee) {

            $finalFee = $this->getFinalFee($trainee);
            $paid = $trainee->payments->sum('amount');

            $totalFinalFee += $finalFee;
            $totalPaid += $paid;
        }

        return [
            'report_type' => 'all',

            'total_trainees' => $trainees->count(),

            'total_fee' => $totalFinalFee,

            'total_paid' => $totalPaid,

            'total_remaining' => $totalFinalFee - $totalPaid,

            'trainees' => $trainees,
        ];
    }

    /**
     * گزارش ماهانه
     */
    public function getMonthlyFinancialSummary($year, $month)
    {
        $startDate = Carbon::createFromDate(
            $year,
            $month,
            1
        )->startOfMonth();

        $endDate = Carbon::createFromDate(
            $year,
            $month,
            1
        )->endOfMonth();

        $trainees = Trainee::with([

            'course',

            'payments' => function ($query) use (
                $startDate,
                $endDate
            ) {
                $query->whereBetween(
                    'created_at',
                    [$startDate, $endDate]
                );
            }

        ])
        ->whereHas('payments', function ($query) use (
            $startDate,
            $endDate
        ) {
            $query->whereBetween(
                'created_at',
                [$startDate, $endDate]
            );
        })
        ->get();

        $totalFinalFee = 0;
        $totalPaid = 0;

        foreach ($trainees as $trainee) {

            $finalFee = $this->getFinalFee($trainee);

            $paid = $trainee->payments->sum('amount');

            $totalFinalFee += $finalFee;
            $totalPaid += $paid;
        }

        return [

            'report_type' => 'monthly',

            'year' => $year,
            'month' => $month,

            'from_date' => $startDate->format('Y-m-d'),
            'to_date' => $endDate->format('Y-m-d'),

            'total_trainees' => $trainees->count(),

            'total_fee' => $totalFinalFee,

            'total_paid' => $totalPaid,

            'total_remaining' => $totalFinalFee - $totalPaid,

            'trainees' => $trainees,
        ];
    }

    /**
     * گزارش بازه‌ای
     */
    public function getRangeFinancialSummary($from, $to)
    {
        $startDate = Carbon::parse($from)->startOfDay();
        $endDate = Carbon::parse($to)->endOfDay();

        $trainees = Trainee::with([

            'course',

            'payments' => function ($query) use (
                $startDate,
                $endDate
            ) {
                $query->whereBetween(
                    'created_at',
                    [$startDate, $endDate]
                );
            }

        ])
        ->whereHas('payments', function ($query) use (
            $startDate,
            $endDate
        ) {
            $query->whereBetween(
                'created_at',
                [$startDate, $endDate]
            );
        })
        ->get();

        $totalFinalFee = 0;
        $totalPaid = 0;

        foreach ($trainees as $trainee) {

            $finalFee = $this->getFinalFee($trainee);

            $paid = $trainee->payments->sum('amount');

            $totalFinalFee += $finalFee;
            $totalPaid += $paid;
        }

        return [

            'report_type' => 'range',

            'from_date' => $startDate->format('Y-m-d'),
            'to_date' => $endDate->format('Y-m-d'),

            'total_trainees' => $trainees->count(),

            'total_fee' => $totalFinalFee,

            'total_paid' => $totalPaid,

            'total_remaining' => $totalFinalFee - $totalPaid,

            'trainees' => $trainees,
        ];
    }

    /**
     * محاسبه شهریه نهایی
     */
    private function getFinalFee($trainee)
    {
        $totalFee = $trainee->total_fee ?? 0;

        $discountPercent =
            $trainee->discount_percent ?? 0;

        return $totalFee -
            (($totalFee * $discountPercent) / 100);
    }
}
