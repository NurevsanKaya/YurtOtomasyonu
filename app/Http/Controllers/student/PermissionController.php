<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index()
    {
        return view('student.permission.index');
    }

    public function store(Request $request)
    {
        // Form verilerini doğrula
        $validated = $request->validate([
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'phone_number' => 'required|string',
            'destination_address' => 'required|string',
        ]);

        // Kullanıcı ID'sini ekle
        $validated['user_id'] = Auth::id();

        // İzin kaydını oluştur
        Permission::create($validated);

        // Başarılı mesajıyla geri dön
        return redirect()->route('student.izin.index')
            ->with('success', 'İzin başvurunuz başarıyla gönderildi.');
    }
}
