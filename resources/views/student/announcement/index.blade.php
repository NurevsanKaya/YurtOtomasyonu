<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Duyuru Sistemi') }}
        </h2>
    </x-slot>

    <!-- Sidebar ve İçerik için Flex Container -->
    <div class="flex">
        <!-- Sidebar (Sol Bölge) -->
        <aside class="bg-gray-800 w-64 min-h-screen flex flex-col">
            <div class="p-4">
                <h2 class="text-white text-2xl font-semibold">Yurt Yönetimi</h2>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
                <!-- Profil Bilgileri ve Güncelleme -->
                <a href="" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-home mr-3"></i>
                    <span>Profil Bilgileri ve Güncelleme</span>
                </a>
                <!-- İzin Alma Sistemi -->
                <a href="{{ route('student.izin.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-users mr-3"></i>
                    <span>İzin Alma Sistemi</span>
                </a>
                <!-- Oda Bilgileri Görüntüleme ve Değişiklik Talebi -->
                <a href="{{ route('student.oda.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-bed mr-3"></i>
                    <span>Oda Bilgileri Görüntüleme ve Değişiklik Talebi</span>
                </a>
                <!-- Yemekhane Takibi ve Menü Görüntüleme -->
                <a href="{{ route('student.menu.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-money-bill mr-3"></i>
                    <span>Yemekhane Takibi ve Menü Görüntüleme</span>
                </a>
                <!-- Aidat ve Borç Takibi -->
                <a href="{{ route('student.aidat.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-bullhorn mr-3"></i>
                    <span>Aidat ve Borç Takibi</span>
                </a>
                <!-- Ziyaretçi Bildirimi -->
                <a href="{{ route('student.ziyaretci.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-tools mr-3"></i>
                    <span>Ziyaretçi Bildirimi</span>
                </a>
                <!-- Duyuru Sistemi -->
                <a href="{{ route('student.duyuru.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-tools mr-3"></i>
                    <span>Duyuru Sistemi</span>
                </a>
                <!-- Dilek ve Şikayet Bildirimi -->
                <a href="{{ route('student.sikayet.index') }}" class="flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-tools mr-3"></i>
                    <span>Dilek ve Şikayet Bildirimi</span>
                </a>
            </nav>
        </aside>

        <!-- Ana İçerik Bölgesi (Sağ Bölge) -->
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            Duyuru sistemi içeriği buraya gelecek
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
