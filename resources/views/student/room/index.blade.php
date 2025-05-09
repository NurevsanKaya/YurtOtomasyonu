@extends('student.layouts.dashboard')

@section('title', 'Oda Bilgileri')
@section('content')
    <div class="max-w-4xl mx-auto p-4 space-y-6">
        @if($room)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Oda {{ $room->room_number }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Oda Numarası:</p>
                        <p class="text-lg">{{ $room->room_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Bulunduğu Kat:</p>
                        <p class="text-lg">{{ $room->floor }}. Kat</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Oda Tipi:</p>
                        <p class="text-lg">{{ ucfirst($room->room_type) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Kapasite / Doluluk:</p>
                        <p class="text-lg">
                            {{ $room->capacity }} Kişilik &mdash;
                            {{ $room->current_occupants }}/{{ $room->capacity }} Dolu
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-600">Aylık Ücret:</p>
                        <p class="text-lg">{{ number_format($room->price, 2, ',', '.') }} ₺</p>
                    </div>
                </div>
                <!-- Oda Değişikliği Talep Et Butonu -->
                <div class="mt-6 text-right">
                    <button id="changeRoomBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Oda Değişikliği Talep Et
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div id="changeRoomModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                    <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
                    <h3 class="text-lg font-semibold mb-4">Boş Oda Seç</h3>
                    <form id="roomChangeForm">
                        <div class="mb-4">
                            <label for="requested_room_id" class="block text-gray-700 font-medium mb-1">Boş Odalar</label>
                            <select id="requested_room_id" name="requested_room_id" class="w-full border border-gray-300 p-2 rounded" required>
                                <option value="">Yükleniyor...</option>
                            </select>
                        </div>
                        <div id="roomChangeError" class="text-red-600 mb-2 hidden"></div>
                        <div id="roomChangeSuccess" class="text-green-600 mb-2 hidden"></div>
                        <div class="text-right">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Talep Gönder</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                const changeRoomBtn = document.getElementById('changeRoomBtn');
                const changeRoomModal = document.getElementById('changeRoomModal');
                const closeModalBtn = document.getElementById('closeModalBtn');
                const requestedRoomSelect = document.getElementById('requested_room_id');
                const roomChangeForm = document.getElementById('roomChangeForm');
                const roomChangeError = document.getElementById('roomChangeError');
                const roomChangeSuccess = document.getElementById('roomChangeSuccess');

                changeRoomBtn.addEventListener('click', function() {
                    changeRoomModal.classList.remove('hidden');
                    roomChangeError.classList.add('hidden');
                    roomChangeSuccess.classList.add('hidden');
                    // Boş odaları çek
                    fetch('/student/room-change/available-rooms')
                        .then(response => response.json())
                        .then(data => {
                            requestedRoomSelect.innerHTML = '';
                            if (data.length === 0) {
                                requestedRoomSelect.innerHTML = '<option value="">Boş oda yok</option>';
                            } else {
                                requestedRoomSelect.innerHTML = '<option value="">Oda Seçin</option>';
                                data.forEach(room => {
                                    requestedRoomSelect.innerHTML += `<option value="${room.id}">${room.room_number} - Kat: ${room.floor} - Tip: ${room.room_type} - Kapasite: ${room.capacity} - Dolu: ${room.current_occupants}</option>`;
                                });
                            }
                        });
                });

                closeModalBtn.addEventListener('click', function() {
                    changeRoomModal.classList.add('hidden');
                });

                roomChangeForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    roomChangeError.classList.add('hidden');
                    roomChangeSuccess.classList.add('hidden');
                    const formData = new FormData(roomChangeForm);
                    fetch('/student/room-change/request', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            roomChangeError.textContent = data.error;
                            roomChangeError.classList.remove('hidden');
                        } else if (data.success) {
                            roomChangeSuccess.textContent = data.success;
                            roomChangeSuccess.classList.remove('hidden');
                            setTimeout(() => {
                                changeRoomModal.classList.add('hidden');
                                window.location.reload();
                            }, 1500);
                        }
                    })
                    .catch(() => {
                        roomChangeError.textContent = 'Bir hata oluştu.';
                        roomChangeError.classList.remove('hidden');
                    });
                });
            </script>
        @else
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
                Henüz bir odaya yerleştirilmediniz.
            </div>
        @endif
    </div>
@endsection
