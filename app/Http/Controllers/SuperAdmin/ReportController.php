<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    // تزریق سرویس در سازنده کلاس
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function downloadPdf()
    {
        // دریافت داده‌های محاسباتی از سرویس
        $data = $this->reportService->getFinancialSummary();
        
        // اضافه کردن تاریخ روز
        $data['date'] = date('Y-m-d');

        // تولید PDF با ویوی مشخص شده
        $pdf = Pdf::loadView('superadmin.reports.pdf', $data)
                  ->setPaper('a4', 'portrait');

        // دانلود فایل
        return $pdf->download('Report_' . date('Y-m-d') . '.pdf');
    }
}
