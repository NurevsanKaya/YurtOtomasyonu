<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ziyaretçi Bildirimleri') }}
        </h2>
    </x-slot>

    <!-- Flex Container: Sidebar ve İçerik Yan Yana -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 min-h-screen flex flex-col">
            <div class="p-4">
                <h2 class="text-white text-2xl font-semibold">Yurt Yönetimi</h2>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <!-- Menü Linkleri (Örnek) -->
                <a href="" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-home mr-3"></i>
                    <span>Profil Bilgileri</span>
                </a>
                <a href="{{ route('student.izin.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-users mr-3"></i>
                    <span>İzin Alma Sistemi</span>
                </a>
                <a href="{{ route('student.oda.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-bed mr-3"></i>
                    <span>Oda Bilgileri</span>
                </a>
                <a href="{{ route('student.menu.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-money-bill mr-3"></i>
                    <span>Yemekhane Takibi</span>
                </a>
                <a href="{{ route('student.aidat.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-bullhorn mr-3"></i>
                    <span>Aidat ve Borç Takibi</span>
                </a>
                <a href="{{ route('student.ziyaretci.index') }}" class="flex items-center px-4 py-2 text-gray-100 bg-gray-700 rounded-lg">
                    <i class="fas fa-tools mr-3"></i>
                    <span>Ziyaretçi Bildirimi</span>
                </a>
                <a href="{{ route('student.duyuru.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-tools mr-3"></i>
                    <span>Duyuru Sistemi</span>
                </a>
                <a href="{{ route('student.sikayet.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-tools mr-3"></i>
                    <span>Dilek ve Şikayet Bildirimi</span>
                </a>
            </nav>
        </aside>

        <!-- Ana İçerik Bölgesi -->
        <div class="flex-1 py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Arka planı beyaz, yazıları koyu yaparak tabloyu netleştirelim -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h1 class="text-2xl font-bold mb-6">Ziyaretçi Bildirimleri</h1>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300">
                                <!-- Tablonun başlık satırını açık renk yapıyoruz -->
                                <thead class="bg-gray-100 text-gray-800">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Adı</th>
                                    <th class="py-3 px-4 border-b text-left">Soyadı</th>
                                    <th class="py-3 px-4 border-b text-left">Telefon</th>
                                    <th class="py-3 px-4 border-b text-left">TC</th>
                                    <th class="py-3 px-4 border-b text-left">Adresi</th>
                                    <th class="py-3 px-4 border-b text-left">Ziyaret Nedeni</th>
                                    <th class="py-3 px-4 border-b text-left">Giriş Tarihi</th>
                                    <th class="py-3 px-4 border-b text-left">Çıkış Tarihi</th>
                                    <th class="py-3 px-4 border-b text-left">Ziyaret Onayı</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">Ahmet</td>
                                    <td class="py-2 px-4 border-b">Yılmaz</td>
                                    <td class="py-2 px-4 border-b">0544 123 45 67</td>
                                    <td class="py-2 px-4 border-b">12345678910</td>
                                    <td class="py-2 px-4 border-b">İstanbul, Kadıköy</td>
                                    <td class="py-2 px-4 border-b">Aile ziyareti</td>
                                    <td class="py-2 px-4 border-b">2025-04-10 10:00</td>
                                    <td class="py-2 px-4 border-b">2025-04-10 12:00</td>
                                    <td class="py-2 px-4 border-b">Onaylandı</td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">Ayşe</td>
                                    <td class="py-2 px-4 border-b">Demir</td>
                                    <td class="py-2 px-4 border-b">0532 987 65 43</td>
                                    <td class="py-2 px-4 border-b">10987654321</td>
                                    <td class="py-2 px-4 border-b">Ankara, Çankaya</td>
                                    <td class="py-2 px-4 border-b">Arkadaş ziyareti</td>
                                    <td class="py-2 px-4 border-b">2025-04-10 11:00</td>
                                    <td class="py-2 px-4 border-b">2025-04-10 13:00</td>
                                    <td class="py-2 px-4 border-b">Bekliyor</td>
                                </tr>
                                <!-- Diğer satırlar dinamik olarak eklenebilir -->
                                </tbody>
                            </table>
                        </div>
                    </div><!-- p-6 -->
                </div><!-- bg-white -->
            </div><!-- max-w-7xl -->
        </div><!-- flex-1 -->
    </div><!-- flex -->
</x-app-layout>
