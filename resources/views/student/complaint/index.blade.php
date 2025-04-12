<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dilek ve Şikayet Bildirimi') }}
        </h2>
    </x-slot>



        <!-- Ana İçerik Bölgesi -->
        <div class="flex-1">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <!-- Ana İçerik Bölgesi -->
                            <div class="flex-1 py-12">
                                <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                                    <!-- Form Kartı -->
                                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                                        <form method="POST" action="">
                                            @csrf
                                            <!-- Başlık -->
                                            <div class="mb-4">
                                                <label for="title" class="block text-gray-700 font-medium mb-1">Başlık</label>
                                                <input
                                                    type="text"
                                                    id="title"
                                                    name="title"
                                                    class="w-full border border-gray-300 p-2 rounded"
                                                    placeholder="Başlığı giriniz"
                                                    required
                                                >
                                            </div>

                                            <!-- Açıklama -->
                                            <div class="mb-4">
                                                <label for="description" class="block text-gray-700 font-medium mb-1">Açıklama</label>
                                                <textarea
                                                    id="description"
                                                    name="description"
                                                    rows="4"
                                                    class="w-full border border-gray-300 p-2 rounded"
                                                    placeholder="Açıklamayı giriniz"
                                                    required
                                                ></textarea>
                                            </div>



                                            <!-- Gönder Butonu -->
                                            <div class="text-center">
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                                    Gönder
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
