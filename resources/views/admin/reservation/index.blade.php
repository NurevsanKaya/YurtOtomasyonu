@extends('admin.layouts.app')

@section('header', 'Rezervasyon Yönetimi')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded relative mb-3 text-sm" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('student_password'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-3 py-2 rounded relative mb-3 text-sm" role="alert">
            <span class="font-bold">Yeni Oluşturulan Hesap Bilgileri:</span>
            <ul class="mt-1">
                <li><strong>E-posta:</strong> {{ session('student_email') }}</li>
                <li><strong>TC Kimlik No:</strong> {{ session('student_tc') }}</li>
                <li><strong>İlk Şifresi (TC):</strong> {{ session('student_password') }}</li>
            </ul>
            <p class="mt-1 text-xs italic">
                Bu bilgiler sadece bir kez gösterilecektir. Öğrenciye iletmeyi unutmayınız!
            </p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative mb-3 text-sm" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Filtreleme Paneli -->
    <div class="bg-white rounded-lg shadow-sm mb-4">
        <button onclick="toggleFilters()" class="w-full px-4 py-2 text-left text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filtreleme Seçenekleri
            </div>
            <svg id="filterArrow" class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
        
        <div id="filterPanel" class="hidden p-4 border-t">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Ad Filtresi</label>
                    <input type="text" id="searchName" placeholder="Ad..." class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">TC Kimlik No Filtresi</label>
                    <input type="text" id="searchTC" placeholder="TC Kimlik No..." class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">E-posta Filtresi</label>
                    <input type="text" id="searchEmail" placeholder="E-posta..." class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                    <input type="date" id="startDate" class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                    <input type="date" id="endDate" class="w-full px-3 py-1.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
            </div>
            <div class="flex justify-end mt-4 space-x-2">
                <button onclick="clearFilters()" class="px-3 py-1.5 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                    Filtreleri Temizle
                </button>
                <button onclick="applyFilters()" class="px-3 py-1.5 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Filtreleri Uygula
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded my-4 overflow-x-auto">
        <div class="max-h-[742px] overflow-y-auto"> <!-- liste uzunluğunu belirliyoz.Bu uzunluktan sonra dikey scroll bar görünür. -->
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 text-xs leading-normal sticky top-0">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Ad</th>
                        <th class="py-2 px-4 text-left">Soyad</th>
                        <th class="py-2 px-4 text-left">TC</th>
                        <th class="py-2 px-4 text-left">Telefon</th>
                        <th class="py-2 px-4 text-left">E-posta</th>
                        <th class="py-2 px-4 text-left">Oda</th>
                        <th class="py-2 px-4 text-left">Kayıt Tarihi</th>
                        <th class="py-2 px-4 text-center">Durum</th>
                        <th class="py-2 px-4 text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs">
                    @foreach($reservations as $reservation)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $reservation->id }}</td>
                        <td class="py-2 px-4">{{ $reservation->first_name }}</td>
                        <td class="py-2 px-4">{{ $reservation->last_name }}</td>
                        <td class="py-2 px-4">{{ $reservation->tc }}</td>
                        <td class="py-2 px-4">{{ $reservation->phone }}</td>
                        <td class="py-2 px-4">{{ $reservation->email }}</td>
                        <td class="py-2 px-4">
                            @if($reservation->room)
                                <span class="tooltip" title="Kapasite: {{ $reservation->room->capacity }}, Doluluk: {{ $reservation->room->current_occupants }}">
                                    {{ $reservation->room->room_number }} - {{ $reservation->room->room_type }}
                                    <span class="text-xs">
                                        ({{ $reservation->room->current_occupants }}/{{ $reservation->room->capacity }})
                                    </span>
                                </span>
                            @else
                                <span class="text-red-500">Oda Seçilmemiş</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            @if($reservation->registration_date)
                                @if(is_string($reservation->registration_date))
                                    {{ \Carbon\Carbon::parse($reservation->registration_date)->format('d.m.Y') }}
                                @else
                                    {{ $reservation->registration_date->format('d.m.Y') }}
                                @endif
                            @else
                                Belirtilmemiş
                            @endif
                        </td>
                        <td class="py-2 px-4 text-center">
                            @if($reservation->status == 'beklemede')
                                <span class="bg-yellow-100 text-yellow-800 py-0.5 px-2 rounded-full text-xs">Beklemede</span>
                            @elseif($reservation->status == 'onaylandı')
                                <span class="bg-green-100 text-green-800 py-0.5 px-2 rounded-full text-xs">Onaylandı</span>
                            @elseif($reservation->status == 'reddedildi')
                                <span class="bg-red-100 text-red-800 py-0.5 px-2 rounded-full text-xs">Reddedildi</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 text-center">
                            @if($reservation->status == 'beklemede')
                                <div class="flex items-center justify-center space-x-1">
                                    <button type="button" class="bg-blue-500 text-white py-0.5 px-2 rounded text-xs hover:bg-blue-600 flex items-center" onclick="showReservationDetails({{ $reservation->id }})">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detay
                                    </button>
                                    <form action="{{ route('admin.reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white py-0.5 px-2 rounded text-xs hover:bg-green-600 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Onayla
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reservations.reject', $reservation->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-red-500 text-white py-0.5 px-2 rounded text-xs hover:bg-red-600 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Reddet
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-500 text-xs">İşlem Yapıldı</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Tooltip stilleri */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 1;
            font-size: 12px;
        }
    </style>

    <!-- Rezervasyon Detay Modalı -->
    <div id="reservationDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Rezervasyon Detayları</h3>
                <div id="reservationDetails" class="mt-2 text-sm text-gray-500">
                    <!-- Detaylar JavaScript ile doldurulacak -->
                </div>
                <div class="mt-4">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded text-sm hover:bg-gray-600" onclick="closeReservationDetails()">
                        Kapat
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showReservationDetails(reservationId) {
            // Modal'ı göster
            document.getElementById('reservationDetailModal').classList.remove('hidden');
            
            // Rezervasyon detaylarını getir
            fetch(`/admin/reservations/${reservationId}/details`)
                .then(response => response.json())
                .then(data => {
                    const detailsHtml = `
                        <div class="space-y-2">
                            <p><strong>Ad Soyad:</strong> ${data.first_name} ${data.last_name}</p>
                            <p><strong>TC Kimlik No:</strong> ${data.tc}</p>
                            <p><strong>Telefon:</strong> ${data.phone}</p>
                            <p><strong>E-posta:</strong> ${data.email}</p>
                            <p><strong>Doğum Tarihi:</strong> ${data.birth_date}</p>
                            <p><strong>Sağlık Durumu:</strong> ${data.medical_condition || 'Belirtilmemiş'}</p>
                            <p><strong>Acil Durum İletişim:</strong> ${data.emergency_contact}</p>
                            <p><strong>Kayıt Tarihi:</strong> ${data.registration_date}</p>
                            <p><strong>Oda:</strong> ${data.room ? data.room.room_number + ' - ' + data.room.room_type : 'Belirtilmemiş'}</p>
                            <p><strong>Durum:</strong> ${data.status}</p>
                        </div>
                    `;
                    document.getElementById('reservationDetails').innerHTML = detailsHtml;
                })
                .catch(error => {
                    console.error('Hata:', error);
                    alert('Rezervasyon detayları alınırken bir hata oluştu.');
                });
        }

        function closeReservationDetails() {
            document.getElementById('reservationDetailModal').classList.add('hidden');
        }

        // Global değişkenler
        let searchName, searchTC, searchEmail, startDate, endDate, tableRows;

        document.addEventListener('DOMContentLoaded', function() {
            // DOM elementlerini bir kere seç
            searchName = document.getElementById('searchName');
            searchTC = document.getElementById('searchTC');
            searchEmail = document.getElementById('searchEmail');
            startDate = document.getElementById('startDate');
            endDate = document.getElementById('endDate');
            tableRows = document.querySelectorAll('tbody tr');
        });

        function toggleFilters() {
            const filterPanel = document.getElementById('filterPanel');
            const filterArrow = document.getElementById('filterArrow');
            
            if (filterPanel.classList.contains('hidden')) {
                filterPanel.classList.remove('hidden');
                filterArrow.classList.add('rotate-180');
            } else {
                filterPanel.classList.add('hidden');
                filterArrow.classList.remove('rotate-180');
            }
        }

        function clearFilters() {
            // Input değerlerini temizle
            searchName.value = '';
            searchTC.value = '';
            searchEmail.value = '';
            startDate.value = '';
            endDate.value = '';
            
            // Tüm satırları göster
            tableRows.forEach(row => {
                row.style.display = '';
            });

            // Sonuç mesajını güncelle
            updateResultMessage(tableRows.length);
        }

        function updateResultMessage(count) {
            const resultMessage = document.createElement('div');
            resultMessage.className = 'text-sm text-gray-600 mt-2 filter-result-message';
            resultMessage.textContent = `${count} kayıt gösteriliyor`;
            
            const existingMessage = document.querySelector('.filter-result-message');
            if (existingMessage) {
                existingMessage.remove();
            }
            
            document.querySelector('.overflow-x-auto').insertAdjacentElement('beforebegin', resultMessage);
        }

        function applyFilters() {
            const nameFilter = searchName.value.toLowerCase();
            const tcFilter = searchTC.value.toLowerCase();
            const emailFilter = searchEmail.value.toLowerCase();
            const startDateValue = startDate.value ? new Date(startDate.value) : null;
            const endDateValue = endDate.value ? new Date(endDate.value) : null;

            let visibleCount = 0;

            tableRows.forEach(row => {
                const name = row.children[1].textContent.toLowerCase();
                const tc = row.children[3].textContent.toLowerCase();
                const email = row.children[5].textContent.toLowerCase();
                const dateText = row.children[7].textContent.trim();
                const registrationDate = dateText !== 'Belirtilmemiş' ? new Date(dateText.split('.').reverse().join('-')) : null;

                const matchesName = !nameFilter || name.includes(nameFilter);
                const matchesTC = !tcFilter || tc.includes(tcFilter);
                const matchesEmail = !emailFilter || email.includes(emailFilter);
                
                let matchesDate = true;
                if (registrationDate && (startDateValue || endDateValue)) {
                    if (startDateValue && endDateValue) {
                        matchesDate = registrationDate >= startDateValue && registrationDate <= endDateValue;
                    } else if (startDateValue) {
                        matchesDate = registrationDate >= startDateValue;
                    } else if (endDateValue) {
                        matchesDate = registrationDate <= endDateValue;
                    }
                }

                if (matchesName && matchesTC && matchesEmail && matchesDate) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            updateResultMessage(visibleCount);
        }
    </script>
@endsection 