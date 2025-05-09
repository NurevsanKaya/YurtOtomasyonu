@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Geç Ödemeler</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Ödenmemiş Geç Ödemeler Tablosu -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Ödenmemiş Geç Ödemeler</h2>
        
        <!-- Arama Kutusu -->
        <div class="mb-4">
            <input type="text" 
                   id="unpaidSearchInput"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="İsim ile ara..."
            >
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="max-h-[500px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Öğrenci Adı
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Oda Numarası
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Toplam Borç
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ödenmemiş Aylar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                En Eski Borç Tarihi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="unpaidTableBody">
                        @forelse($unpaidStudents as $student)
                            <tr class="unpaid-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 student-name">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $student->room->room_number ?? 'Oda Yok' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ number_format($student->total_debt, 2) }} TL
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $student->unpaid_months }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $student->oldest_debt_date ? Carbon\Carbon::parse($student->oldest_debt_date)->format('d.m.Y') : '-' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="unpaidNoResult">
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    Ödenmemiş geç ödeme bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Ödenmiş Geç Ödemeler Tablosu -->
    <div>
        <h2 class="text-xl font-semibold mb-4">Ödenmiş Geç Ödemeler</h2>

        <!-- Arama Kutusu -->
        <div class="mb-4">
            <input type="text" 
                   id="paidSearchInput"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="İsim ile ara..."
            >
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="max-h-[500px] overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Öğrenci Adı
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Oda Numarası
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ödenen Tutar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ödenmiş Aylar
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Son Ödeme Tarihi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="paidTableBody">
                        @forelse($paidStudents as $student)
                            <tr class="paid-row">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 student-name">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $student->room->room_number ?? 'Oda Yok' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ number_format($student->total_paid, 2) }} TL
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $student->paid_months }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $student->latest_payment_date ? Carbon\Carbon::parse($student->latest_payment_date)->format('d.m.Y H:i') : '-' }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="paidNoResult">
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    Ödenmiş geç ödeme bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Sayfa yüklendiğinde çalışacak kodlar
document.addEventListener('DOMContentLoaded', function() {
    // Arama yapılacak tabloları ve arama kutularını tanımla
    var odemeyenTablo = {
        aramaKutusu: document.getElementById('unpaidSearchInput'),
        satirlar: document.querySelectorAll('.unpaid-row'),
        sonucYok: document.getElementById('unpaidNoResult')
    };

    var odeyenTablo = {
        aramaKutusu: document.getElementById('paidSearchInput'),
        satirlar: document.querySelectorAll('.paid-row'),
        sonucYok: document.getElementById('paidNoResult')
    };

    // Tablolarda arama yapmak için ortak fonksiyon
    function tablodaAra(tablo) {
        // Arama kutusuna bir şey yazıldığında çalışacak
        tablo.aramaKutusu.addEventListener('input', function() {
            var arananYazi = this.value.toLowerCase();
            var sonucVar = false;

            // Her öğrenci satırını kontrol et
            tablo.satirlar.forEach(function(satir) {
                var ogrenciAdi = satir.querySelector('.student-name').textContent.toLowerCase();
                
                // Öğrenci adında aranan yazı varsa göster, yoksa gizle
                if (ogrenciAdi.includes(arananYazi)) {
                    satir.style.display = '';
                    sonucVar = true;
                } else {
                    satir.style.display = 'none';
                }
            });

            // Sonuç yoksa "sonuç bulunamadı" mesajını göster
            if (tablo.sonucYok) {
                tablo.sonucYok.style.display = sonucVar ? 'none' : '';
            }
        });
    }

    // Her iki tablo için arama özelliğini etkinleştir
    tablodaAra(odemeyenTablo);
    tablodaAra(odeyenTablo);
});
</script>
@endsection 