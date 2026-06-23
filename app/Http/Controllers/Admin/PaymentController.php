<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Trainee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

public function index()
{
    $payments = Payment::with('trainee')->latest()->paginate(10);

    return view('admin.payments.index',compact('payments'));
}

public function create()
{
    $trainees = Trainee::all();

    return view('admin.payments.create',compact('trainees'));
}

public function store(Request $request)
{
    $data = $request->validate([
        'trainee_id'=>'required',
        'amount'=>'required|numeric',
        'payment_method'=>'nullable',
        'payment_type'=>'nullable',
        'tracking_code'=>'nullable',
        'payment_date'=>'nullable',
        'payment_date_shamsi'=>'nullable',
        'remaining_after_payment'=>'nullable',
        'note'=>'nullable'
    ]);

    Payment::create($data);

    return redirect()
        ->route('admin.payments.index')
        ->with('success','پرداخت ثبت شد');
}

public function show(Payment $payment)
{
    return view('admin.payments.show',compact('payment'));
}

public function edit(Payment $payment)
{
    $trainees = Trainee::all();

    return view('admin.payments.edit',compact('payment','trainees'));
}

public function update(Request $request, Payment $payment)
{
    $data = $request->validate([
        'trainee_id'=>'required',
        'amount'=>'required|numeric',
        'payment_method'=>'nullable',
        'payment_type'=>'nullable',
        'tracking_code'=>'nullable',
        'payment_date'=>'nullable',
        'payment_date_shamsi'=>'nullable',
        'remaining_after_payment'=>'nullable',
        'note'=>'nullable'
    ]);

    $payment->update($data);

    return redirect()
        ->route('admin.payments.index')
        ->with('success','پرداخت بروزرسانی شد');
}

public function destroy(Payment $payment)
{
    $payment->delete();

    return redirect()
        ->route('admin.payments.index')
        ->with('success','پرداخت حذف شد');
}

}
