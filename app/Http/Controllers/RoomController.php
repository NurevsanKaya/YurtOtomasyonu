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
            'room_number' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'floor' => 'required|integer',
            'current_occupants' => 'nullable|integer',
            'room_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

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

        // Veriyi güncelle
        $room->update($request->all());

        // Başarılı bir şekilde güncellenirse index sayfasına yönlendir
        return redirect()->route('rooms.index')->with('success', 'Oda başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
