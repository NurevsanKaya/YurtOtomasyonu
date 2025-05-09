<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomPrice;
use Illuminate\Http\Request;

class RoomPriceController extends Controller
{
    public function index()
    {
        $roomPrices = RoomPrice::orderBy('capacity')->get();
        return view('admin.room-prices.index', compact('roomPrices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        RoomPrice::create($request->only(['capacity', 'price']));

        return redirect()->back()->with('success', 'Oda fiyatı başarıyla eklendi.');
    }

    public function update(Request $request, RoomPrice $roomPrice)
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $roomPrice->update($request->only(['capacity', 'price']));

        return redirect()->back()->with('success', 'Oda fiyatı başarıyla güncellendi.');
    }

    public function destroy(RoomPrice $roomPrice)
    {
        $roomPrice->delete();
        return redirect()->back()->with('success', 'Oda fiyatı başarıyla silindi.');
    }
} 