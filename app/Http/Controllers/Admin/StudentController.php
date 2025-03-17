<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::with('room')->get();
            Log::info('Öğrenciler başarıyla getirildi', ['count' => $students->count()]);
            return view('admin.students.index', compact('students'));
        } catch (\Exception $e) {
            Log::error('Öğrenciler getirilirken hata oluştu: ' . $e->getMessage());
            return back()->with('error', 'Öğrenciler listelenirken bir hata oluştu.');
        }
    }
} 