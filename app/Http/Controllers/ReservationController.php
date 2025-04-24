<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Rezervasyon formunu göster
     */
    public function index()
    {
        return view('reservation.index');
    }

    /**
     * Rezervasyon kaydını sakla
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'tc' => 'required|string|size:11|unique:reservations,tc',
            'phone' => 'required|string',
            'email' => 'required|email',
            'birth_date' => 'required|date',
            'medical_condition' => 'nullable|string',
            'emergency_contact' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Aynı TC ile öğrenci var mı kontrolü
        $studentExists = Student::where('tc', $request->tc)->exists();
        if ($studentExists) {
            return response()->json(['error' => 'Bu TC kimlik numarası ile kayıtlı bir öğrenci zaten mevcut.'], 422);
        }

        $reservation = Reservation::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'tc' => $request->tc,
            'phone' => $request->phone,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'medical_condition' => $request->medical_condition,
            'emergency_contact' => $request->emergency_contact,
            'registration_date' => now(),
            'status' => 'beklemede',
        ]);

        if ($reservation) {
            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'Bir hata oluştu.'], 500);
    }
} 