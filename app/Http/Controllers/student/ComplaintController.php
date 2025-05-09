<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComplaintRequest;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = ComplaintRequest::where('student_id', Auth::user()->student->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('student.complaint.index', compact('complaints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        ComplaintRequest::create([
            'student_id' => Auth::user()->student->id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'bekliyor'
        ]);

        return redirect()->back()->with('success', 'Şikayetiniz başarıyla gönderildi.');
    }
}
