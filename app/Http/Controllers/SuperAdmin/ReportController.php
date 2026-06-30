<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function downloadPdf(Request $request)
    {
        $type = $request->get('type', 'all');

        if ($type === 'monthly') {

            $year = $request->get('year', now()->year);
            $month = $request->get('month', now()->month);

            $data = $this->reportService
                ->getMonthlyFinancialSummary($year, $month);

        } elseif ($type === 'range') {

            $from = $request->get('from');
            $to = $request->get('to');

            if (!$from || !$to) {
                return back()->with(
                    'error',
                    'برای گزارش بازه‌ای، تاریخ شروع و پایان الزامی است.'
                );
            }

            $data = $this->reportService
                ->getRangeFinancialSummary($from, $to);

        } else {

            $data = $this->reportService
                ->getFinancialSummary();
        }

        $data['date'] = now()->format('Y-m-d');

        $pdf = Pdf::loadView('superadmin.reports.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download(
            'Report_' . now()->format('Y-m-d_H-i-s') . '.pdf'
        );
    }
}
