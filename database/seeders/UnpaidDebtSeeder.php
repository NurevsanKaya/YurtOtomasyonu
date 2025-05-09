<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Debt;
use Carbon\Carbon;

class UnpaidDebtSeeder extends Seeder
{
    private function getTurkishMonth($month)
    {
        $months = [
            1 => 'Ocak',
            2 => 'Şubat',
            3 => 'Mart',
            4 => 'Nisan',
            5 => 'Mayıs',
            6 => 'Haziran',
            7 => 'Temmuz',
            8 => 'Ağustos',
            9 => 'Eylül',
            10 => 'Ekim',
            11 => 'Kasım',
            12 => 'Aralık'
        ];
        return $months[$month];
    }

    public function run()
    {
        // Aktif öğrencileri al
        $students = Student::where('is_active', true)->take(5)->get();

        // Son 3 ay için borç oluştur
        $months = [
            Carbon::now()->subMonths(3), // 3 ay önce
            Carbon::now()->subMonths(2), // 2 ay önce
            Carbon::now()->subMonths(1), // 1 ay önce
        ];

        foreach ($students as $student) {
            foreach ($months as $month) {
                // Her ay için rastgele borç durumu
                $shouldCreateDebt = rand(0, 1);
                
                if ($shouldCreateDebt) {
                    Debt::create([
                        'student_id' => $student->id,
                        'description' => $this->getTurkishMonth($month->month) . ' ' . $month->year . ' Yurt Ücreti',
                        'amount' => 2500.00, // Örnek ücret
                        'due_date' => $month->copy()->endOfMonth(),
                        'status' => 'unpaid'
                    ]);
                }
            }
        }
    }
} 