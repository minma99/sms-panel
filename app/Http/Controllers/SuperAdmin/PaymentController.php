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
        $request->validate([
            'trainee_id' => 'required|exists:trainees,id',
            'amount' => 'required|numeric',
            'payment_method' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        Payment::create($request->all());

        return redirect()->route('payments.index');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->delete();

        return redirect()->route('payments.index');
    }
}
