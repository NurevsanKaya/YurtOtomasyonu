<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Room;
use App\Models\Payment;
use App\Models\ComplaintRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Toplam öğrenci sayısı
        $totalStudents = Student::where('is_active', true)->count();

        // Boş oda sayısı
        $emptyRooms = Room::whereDoesntHave('students')->count();

        // Bekleyen ödemeler
        $pendingPayments = Payment::where('payment_status', 'bekliyor')->count();

        // Son şikayetler
        $recentComplaints = ComplaintRequest::with(['student' => function($query) {
                $query->select('id', 'first_name', 'last_name');
            }])
            ->whereHas('student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Son ödemeler
        $recentPayments = Payment::with(['student' => function($query) {
                $query->select('id', 'first_name', 'last_name');
            }, 'debt'])
            ->whereHas('student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'emptyRooms',
            'pendingPayments',
            'recentComplaints',
            'recentPayments'
        ));
    }
} 