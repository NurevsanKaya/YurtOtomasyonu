<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Room;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::with(['room', 'user', 'address'])->get();
            $rooms = Room::all();
            
            // Debug logları ekleyelim
            Log::info('Odalar getirildi', [
                'rooms_count' => $rooms->count(),
                'rooms' => $rooms->toArray()
            ]);
            
            Log::info('Öğrenciler başarıyla getirildi', ['count' => $students->count()]);
            return view('admin.students.index', compact('students', 'rooms'));
        } catch (\Exception $e) {
            Log::error('Öğrenciler getirilirken hata oluştu: ' . $e->getMessage());
            return back()->with('error', 'Öğrenciler listelenirken bir hata oluştu.');
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasyon kuralları
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'tc' => 'required|string|size:11|unique:students,tc',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:students,email',
                'birth_date' => 'required|date',
                'registration_date' => 'required|date',
                'medical_condition' => 'nullable|string',
                'emergency_contact' => 'required|string',
                'room_id' => 'nullable|exists:rooms,id',
            ]);

            DB::beginTransaction();

            // Önce User oluştur
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->tc), // TC kimlik no ile şifre oluştur
                'role_id' => 2, // 2 = kullanıcı rolü
            ]);

            // Öğrenciyi oluştur
            $student = Student::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'tc' => $request->tc,
                'phone' => $request->phone,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'registration_date' => $request->registration_date,
                'medical_condition' => $request->medical_condition,
                'emergency_contact' => $request->emergency_contact,
                'room_id' => $request->room_id,
                'is_active' => true,
            ]);

            DB::commit();

            Log::info('Öğrenci başarıyla eklendi', [
                'student_id' => $student->id,
                'user_id' => $user->id
            ]);

            return redirect()->route('admin.students.index')
                ->with('success', 'Öğrenci başarıyla eklendi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasyon hatası:', [
                'errors' => $e->errors()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Öğrenci eklenirken hata oluştu: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Öğrenci eklenirken bir hata oluştu: ' . $e->getMessage())->withInput();
        }
    }
} 