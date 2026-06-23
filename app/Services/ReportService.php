<?php

namespace App\Services;

use App\Models\Trainee;

class ReportService {
    /**
     * محاسبات مالی برای گزارش‌گیری
     */
    public function getFinancialSummary() {
        // گرفتن تمام کارآموزان به همراه پرداخت‌هایشان
        $trainees = Trainee::with('payments')->get();

        $totalFee = $trainees->sum('total_fee');
        $totalPaid = 0;

        foreach ($trainees as $trainee) {
            $totalPaid += $trainee->payments->sum('amount');
        }
        
        return [
            'total_trainees' => $trainees->count(),
            'total_fee' => $totalFee,
            'total_paid' => $totalPaid,
            'total_remaining' => $totalFee - $totalPaid,
            'trainees' => $trainees
        ];
    }
}
