<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.payments.index', compact('payments', 'filteredTrainee'));
    }

    public function create(Request $request)
    {
        $trainees = Trainee::with('course')->get();
        $selectedTrainee = $request->query('trainee_id');

        return view('admin.payments.create', compact('trainees', 'selectedTrainee'));
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

        Payment::create([
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

        return redirect()
            ->route('admin.payments.index', ['trainee_id' => $request->trainee_id])
            ->with('success', 'پرداخت با موفقیت ثبت شد.');
    }

    public function show($id)
    {
        $payment = Payment::with(['trainee.course'])->findOrFail($id);

        return view('admin.payments.show', compact('payment'));
    }
}
