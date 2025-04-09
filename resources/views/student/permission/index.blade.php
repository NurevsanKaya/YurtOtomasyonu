<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('İzin Alma Sistemi') }}
        </h2>
    </x-slot>

    <!-- Flex container ile sidebar ve içerik yan yana yerleştirilir -->
    <div class="flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 min-h-screen flex flex-col">
            <div class="p-4">
                <h2 class="text-white text-2xl font-semibold">Yurt İşlemlerim</h2>
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

        <!-- Ana İçerik Bölgesi -->
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                                <h1 class="text-3xl font-bold text-center mb-6">Öğrenci İzin Başvurusu</h1>
                                
                                @if(session('success'))
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <span class="block sm:inline">{{ session('success') }}</span>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <!-- Eğer Laravel Blade kullanıyorsanız; CSRF token alanını ekleyin -->
                                <form action="{{ route('student.izin.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
                                    @csrf

                                    <!-- Açıklama -->
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 font-medium mb-2">Açıklama</label>
                                        <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 p-2 rounded" placeholder="İzin açıklamanızı giriniz..." required>{{ old('description') }}</textarea>
                                    </div>

                                    <!-- İzin Başlangıç Tarihi -->
                                    <div class="mb-4">
                                        <label for="start_date" class="block text-gray-700 font-medium mb-2">İzin Başlangıç Tarihi</label>
                                        <input type="date" id="start_date" name="start_date" class="w-full border border-gray-300 p-2 rounded" value="{{ old('start_date') }}" required>
                                    </div>

                                    <!-- İzin Bitiş Tarihi -->
                                    <div class="mb-4">
                                        <label for="end_date" class="block text-gray-700 font-medium mb-2">İzin Bitiş Tarihi</label>
                                        <input type="date" id="end_date" name="end_date" class="w-full border border-gray-300 p-2 rounded" value="{{ old('end_date') }}" required>
                                    </div>

                                    <!-- Telefon Numarası -->
                                    <div class="mb-4">
                                        <label for="phone_number" class="block text-gray-700 font-medium mb-2">Telefon Numarası</label>
                                        <input type="tel" id="phone_number" name="phone_number" class="w-full border border-gray-300 p-2 rounded" placeholder="05XX XXX XXXX" value="{{ old('phone_number') }}" required>
                                    </div>

                                    <!-- İzin Adresi -->
                                    <div class="mb-4">
                                        <label for="destination_address" class="block text-gray-700 font-medium mb-2">İzin Adresi</label>
                                        <input type="text" id="destination_address" name="destination_address" class="w-full border border-gray-300 p-2 rounded" placeholder="Gitmek istediğiniz adresi giriniz" value="{{ old('destination_address') }}" required>
                                    </div>

                                    <!-- Gönder Butonu -->
                                    <div class="text-center">
                                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                                            Başvuruyu Gönder
                                        </button>
                                    </div>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
