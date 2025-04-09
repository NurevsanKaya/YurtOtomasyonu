<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentVisitorController extends Controller
{
    public function index()
    {
        return view('student.visitor.index');
    }
}
