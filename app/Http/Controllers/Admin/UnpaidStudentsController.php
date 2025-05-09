<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Debt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UnpaidStudentsController extends Controller
{
    public function index()
    {
        // Bir ay önceyi hesapla
        $oneMonthAgo = Carbon::now()->subMonth();

        // Tüm öğrencileri ve borçlarını getir
        $students = Student::with(['debts' => function($query) use ($oneMonthAgo) {
            $query->where('due_date', '<', $oneMonthAgo)
                  ->orderBy('due_date', 'asc');
        }])
        ->whereHas('debts', function($query) use ($oneMonthAgo) {
            $query->where('due_date', '<', $oneMonthAgo);
        })
        ->get();

        // Ödemesi yapılmamış ve yapılmış borçları olan öğrencileri ayır
        $unpaidStudents = $students->filter(function ($student) {
            return $student->debts->where('status', 'unpaid')->count() > 0;
        })->map(function ($student) {
            // Sadece ödenmemiş borçları al
            $unpaidDebts = $student->debts->where('status', 'unpaid');
            
            // Ödenmemiş ayları hesapla
            $unpaidMonths = $unpaidDebts->map(function ($debt) {
                return explode(' Yurt', $debt->description)[0];
            })->implode(', ');

            // Toplam borç tutarını hesapla
            $totalDebt = $unpaidDebts->sum('amount');

            $student->unpaid_months = $unpaidMonths;
            $student->total_debt = $totalDebt;
            $student->oldest_debt_date = $unpaidDebts->min('due_date');
            
            return $student;
        });

        $paidStudents = $students->filter(function ($student) {
            return $student->debts->where('status', 'paid')->count() > 0;
        })->map(function ($student) {
            // Sadece ödenmiş borçları al
            $paidDebts = $student->debts->where('status', 'paid');
            
            // Ödenmiş ayları hesapla
            $paidMonths = $paidDebts->map(function ($debt) {
                return explode(' Yurt', $debt->description)[0];
            })->implode(', ');

            // Toplam ödenen tutarı hesapla
            $totalPaid = $paidDebts->sum('amount');

            $student->paid_months = $paidMonths;
            $student->total_paid = $totalPaid;
            $student->latest_payment_date = $paidDebts->max('updated_at');
            
            return $student;
        });

        return view('admin.unpaid_students.index', compact('unpaidStudents', 'paidStudents'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // Öğrenciyi pasif yap
        $student->is_active = false;
        $student->save();

        return redirect()->back()->with('success', 'Öğrenci başarıyla pasif duruma alındı.');
    }

    public function activate($id)
    {
        $student = Student::findOrFail($id);
        
        // Öğrenciyi aktif yap
        $student->is_active = true;
        $student->save();

        return redirect()->back()->with('success', 'Öğrenci başarıyla aktif duruma alındı.');
    }
} 