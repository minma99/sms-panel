<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Trainee;
use App\Models\Course;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['trainee.course', 'trainee.payments'])
            ->latest()
            ->paginate(10);

        return view('superadmin.payments.index', compact('payments'));
    }

    public function create()
    {
        $trainees = Trainee::all();
        $courses = Course::all();

        return view('superadmin.payments.create', compact('trainees', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        Payment::create([
            'trainee_id'  => $request->trainee_id,
            'amount'      => $request->amount,
            'payment_date'=> $request->payment_date ?? now(),
            'status'      => $request->status ?? 'paid',
            'payment_method' => $request->payment_method ?? null,
        ]);

        return redirect()
            ->route('superadmin.payments.index')
            ->with('success', 'پرداخت با موفقیت اضافه شد.');
    }

    public function show($id)
    {
        $payment = Payment::with(['trainee.course', 'trainee.payments'])
            ->findOrFail($id);

        $trainee = $payment->trainee;
        $coursePrice = $trainee->course->price ?? 0;
        $discountAmount = $trainee->discount_amount ?? 0;
        $totalPaidAmount = $trainee->payments->sum('amount');
        $finalFee = $coursePrice - $discountAmount;
        $remainingAmount = max(0, $finalFee - $totalPaidAmount);

        return view('superadmin.payments.show', compact(
            'payment',
            'coursePrice',
            'discountAmount',
            'totalPaidAmount',
            'remainingAmount'
        ));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $trainees = Trainee::all();
        $courses = Course::all();

        return view('superadmin.payments.edit', compact('payment', 'trainees', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        $payment->update([
            'trainee_id'  => $request->trainee_id,
            'amount'      => $request->amount,
            'payment_date'=> $request->payment_date ?? $payment->payment_date,
            'status'      => $request->status ?? $payment->status,
            'payment_method' => $request->payment_method ?? $payment->payment_method,
        ]);

        return redirect()
            ->route('superadmin.payments.index')
            ->with('success', 'پرداخت با موفقیت به‌روزرسانی شد.');
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();

        return redirect()
            ->route('superadmin.payments.index')
            ->with('success', 'پرداخت با موفقیت حذف شد.');
    }
}
