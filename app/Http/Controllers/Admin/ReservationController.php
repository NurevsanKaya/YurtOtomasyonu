<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Student;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Rezervasyon listesini göster
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservation.index', compact('reservations'));
    }

    /**
     * Rezervasyonu onayla
     */
    public function approve(Reservation $reservation)
    {
        // Aynı TC ile öğrenci var mı kontrolü
        $studentExists = Student::where('tc', $reservation->tc)->exists();
        if ($studentExists) {
            return redirect()->back()->with('error', 'Bu TC kimlik numarası ile kayıtlı öğrenci zaten var.');
        }

        // Öğrenciyi oluştur
        Student::create([
            'first_name' => $reservation->first_name,
            'last_name' => $reservation->last_name,
            'tc' => $reservation->tc,
            'phone' => $reservation->phone,
            'email' => $reservation->email,
            'address_id' => $reservation->address_id,
            'birth_date' => $reservation->birth_date,
            'registration_date' => now(),
            'room_id' => $reservation->room_id,
            'medical_condition' => $reservation->medical_condition,
            'emergency_contact' => $reservation->emergency_contact,
            'is_active' => true,
        ]);

        // Rezervasyon durumunu güncelle
        $reservation->update([
            'status' => 'onaylandı'
        ]);

        return redirect()->back()->with('success', 'Rezervasyon onaylandı ve öğrenci kaydı oluşturuldu.');
    }

    /**
     * Rezervasyonu reddet
     */
    public function reject(Reservation $reservation)
    {
        $reservation->update([
            'status' => 'reddedildi'
        ]);

        return redirect()->back()->with('success', 'Rezervasyon reddedildi.');
    }
} 