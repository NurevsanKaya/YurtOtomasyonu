<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Bugünün tarihini al
        $today = now()->startOfDay();

        // Son tarihi geçmemiş duyuruları getir
        $announcements = Announcement::where('end_date', '>=', $today)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Debug için log'a yazalım
        \Log::info('Aktif Duyurular:', ['count' => $announcements->count(), 'announcements' => $announcements->toArray()]);

        return view('student.announcements.index', compact('announcements'));
    }
}
