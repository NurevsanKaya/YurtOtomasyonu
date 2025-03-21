<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City;
use App\Models\District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Önce mevcut kayıtları temizleyelim
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('districts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // İl-ilçe eşleştirmeleri
        $districts = [
            // Adana
            ['city' => 'Adana', 'districts' => ['Seyhan', 'Çukurova', 'Yüreğir', 'Sarıçam', 'Karaisalı', 'Kozan', 'Ceyhan', 'İmamoğlu']],
            
            // Adıyaman
            ['city' => 'Adıyaman', 'districts' => ['Merkez', 'Besni', 'Çelikhan', 'Gerger', 'Gölbaşı', 'Kahta', 'Samsat', 'Sincik', 'Tut']],
            
            // Afyonkarahisar
            ['city' => 'Afyonkarahisar', 'districts' => ['Merkez', 'Başmakçı', 'Bayat', 'Bolvadin', 'Çay', 'Çobanlar', 'Dazkırı', 'Dinar', 'Emirdağ']],
            
            // Ağrı
            ['city' => 'Ağrı', 'districts' => ['Merkez', 'Diyadin', 'Doğubayazıt', 'Eleşkirt', 'Hamur', 'Patnos', 'Taşlıçay', 'Tutak']],
            
            // Amasya
            ['city' => 'Amasya', 'districts' => ['Merkez', 'Göynücek', 'Gümüşhacıköy', 'Hamamözü', 'Merzifon', 'Suluova', 'Taşova']],
            
            // Ankara
            ['city' => 'Ankara', 'districts' => ['Altındağ', 'Çankaya', 'Etimesgut', 'Keçiören', 'Mamak', 'Sincan', 'Yenimahalle', 'Pursaklar', 'Gölbaşı', 'Beypazarı', 'Polatlı']],
            
            // Antalya
            ['city' => 'Antalya', 'districts' => ['Muratpaşa', 'Kepez', 'Konyaaltı', 'Alanya', 'Manavgat', 'Serik', 'Kaş', 'Kemer', 'Kumluca', 'Finike']],
            
            // İstanbul
            ['city' => 'İstanbul', 'districts' => ['Adalar', 'Arnavutköy', 'Ataşehir', 'Avcılar', 'Bağcılar', 'Bahçelievler', 'Bakırköy', 'Başakşehir', 'Bayrampaşa', 'Beşiktaş', 'Beykoz', 'Beylikdüzü', 'Beyoğlu', 'Büyükçekmece', 'Çatalca', 'Çekmeköy', 'Esenler', 'Esenyurt', 'Eyüpsultan', 'Fatih', 'Gaziosmanpaşa', 'Güngören', 'Kadıköy', 'Kağıthane', 'Kartal', 'Küçükçekmece', 'Maltepe', 'Pendik', 'Sancaktepe', 'Sarıyer', 'Silivri', 'Sultanbeyli', 'Sultangazi', 'Şile', 'Şişli', 'Tuzla', 'Ümraniye', 'Üsküdar', 'Zeytinburnu']],
            
            // İzmir
            ['city' => 'İzmir', 'districts' => ['Aliağa', 'Balçova', 'Bayındır', 'Bayraklı', 'Bergama', 'Beydağ', 'Bornova', 'Buca', 'Çeşme', 'Çiğli', 'Dikili', 'Foça', 'Gaziemir', 'Güzelbahçe', 'Karabağlar', 'Karaburun', 'Karşıyaka', 'Kemalpaşa', 'Kınık', 'Kiraz', 'Konak', 'Menderes', 'Menemen', 'Narlıdere', 'Ödemiş', 'Seferihisar', 'Selçuk', 'Tire', 'Torbalı', 'Urla']],
            
            // Bursa
            ['city' => 'Bursa', 'districts' => ['Osmangazi', 'Nilüfer', 'Yıldırım', 'Gemlik', 'Gürsu', 'Harmancık', 'İnegöl', 'İznik', 'Karacabey', 'Keles', 'Kestel', 'Mudanya', 'Mustafakemalpaşa', 'Orhaneli', 'Orhangazi', 'Yenişehir']],
        ];

        // İlçeleri ekleyelim
        foreach ($districts as $data) {
            $city = City::where('name', $data['city'])->first();
            
            if ($city) {
                foreach ($data['districts'] as $districtName) {
                    District::create([
                        'name' => $districtName,
                        'city_id' => $city->id
                    ]);
                }
            }
        }
    }
} 