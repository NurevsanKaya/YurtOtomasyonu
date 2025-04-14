<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('İzin Alma Sistemi') }}
        </h2>
    </x-slot>

    <!-- Flex container ile sidebar ve içerik yan yana yerleştirilir -->

        <!-- Ana İçerik Bölgesi -->
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                                <h1 class="text-3xl font-bold text-center mb-6">Öğrenci İzin Başvurusu</h1>
                                <!-- Eğer Laravel Blade kullanıyorsanız; CSRF token alanını ekleyin -->
                                <form action="/izin-basvuru" method="POST" class="bg-white p-6 rounded shadow-md">
                                    <!-- Laravel CSRF: @csrf -->

                                    <!-- Açıklama -->
                                    <div class="mb-4">
                                        <label for="description" class="block text-gray-700 font-medium mb-2">Açıklama</label>
                                        <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 p-2 rounded" placeholder="İzin açıklamanızı giriniz..."></textarea>
                                    </div>

                                    <!-- İzin Başlangıç Tarihi -->
                                    <div class="mb-4">
                                        <label for="start_date" class="block text-gray-700 font-medium mb-2">İzin Başlangıç Tarihi</label>
                                        <input type="date" id="start_date" name="start_date" class="w-full border border-gray-300 p-2 rounded" required>
                                    </div>

                                    <!-- İzin Bitiş Tarihi -->
                                    <div class="mb-4">
                                        <label for="end_date" class="block text-gray-700 font-medium mb-2">İzin Bitiş Tarihi</label>
                                        <input type="date" id="end_date" name="end_date" class="w-full border border-gray-300 p-2 rounded" required>
                                    </div>

                                    <!-- Telefon Numarası -->
                                    <div class="mb-4">
                                        <label for="phone" class="block text-gray-700 font-medium mb-2">Telefon Numarası</label>
                                        <input type="tel" id="phone" name="phone" class="w-full border border-gray-300 p-2 rounded" placeholder="05XX XXX XXXX" required>
                                    </div>

                                    <!-- İzin Adresi -->
                                    <div class="mb-4">
                                        <label for="leave_address" class="block text-gray-700 font-medium mb-2">İzin Adresi</label>
                                        <input type="text" id="leave_address" name="leave_address" class="w-full border border-gray-300 p-2 rounded" placeholder="Gitmek istediğiniz adresi giriniz" required>
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
