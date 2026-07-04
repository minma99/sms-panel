<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Trainee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['trainee.course'])
            ->when($request->filled('trainee_id'), function ($query) use ($request) {
                $query->where('trainee_id', $request->trainee_id);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $filteredTrainee = null;

        if ($request->filled('trainee_id')) {
            $filteredTrainee = Trainee::find($request->trainee_id);
        }

        return view('superadmin.payments.index', compact('payments', 'filteredTrainee'));
    }

    public function create(Request $request)
    {
        $trainees = Trainee::with('course')->get();
        $selectedTraineeId = $request->query('trainee_id');

        return view('superadmin.payments.create', compact('trainees', 'selectedTraineeId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
            'tracking_code' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'payment_date_shamsi' => 'nullable|string|max:50',
            'note' => 'nullable|string',
        ]);

        $trainee = Trainee::with('payments')->findOrFail($request->trainee_id);

        $alreadyPaid = $trainee->payments->sum('amount');
        $finalFee = $trainee->final_fee;
        $remainingAfterPayment = max(0, $finalFee - ($alreadyPaid + $request->amount));

        $payment = Payment::create([
            'trainee_id' => $request->trainee_id,
            'amount' => $request->amount,
            'remaining_after_payment' => $remainingAfterPayment,
            'payment_type' => $request->payment_type,
            'payment_method' => $request->payment_method,
            'tracking_code' => $request->tracking_code,
            'payment_date' => $request->payment_date,
            'payment_date_shamsi' => $request->payment_date_shamsi,
            'note' => $request->note,
        ]);

        $smsMessage = "کارآموز گرامی {$trainee->full_name}، مبلغ " . number_format($payment->amount) . " تومان بابت پرداخت شما ثبت شد.";

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('success', 'پرداخت با موفقیت ثبت شد.')
            ->with('show_sms_box', true)
            ->with('sms_message', $smsMessage)
            ->with('sms_context', 'payment_created');
    }

    public function show($id)
    {
        $payment = Payment::with(['trainee.course'])->findOrFail($id);

        return view('superadmin.payments.show', compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $trainees = Trainee::with('course')->get();

        return view('superadmin.payments.edit', compact('payment', 'trainees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:255',
            'tracking_code' => 'nullable|string|max:255',
            'payment_date' => 'nullable|date',
            'payment_date_shamsi' => 'nullable|string|max:50',
            'note' => 'nullable|string',
        ]);

        $payment = Payment::findOrFail($id);
        $trainee = Trainee::with('payments')->findOrFail($request->trainee_id);

        $alreadyPaid = $trainee->payments()
            ->where('id', '!=', $payment->id)
            ->sum('amount');

        $finalFee = $trainee->final_fee;
        $remainingAfterPayment = max(0, $finalFee - ($alreadyPaid + $request->amount));

        $payment->update([
            'trainee_id' => $request->trainee_id,
            'amount' => $request->amount,
            'remaining_after_payment' => $remainingAfterPayment,
            'payment_type' => $request->payment_type,
            'payment_method' => $request->payment_method,
            'tracking_code' => $request->tracking_code,
            'payment_date' => $request->payment_date,
            'payment_date_shamsi' => $request->payment_date_shamsi,
            'note' => $request->note,
        ]);

        $smsMessage = "کارآموز گرامی {$trainee->full_name}، اطلاعات پرداخت شما با موفقیت بروزرسانی شد. مبلغ: " . number_format($request->amount) . " تومان.";

        return redirect()
            ->route('superadmin.trainees.show', $trainee->id)
            ->with('success', 'پرداخت با موفقیت ویرایش شد.')
            ->with('show_sms_box', true)
            ->with('sms_message', $smsMessage)
            ->with('sms_context', 'payment_updated');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $traineeId = $payment->trainee_id;

        $payment->delete();

        return redirect()
            ->route('superadmin.trainees.show', $traineeId)
            ->with('success', 'پرداخت با موفقیت حذف شد.');
    }
}
