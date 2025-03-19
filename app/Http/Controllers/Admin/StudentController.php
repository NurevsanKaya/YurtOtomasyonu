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

    public function edit($id)
    {
        try {
            $student = Student::with(['user', 'room'])->findOrFail($id);
            $rooms = Room::all();
            return view('admin.students.edit', compact('student', 'rooms'));
        } catch (\Exception $e) {
            Log::error('Öğrenci düzenleme sayfası açılırken hata oluştu: ' . $e->getMessage());
            return back()->with('error', 'Öğrenci bilgileri getirilirken bir hata oluştu.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            
            // Validasyon kuralları
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'tc' => 'required|string|size:11|unique:students,tc,' . $id,
                'phone' => 'required|string|max:20',
                'email' => 'required|email|unique:students,email,' . $id,
                'birth_date' => 'required|date',
                'registration_date' => 'required|date',
                'medical_condition' => 'nullable|string',
                'emergency_contact' => 'required|string',
                'room_id' => 'nullable|exists:rooms,id',
            ]);

            DB::beginTransaction();

            // User bilgilerini güncelle
            $student->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
            ]);

            // Öğrenci bilgilerini güncelle
            $student->update([
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
            ]);

            DB::commit();

            Log::info('Öğrenci başarıyla güncellendi', ['student_id' => $id]);

            return redirect()->route('admin.students.index')
                ->with('success', 'Öğrenci başarıyla güncellendi.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasyon hatası:', [
                'errors' => $e->errors()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Öğrenci güncellenirken hata oluştu: ' . $e->getMessage());
            return back()->with('error', 'Öğrenci güncellenirken bir hata oluştu: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            
            DB::beginTransaction();

            // Önce user'ı sil
            $student->user->delete();
            
            // Sonra öğrenciyi sil
            $student->delete();

            DB::commit();

            Log::info('Öğrenci başarıyla silindi', ['student_id' => $id]);

            return redirect()->route('admin.students.index')
                ->with('success', 'Öğrenci başarıyla silindi.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Öğrenci silinirken hata oluştu: ' . $e->getMessage());
            return back()->with('error', 'Öğrenci silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 