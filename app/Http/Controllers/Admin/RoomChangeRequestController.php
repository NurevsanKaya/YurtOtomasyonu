<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomChangeRequest;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RoomChangeRequestController extends Controller
{
    // Tüm talepleri listele
    public function index()
    {
        $requests = RoomChangeRequest::with(['user', 'currentRoom', 'requestedRoom'])->orderBy('created_at', 'desc')->get();
        return view('admin.room_change_requests.index', compact('requests'));
    }

    // Talebi onayla
    public function approve($id)
    {
        $request = RoomChangeRequest::findOrFail($id);
        DB::beginTransaction();
        try {
            // Kapasite kontrolü
            $requestedRoom = Room::findOrFail($request->requested_room_id);
            if ($requestedRoom->current_occupants >= $requestedRoom->capacity) {
                return redirect()->back()->with('error', 'Seçilen oda dolu.');
            }
            // Öğrencinin mevcut odası ve user
            $user = $request->user;
            $student = $user->student;
            $currentRoom = Room::findOrFail($request->current_room_id);
            // Oda güncellemeleri
            $student->room_id = $requestedRoom->id;
            $student->save();
            $user->student->room_id = $requestedRoom->id;
            $user->student->save();
            $currentRoom->decrement('current_occupants');
            $requestedRoom->increment('current_occupants');
            // Talep güncelle
            $request->status = 'approved';
            $request->admin_message = null;
            $request->save();
            DB::commit();
            return redirect()->back()->with('success', 'Oda değişikliği talebi onaylandı.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Bir hata oluştu: ' . $e->getMessage());
        }
    }

    // Talebi reddet
    public function reject(Request $request, $id)
    {
        $requestModel = RoomChangeRequest::findOrFail($id);
        $requestModel->status = 'rejected';
        $requestModel->admin_message = $request->input('admin_message');
        $requestModel->save();
        return redirect()->back()->with('success', 'Talep reddedildi.');
    }
}
