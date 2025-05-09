<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => 2,// kullanıcı 
        ]);

        // Şehir ve ilçe verilerini ekle
        $this->call([
            CitySeeder::class,
            DistrictSeeder::class,
        ]);

        $this->call([
            UnpaidDebtSeeder::class
        ]);
    }
}
