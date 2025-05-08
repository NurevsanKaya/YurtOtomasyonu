<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplaintRequest;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = ComplaintRequest::with('student')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.complaint.index', compact('complaints'));
    }

    public function resolve($id)
    {
        $complaint = ComplaintRequest::findOrFail($id);
        $complaint->update(['status' => 'çözüldü']);

        return redirect()->route('admin.complaint.index')
            ->with('success', 'Şikayet/talep çözüldü olarak işaretlendi.');
    }

    public function reject($id)
    {
        $complaint = ComplaintRequest::findOrFail($id);
        $complaint->update(['status' => 'reddedildi']);

        return redirect()->route('admin.complaint.index')
            ->with('success', 'Şikayet/talep reddedildi.');
    }
} 