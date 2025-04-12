<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class StudentPaymentController extends Controller
{
    public function index() {
        $payments = Payment::where('student_id', Auth::id())->get();
        return view('student.payment.index', compact('payments'));
    }

}
