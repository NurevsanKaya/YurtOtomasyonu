<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Room;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // İstatistikler
        $totalStudents = Student::count();
        $emptyRooms = Room::where('status', 'Boş')->count();
        $pendingPayments = Payment::where('status', 'Beklemede')->count();
        $maintenanceRequests = MaintenanceRequest::where('status', 'Beklemede')->count();

        // Son aktiviteler
        $recentActivities = ActivityLog::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'emptyRooms',
            'pendingPayments',
            'maintenanceRequests',
            'recentActivities'
        ));
    }
} 