<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class StudentRoomController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $room = $student && $student->room ? $student->room : null;
        return view('student.room.index', compact('room'));
    }
}
