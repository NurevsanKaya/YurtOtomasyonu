<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Room;
use App\Models\User;
use App\Models\Address;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
            // Debug için tüm gelen verileri loglayalım
            Log::info('Gelen form verileri:', $request->all());
            
            // Validasyon kuralları
            $validated = $request->validate([
                // Öğrenci bilgileri
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'tc' => 'required|digits:11|unique:students,tc',
                'phone' => 'required|string',
                'email' => 'required|email|max:100|unique:students,email',
                'birth_date' => 'required|date|before:today',
                'registration_date' => 'required|date',
                'medical_condition' => 'nullable|string|max:255',
                'emergency_contact' => 'required|string',
                'is_active' => 'boolean',

                // Adres bilgileri
                'city_id' => 'required|exists:cities,id',
                'district_id' => 'required|exists:districts,id',
                'address_line' => 'required|string|max:255',
                'postal_code' => 'required|string|max:5',

                // Oda bilgisi
                'room_id' => 'required|exists:rooms,id',

                // Veli bilgileri
                'guardian_first_name' => 'required|string|max:50',
                'guardian_last_name' => 'required|string|max:50',
                'guardian_phone' => 'required|string',
                'guardian_email' => 'required|email|max:100',
                'guardian_relationship' => 'required|string|max:50'
            ]);

            DB::beginTransaction();

            // Email'in users tablosunda zaten var olup olmadığını kontrol et
            if (User::where('email', $validated['email'])->exists()) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['email' => 'Bu e-posta adresi zaten kullanımda.']);
            }

            // TC'nin students tablosunda olup olmadığını kontrol et
            if (Student::where('tc', $validated['tc'])->exists()) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['tc' => 'Bu TC kimlik numarası zaten kullanımda.']);
            }

            // User oluştur
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make(Str::random(10)), // Rastgele şifre
                'role_id' => 2 // Öğrenci rolü
            ]);

            // Adres oluştur
            $address = Address::create([
                'district_id' => $validated['district_id'],
                'postal_code' => $validated['postal_code'],
                'address_line' => $validated['address_line'],
            ]);

            // Öğrenci oluştur
            $student = Student::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'room_id' => $validated['room_id'],
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'tc' => $validated['tc'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'birth_date' => $validated['birth_date'],
                'registration_date' => $validated['registration_date'],
                'medical_condition' => $validated['medical_condition'] ?? null,
                'emergency_contact' => $validated['emergency_contact'],
                'is_active' => $request->has('is_active'),
            ]);

            // Veli bilgilerini kaydet
            Guardian::create([
                'student_id' => $student->id,
                'first_name' => $validated['guardian_first_name'],
                'last_name' => $validated['guardian_last_name'],
                'phone' => $validated['guardian_phone'],
                'email' => $validated['guardian_email'],
                'relationship' => $validated['guardian_relationship']
            ]);

            // Odanın doluluk sayısını arttır
            $room = Room::findOrFail($validated['room_id']);
            $room->current_occupants += 1;
            $room->save();

            DB::commit();
            Log::info('Öğrenci başarıyla eklendi', ['student_id' => $student->id]);

            return redirect()->route('admin.students.index')
                ->with('success', 'Öğrenci başarıyla eklendi');

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validasyon hatası:', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Öğrenci eklenirken hata oluştu: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Öğrenci eklenirken bir hata oluştu: ' . $e->getMessage())
                ->withInput();
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
