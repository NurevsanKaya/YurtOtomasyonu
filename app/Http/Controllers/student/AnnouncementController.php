<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        // Önce tüm duyuruları alalım
        $announcements = Announcement::all();
        
        // Debug için log'a yazalım
        \Log::info('Tüm Duyurular:', ['count' => $announcements->count(), 'announcements' => $announcements->toArray()]);

        return view('student.announcements.index', compact('announcements'));
    }
}
