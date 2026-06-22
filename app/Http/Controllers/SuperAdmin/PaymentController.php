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
        $payments = Payment::with('trainee')
            ->latest()
            ->paginate(10);

        return view('superadmin.payments.index', compact('payments'));
    }

    public function create()
    {
        $trainees = Trainee::all();

        return view('superadmin.payments.create', compact('trainees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'trainee_id' => 'required|exists:trainees,id',

            'amount' => 'required|numeric|min:0',

            'payment_type' => 'nullable|in:full,installment',

            'payment_method' => 'nullable|in:cash,card,online',

            'tracking_code' => 'nullable|string|max:255',

            'payment_date' => 'nullable|date',

            'payment_date_shamsi' => 'nullable|string|max:50',

            'remaining_after_payment' => 'nullable|numeric|min:0',

            'note' => 'nullable|string'

        ]);

        Payment::create($data);

        return redirect()
            ->route('payments.index')
            ->with('success','پرداخت ثبت شد');
    }

    public function show($id)
    {
        $payment = Payment::with('trainee')->findOrFail($id);

        return view('superadmin.payments.show',compact('payment'));
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        $trainees = Trainee::all();

        return view('superadmin.payments.edit',
            compact('payment','trainees'));
    }

    public function update(Request $request,$id)
    {
        $payment = Payment::findOrFail($id);

        $data = $request->validate([

            'trainee_id'=>'required|exists:trainees,id',

            'amount'=>'required|numeric|min:0',

            'payment_type'=>'nullable|in:full,installment',

            'payment_method'=>'nullable|in:cash,card,online',

            'tracking_code'=>'nullable|string|max:255',

            'payment_date'=>'nullable|date',

            'payment_date_shamsi'=>'nullable|string|max:50',

            'remaining_after_payment'=>'nullable|numeric|min:0',

            'note'=>'nullable|string'

        ]);

        $payment->update($data);

        return redirect()
            ->route('payments.index')
            ->with('success','پرداخت بروزرسانی شد');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->delete();

        return redirect()
            ->route('payments.index')
            ->with('success','پرداخت حذف شد');
    }
}
