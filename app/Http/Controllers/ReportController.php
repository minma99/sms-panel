<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // ارث‌بری صحیح از کنترلر پایه
use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * نمایش صفحه فیلترها و نتایج گزارش مالی
     */
    public function financial(Request $request)
    {
        $filters = $request->only(['course_id', 'status', 'from_date', 'to_date']);
        
        // دریافت داده‌های فیلتر شده از سرویس
        $data = $this->reportService->getFinancialReport($filters);
        
        // تعیین پیشوند روت جاری برای حفظ ساختار Layout مربوط به پنل ادمین یا سوپرادمین
        $layout = request()->is('superadmin*') ? 'layouts.superadmin' : 'layouts.admin';
        $routePrefix = request()->is('superadmin*') ? 'superadmin' : 'admin';

        return view('reports.financial', array_merge($data, [
            'filters'     => $filters,
            'layout'      => $layout,
            'routePrefix' => $routePrefix
        ]));
    }

    /**
     * خروجی PDF گزارش مالی
     */
    public function exportPdf(Request $request)
    {
        $filters = $request->only(['course_id', 'status', 'from_date', 'to_date']);
        $data = $this->reportService->getFinancialReport($filters);

        // استفاده از کلاس کمکی PDF و لود ویوی مخصوص PDF
        $pdf = Pdf::loadView('reports.pdf', $data)
            ->setOption(['defaultFont' => 'Vazir']);

        return $pdf->download('financial-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * خروجی CSV برای اکسل
     */
    public function exportCsv(Request $request)
    {
        $filters = $request->only(['course_id', 'status', 'from_date', 'to_date']);
        $data = $this->reportService->getFinancialReport($filters);
        $trainees = $data['trainees'];

        $callback = function() use ($trainees) {
            $file = fopen('php://output', 'w');
            // درج BOM برای نمایش صحیح کاراکترهای فارسی در اکسل
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // سرستون‌ها
            fputcsv($file, ['نام و نام خانوادگی', 'دوره آموزشی', 'شهریه نهایی (با تخفیف)', 'کل پرداخت شده', 'مانده بدهی']);

            foreach ($trainees as $trainee) {
                fputcsv($file, [
                    $trainee->name . ' ' . $trainee->family,
                    $trainee->course->title ?? '-',
                    $trainee->final_fee,
                    $trainee->total_paid,
                    $trainee->remaining_balance
                ]);
            }
            fclose($file);
        };

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=financial-report-" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        return response()->stream($callback, 200, $headers);
    }

    /**
     * متد قدیمی دانلود PDF (برای سازگاری با روت قدیمی در صورت وجود در پنل سوپرادمین)
     */
    public function downloadPdf(Request $request)
    {
        return $this->exportPdf($request);
    }
}
