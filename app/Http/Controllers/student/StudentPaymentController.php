<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentPaymentController extends Controller
{
    public function index() {
        $debts = Debt::where('student_id', Auth::user()->student->id)
            ->with(['payments' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->get();

        return view('student.payments.index', compact('debts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'debt_id' => 'required|exists:debts,id',
            'payment_type' => 'required|in:nakit,havale',
            'receipt' => 'required_if:payment_type,havale|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $payment = new Payment();
        $payment->debt_id = $request->debt_id;
        $payment->student_id = Auth::user()->student->id;
        $payment->amount = Debt::find($request->debt_id)->amount;
        $payment->payment_type = $request->payment_type;
        $payment->payment_status = 'bekliyor';
        $payment->due_date = Debt::find($request->debt_id)->due_date;

        if ($request->hasFile('receipt')) {
            $path = $request->file('receipt')->store('payments', 'public');
            $payment->receipt_path = $path;
        }

        $payment->save();

        return redirect()->back()->with('success', 'Ödeme başvurunuz alındı.');
    }

    public function showReceipt($id)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        $path = Storage::disk('public')->path($payment->receipt_path);
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if ($extension === 'pdf') {
            return response()->file($path);
        }

        return response()->file($path);
    }
}
