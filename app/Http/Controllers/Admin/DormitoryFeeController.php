<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Debt;
use App\Models\RoomPrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DormitoryFeeController extends Controller
{
    public function createMonthlyFees()
    {
        // Bu ay için borç oluşturulmuş mu kontrol et
        $currentMonth = Carbon::now()->format('F Y');
        $existingDebt = Debt::where('description', 'like', "%$currentMonth%")
            ->first();

        if ($existingDebt) {
            return redirect()->back()->with('error', 'Bu ay için borçlar zaten oluşturulmuş!');
        }

        DB::beginTransaction();
        try {
            // Aktif öğrencileri al
            $activeStudents = Student::where('is_active', true)->get();
            $activeCount = $activeStudents->count();
            
            // Oda ataması olan öğrencileri al
            $studentsWithRoom = $activeStudents->filter(function($student) {
                return $student->room !== null;
            });
            $roomCount = $studentsWithRoom->count();

            // Oda fiyatlarını kontrol et
            $roomPrices = RoomPrice::all();
            $priceCount = $roomPrices->count();

            $createdCount = 0;
            $dueDate = Carbon::now()->endOfMonth();

            foreach ($studentsWithRoom as $student) {
                $roomPrice = RoomPrice::where('capacity', $student->room->capacity)->first();
                
                if ($roomPrice) {
                    Debt::create([
                        'student_id' => $student->id,
                        'description' => "$currentMonth Yurt Ücreti ({$student->room->capacity} Kişilik Oda)",
                        'amount' => $roomPrice->price,
                        'due_date' => $dueDate,
                        'status' => 'unpaid'
                    ]);
                    $createdCount++;
                }
            }

            DB::commit();
            
            // Detaylı bilgi mesajı
            $message = "İşlem tamamlandı:\n";
            $message .= "- Toplam aktif öğrenci: $activeCount\n";
            $message .= "- Oda ataması olan öğrenci: $roomCount\n";
            $message .= "- Tanımlı oda fiyatı: $priceCount\n";
            $message .= "- Borç oluşturulan öğrenci: $createdCount";
            
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Borç oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }
} 