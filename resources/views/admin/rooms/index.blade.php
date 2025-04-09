@extends('admin.layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Oda Yönetimi</h2>
                        <!-- Yeni Oda Ekle Butonu -->
                        <button onclick="toggleModal('addRoomModal')" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Yeni Oda Ekle
                        </button>
                    </div>

                    <!-- Modal Başlangıç -->
                    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addRoomModal">
                        <div class="flex items-center justify-center min-h-screen px-4">
                            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                                <div class="px-6 py-4 border-b flex justify-between items-center">
                                    <h2 class="text-lg font-medium text-gray-800" id="modalTitle">Yeni Oda Ekle</h2>
                                    <button class="text-gray-600 hover:text-gray-800" onclick="toggleModal('addRoomModal')">×</button>
                                </div>
                                <!-- Form Başlangıç -->
                                <form id="roomForm" action="{{ route('rooms.store') }}" method="POST" class="px-6 py-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="room_number" class="block text-sm font-medium text-gray-700">Oda Numarası</label>
                                        <input type="text" id="room_number" name="room_number" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="capacity" class="block text-sm font-medium text-gray-700">Kapasite</label>
                                        <input type="number" id="capacity" name="capacity" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="floor" class="block text-sm font-medium text-gray-700">Kat</label>
                                        <input type="number" id="floor" name="floor" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="current_occupants" class="block text-sm font-medium text-gray-700">Mevcut Öğrenci</label>
                                        <input type="number" id="current_occupants" name="current_occupants" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="room_type" class="block text-sm font-medium text-gray-700">Oda Türü</label>
                                        <input type="text" id="room_type" name="room_type" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div class="mb-4">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Fiyat</label>
                                        <input type="number" id="price" name="price" class="mt-1 p-2 w-full border rounded-md">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" id="submitButton">Kaydet</button>
                                    </div>
                                </form>
                                <!-- Form Sonu -->
                            </div>
                        </div>
                    </div>
                    <!-- Modal Sonu -->

                    <!-- Oda Listesi Tablosu -->
                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead>
                            <tr class="text-left">
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Oda Numarası</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Kapasite</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Kat</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Mevcut Kişi</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Oda Türü</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Fiyat</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->room_number }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->capacity }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->floor }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->current_occupants }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->room_type }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->price }}</td>
                                    <td class="px-6 py-4">
                                        <!-- Düzenle Butonu -->

                                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">Düzenle</button>
                                        <button class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Sil</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Kayıtlı oda bulunamadı.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Açma/Kapama Scripti -->
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        function editRoom(room) {
            // Modal başlığını güncelle
            document.getElementById('modalTitle').innerText = 'Oda Düzenle';

            // Form action'ını düzenle
            const form = document.getElementById('roomForm');
            form.action = `/rooms/${room.id}`;

            // Form verilerini mevcut oda bilgileriyle doldur
            document.getElementById('room_number').value = room.room_number;
            document.getElementById('capacity').value = room.capacity;
            document.getElementById('floor').value = room.floor;
            document.getElementById('current_occupants').value = room.current_occupants;
            document.getElementById('room_type').value = room.room_type;
            document.getElementById('price').value = room.price;

            // Formu düzenleme olarak işaretle
            document.getElementById('submitButton').innerText = 'Güncelle';
            toggleModal('addRoomModal');
        }
    </script>
@endsection
