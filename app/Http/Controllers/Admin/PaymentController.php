<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with(['student', 'debt'])
            ->whereHas('student')
            ->whereHas('debt')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payments.index', compact('payments'));
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
            'due_date' => 'required|date'
        ]);

        // Ödeme durumu ve türünü otomatik olarak ekle
        $validated['payment_status'] = 'Ödendi';
        $validated['payment_type'] = 'Nakit';

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
            'due_date' => 'required|date'
        ]);

        // Ödeme durumu ve türünü otomatik olarak ekle
        $validated['payment_status'] = 'Ödendi';
        $validated['payment_type'] = 'Nakit';

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

    public function approve($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->payment_status = 'onaylandı';
        $payment->save();

        if ($payment->debt) {
            $debt = $payment->debt;
            $totalPaid = Payment::where('debt_id', $debt->id)
                ->where('payment_status', 'onaylandı')
                ->sum('amount');

            if ($totalPaid >= $debt->amount) {
                $debt->status = 'paid';
            } else {
                $debt->status = 'unpaid';
            }
            $debt->save();
        }

        return redirect()->back()->with('success', 'Ödeme onaylandı.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);

        $payment = Payment::findOrFail($id);
        $payment->payment_status = 'reddedildi';
        $payment->rejection_reason = $request->rejection_reason;
        $payment->save();

        return redirect()->back()->with('success', 'Ödeme reddedildi.');
    }

    public function showReceipt($id)
    {
        $payment = Payment::findOrFail($id);
        $path = Storage::disk('public')->path($payment->receipt_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension === 'pdf') {
            return response()->file($path);
        }

        return response()->file($path);
    }
}
