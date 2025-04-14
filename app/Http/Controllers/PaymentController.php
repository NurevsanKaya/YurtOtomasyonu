<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('student')->get();
        $students = Student::all();
        return view('admin.payments.index', compact('payments', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_status' => 'required|in:Ödendi,Beklemede,İptal',
            'payment_type' => 'required|string',
            'due_date' => 'required|date'
        ]);

        Payment::create($validated);

        return redirect()->route('admin.payments')
            ->with('success', 'Ödeme başarıyla eklendi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json($payment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $students = Student::all();
        return view('admin.payments.edit', compact('payment', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_status' => 'required|in:Ödendi,Beklemede,İptal',
            'payment_type' => 'required|string',
            'due_date' => 'required|date'
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments')
            ->with('success', 'Ödeme başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments')
            ->with('success', 'Ödeme başarıyla silindi.');
    }
}
