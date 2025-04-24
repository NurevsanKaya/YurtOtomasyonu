@extends('admin.layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Mesajlar -->
                    @if(session('success'))
                    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                    @endif

                    @if(session('warning'))
                    <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
                        <p>{{ session('warning') }}</p>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Oda Yönetimi</h2>
                        <!-- Yeni Oda Ekle Butonu -->
                        <button onclick="resetForm()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
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
                                <form id="roomForm" action="{{ route('admin.rooms.store') }}" method="POST" class="px-6 py-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="room_number" class="block text-sm font-medium text-gray-700">Oda Numarası</label>
                                        <input type="text" id="room_number" name="room_number" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="capacity" class="block text-sm font-medium text-gray-700">Kapasite</label>
                                        <input type="number" id="capacity" name="capacity" min="1" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="floor" class="block text-sm font-medium text-gray-700">Kat</label>
                                        <input type="number" id="floor" name="floor" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="room_type" class="block text-sm font-medium text-gray-700">Oda Türü</label>
                                        <select id="room_type" name="room_type" class="mt-1 p-2 w-full border rounded-md" required>
                                            <option value="">Oda türü seçin</option>
                                            <option value="Tek Kişilik">Tek Kişilik</option>
                                            <option value="İki Kişilik">İki Kişilik</option>
                                            <option value="Üç Kişilik">Üç Kişilik</option>
                                            <option value="Dört Kişilik">Dört Kişilik</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Fiyat</label>
                                        <input type="number" id="price" name="price" min="0" step="0.01" class="mt-1 p-2 w-full border rounded-md" required>
                                    </div>
                                    <!-- current_occupants girişi kaldırıldı -->
                                    <input type="hidden" id="current_occupants" name="current_occupants" value="0">
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
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Doluluk</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Oda Türü</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Fiyat</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Durum</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->room_number }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->capacity }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->floor }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        <div class="flex items-center">
                                            <span class="mr-2">{{ $room->current_occupants }}/{{ $room->capacity }}</span>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="h-2.5 rounded-full 
                                                @if($room->current_occupants >= $room->capacity) 
                                                    bg-red-600 
                                                @elseif($room->current_occupants >= $room->capacity * 0.7) 
                                                    bg-yellow-600 
                                                @else 
                                                    bg-green-600 
                                                @endif"
                                                style="width: {{ ($room->current_occupants / $room->capacity) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->room_type }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $room->price }}</td>
                                    <td class="px-6 py-4">
                                        @if($room->current_occupants >= $room->capacity)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Dolu
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Müsait
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <!-- Düzenle Butonu -->
                                        <button onclick="editRoom({{ json_encode($room) }})" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-700">Düzenle</button>
                                        <button class="px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-700">Sil</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Kayıtlı oda bulunamadı.</td>
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
                // Yeni oda eklemeyi sıfırla
                if (document.getElementById('modalTitle').innerText === 'Yeni Oda Ekle') {
                    document.getElementById('roomForm').reset();
                }
            } else {
                modal.classList.add('hidden');
            }
        }
        
        // Yeni oda eklemek için formu sıfırlama fonksiyonu
        function resetForm() {
            // Formu sıfırla
            document.getElementById('roomForm').reset();
            
            // Başlığı değiştir
            document.getElementById('modalTitle').innerText = 'Yeni Oda Ekle';
            
            // Form action'ını değiştir
            document.getElementById('roomForm').action = "{{ route('admin.rooms.store') }}";
            
            // PUT metodu varsa kaldır
            let methodInput = document.querySelector("input[name='_method']");
            if (methodInput) {
                methodInput.remove();
            }
            
            // Buton yazısını değiştir
            document.getElementById('submitButton').innerText = 'Kaydet';
            
            // Modalı göster
            toggleModal('addRoomModal');
        }

        function editRoom(room) {
            // Modal başlığını güncelle
            document.getElementById('modalTitle').innerText = 'Oda Düzenle';

            // Form action'ını düzenle - URL'yi admin prefix ile ayarla
            const form = document.getElementById('roomForm');
            form.action = "{{ url('/admin') }}" + `/rooms/${room.id}`;
            
            // Method override için _method ekle
            if (!document.getElementById('method_field')) {
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PUT';
                methodField.id = 'method_field';
                form.appendChild(methodField);
            }

            // Form verilerini mevcut oda bilgileriyle doldur
            document.getElementById('room_number').value = room.room_number;
            document.getElementById('capacity').value = room.capacity;
            document.getElementById('floor').value = room.floor;
            document.getElementById('current_occupants').value = room.current_occupants;
            
            // Oda türünü seç
            const roomTypeSelect = document.getElementById('room_type');
            for (let i = 0; i < roomTypeSelect.options.length; i++) {
                if (roomTypeSelect.options[i].value === room.room_type) {
                    roomTypeSelect.selectedIndex = i;
                    break;
                }
            }
            
            document.getElementById('price').value = room.price;

            // Formu düzenleme olarak işaretle
            document.getElementById('submitButton').innerText = 'Güncelle';
            toggleModal('addRoomModal');
        }
    </script>
@endsection
