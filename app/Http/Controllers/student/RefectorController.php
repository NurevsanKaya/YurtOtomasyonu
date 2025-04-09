<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefectorController extends Controller
{
    public function index()
    {
        return view('student.refector.index');
    }
}
