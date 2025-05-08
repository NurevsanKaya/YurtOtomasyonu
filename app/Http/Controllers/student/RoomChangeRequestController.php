<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomChangeRequest;
use Illuminate\Support\Facades\Auth;

class RoomChangeRequestController extends Controller
{
    // Boş odaları döndür
    public function availableRooms()
    {
        $rooms = Room::whereColumn('current_occupants', '<', 'capacity')->get();
        return response()->json($rooms);
    }

    // Oda değişikliği talebi oluştur
    public function store(Request $request)
    {
        $request->validate([
            'requested_room_id' => 'required|exists:rooms,id',
        ]);

        $user = Auth::user();
        $student = $user->student;
        if (!$student || !$student->room_id) {
            return response()->json(['error' => 'Önce bir odaya yerleştirilmelisiniz.'], 422);
        }

        // Aynı anda bir aktif talep kontrolü
        $activeRequest = RoomChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if ($activeRequest) {
            return response()->json(['error' => 'Zaten bekleyen bir oda değişikliği talebiniz var.'], 422);
        }

        // Talep edilen oda gerçekten boş mu tekrar kontrol et
        $requestedRoom = Room::findOrFail($request->requested_room_id);
        if ($requestedRoom->current_occupants >= $requestedRoom->capacity) {
            return response()->json(['error' => 'Seçilen oda dolu.'], 422);
        }

        $roomChangeRequest = RoomChangeRequest::create([
            'user_id' => $user->id,
            'current_room_id' => $student->room_id,
            'requested_room_id' => $request->requested_room_id,
            'status' => 'pending',
        ]);

        return response()->json(['success' => 'Oda değişikliği talebiniz iletildi.'], 200);
    }
}
