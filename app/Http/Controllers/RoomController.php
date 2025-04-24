<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all(); // Veritabanından tüm odaları alıyoruz.
        return view('admin.rooms.index', compact('rooms')); // rooms değişkenini şablona gönderiyoruz.
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms',
            'capacity' => 'required|integer|min:1',
            'floor' => 'required|integer',
            'room_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        // Current occupants değerini otomatik olarak 0 ayarlayalım
        $validatedData['current_occupants'] = 0;

        Room::create($validatedData);

        return redirect()->route('admin.rooms.index')->with('success', 'Oda başarıyla eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // İlgili oda kaydını bul
        $room = Room::findOrFail($id);
        
        // Doğrulama
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $id,
            'capacity' => 'required|integer|min:' . $room->current_occupants, // Kapasite mevcut doluluktan az olamaz
            'floor' => 'required|integer',
            'room_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
        
        // current_occupants kullanıcı tarafından değiştirilirse eski değerini koru
        $validatedData['current_occupants'] = $room->current_occupants;

        // Veriyi güncelle
        $room->update($validatedData);

        // Başarılı bir şekilde güncellenirse index sayfasına yönlendir
        return redirect()->route('admin.rooms.index')->with('success', 'Oda başarıyla güncellendi.');
    }
    
    /**
     * Boş odaları JSON formatında döndürür
     */
    public function getAvailableRooms()
    {
        $availableRooms = Room::whereRaw('current_occupants < capacity')->get();
        return response()->json($availableRooms);
    }

    /**
     * Odanın doluluk sayısını artırır
     */
    public function incrementOccupants($id)
    {
        $room = Room::findOrFail($id);
        
        // Odanın doluluk kontrolü
        if ($room->current_occupants >= $room->capacity) {
            return response()->json([
                'success' => false,
                'message' => 'Bu oda dolu, daha fazla öğrenci eklenemez.'
            ], 422);
        }
        
        // Doluluk sayısını artır
        $room->current_occupants += 1;
        $room->save();
        
        return response()->json([
            'success' => true,
            'current_occupants' => $room->current_occupants,
            'capacity' => $room->capacity
        ]);
    }
    
    /**
     * Odanın doluluk sayısını azaltır
     */
    public function decrementOccupants($id)
    {
        $room = Room::findOrFail($id);
        
        // Odada öğrenci var mı kontrolü
        if ($room->current_occupants <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Bu odada zaten öğrenci bulunmuyor.'
            ], 422);
        }
        
        // Doluluk sayısını azalt
        $room->current_occupants -= 1;
        $room->save();
        
        return response()->json([
            'success' => true,
            'current_occupants' => $room->current_occupants,
            'capacity' => $room->capacity
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // Oda dolu ise silme işlemi yapılmasın
        if ($room->current_occupants > 0) {
            return back()->with('error', 'Bu odada öğrenciler var, silmeden önce öğrencileri başka odalara aktarmanız gerekiyor.');
        }
        
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Oda başarıyla silindi.');
    }
}
