<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Trainee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['trainee.course'])
            ->latest()
            ->paginate(10);

        return view('superadmin.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $trainees = Trainee::with('payments')->get();

        $selectedTrainee = $request->trainee_id;

        return view('superadmin.payments.create', compact(
            'trainees',
            'selectedTrainee'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        Payment::create([
            'trainee_id'   => $request->trainee_id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date ?? now(),
            'status'       => $request->status ?? 'paid',
            'payment_method' => $request->payment_method,
            'tracking_code' => $request->tracking_code,
            'note' => $request->note,
        ]);

        return redirect()
            ->route('superadmin.payments.index')
            ->with('success', 'پرداخت با موفقیت ثبت شد.');
    }

    public function show($id)
    {
        $payment = Payment::with(['trainee.course', 'trainee.payments'])
            ->findOrFail($id);

        return view('superadmin.payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $trainees = Trainee::all();

        return view('superadmin.payments.edit', compact('payment', 'trainees'));
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
            'trainee_id'   => $request->trainee_id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date ?? $payment->payment_date,
            'status'       => $request->status ?? $payment->status,
            'payment_method' => $request->payment_method,
            'tracking_code' => $request->tracking_code,
            'note' => $request->note,
        ]);

        return redirect()
            ->route('superadmin.payments.index')
            ->with('success', 'پرداخت بروزرسانی شد.');
    }

    public function destroy($id)
    {
        Payment::findOrFail($id)->delete();

        return redirect()
            ->route('superadmin.payments.index')
            ->with('success', 'پرداخت حذف شد.');
    }
}
