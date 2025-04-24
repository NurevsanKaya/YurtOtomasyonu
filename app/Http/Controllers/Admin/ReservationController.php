<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Student;
use App\Models\Room;
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

        // Oda seçildi mi kontrolü
        if (!$reservation->room_id) {
            return redirect()->back()->with('error', 'Bu rezervasyonda oda seçilmemiş. Onaylayamazsınız.');
        }

        // Oda dolu mu kontrolü
        $room = Room::findOrFail($reservation->room_id);
        if ($room->current_occupants >= $room->capacity) {
            return redirect()->back()->with('error', 'Seçilen oda dolu. Lütfen önce öğrencinin oda seçimini değiştirin.');
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

        // Odanın doluluk sayısını artır
        $room->current_occupants += 1;
        $room->save();

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