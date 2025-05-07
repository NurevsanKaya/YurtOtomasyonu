<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class StudentVisitorController extends Controller
{
    // 1. Ziyaretçi taleplerini listeleme (index)
    public function index()
    {
        $studentId = auth()->user()->student->id;
        $visitors = Visitor::where('student_id', $studentId)->latest()->get();

        return view('student.visitor.index', compact('visitors'));
    }

    // 2. Yeni talep formu gösterme (create)
    public function create()
    {
        return view('student.visitors.create');
    }

    // 3. Yeni talep verisini kaydetme (store)
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'tc' => 'nullable|digits:11',
            'address' => 'nullable|string',
            'visit_reason' => 'nullable|string',
        ]);

        Visitor::create([
            'student_id' => auth()->user()->student->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'tc' => $request->tc,
            'address' => $request->address,
            'visit_reason' => $request->visit_reason,
            'check_in' => now(),
        ]);

        return redirect()->route('student.visitors.index')->with('success', 'Ziyaretçi talebiniz gönderildi.');
    }
}
