<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Önce mevcut kayıtları temizleyelim
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Türkiye'nin 81 ili
        $cities = [
            'Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Amasya', 
            'Ankara', 'Antalya', 'Artvin', 'Aydın', 'Balıkesir', 
            'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 
            'Bursa', 'Çanakkale', 'Çankırı', 'Çorum', 'Denizli', 
            'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 
            'Eskişehir', 'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 
            'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir', 
            'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 
            'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa', 
            'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 
            'Niğde', 'Ordu', 'Rize', 'Sakarya', 'Samsun', 
            'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 
            'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak', 'Van', 
            'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 
            'Kırıkkale', 'Batman', 'Şırnak', 'Bartın', 'Ardahan', 
            'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 
            'Düzce'
        ];
        
        // Şehirleri ekleyelim
        foreach ($cities as $city) {
            City::create(['name' => $city]);
        }
    }
} 