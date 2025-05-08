<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::with(['student.user']);

        // Öğrenci filtresi
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        // Durum filtresi
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending':
                    $query->whereNull('visit_approval');
                    break;
                case 'approved':
                    $query->where('visit_approval', true);
                    break;
                case 'rejected':
                    $query->where('visit_approval', false);
                    break;
            }
        }

        // Tarih filtresi
        if ($request->filled('start_date')) {
            $query->whereDate('check_in', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('check_in', '<=', $request->end_date);
        }

        $visitors = $query->latest()->get();
        // Sadece aktif öğrencileri al
        $students = Student::whereHas('user')->with('user')->get();

        return view('admin.Visitor.index', compact('visitors', 'students'));
    }

    public function approve(Visitor $visitor)
    {
        $visitor->update(['visit_approval' => true]);
        return redirect()->back()->with('success', 'Ziyaretçi talebi onaylandı.');
    }

    public function reject(Visitor $visitor)
    {
        $visitor->update(['visit_approval' => false]);
        return redirect()->back()->with('success', 'Ziyaretçi talebi reddedildi.');
    }
}
