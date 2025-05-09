@extends('admin.layouts.app')

@section('header', 'Rezervasyon Yönetimi')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('student_password'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="font-bold">Yeni Oluşturulan Hesap Bilgileri:</span>
            <ul class="mt-2">
                <li><strong>E-posta:</strong> {{ session('student_email') }}</li>
                <li><strong>TC Kimlik No:</strong> {{ session('student_tc') }}</li>
                <li><strong>İlk Şifresi (TC):</strong> {{ session('student_password') }}</li>
            </ul>
            <p class="mt-2 text-sm italic">
                Bu bilgiler sadece bir kez gösterilecektir. Öğrenciye iletmeyi unutmayınız!
            </p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Ad</th>
                    <th class="py-3 px-6 text-left">Soyad</th>
                    <th class="py-3 px-6 text-left">TC</th>
                    <th class="py-3 px-6 text-left">Telefon</th>
                    <th class="py-3 px-6 text-left">E-posta</th>
                    <th class="py-3 px-6 text-left">Oda</th>
                    <th class="py-3 px-6 text-left">Kayıt Tarihi</th>
                    <th class="py-3 px-6 text-center">Durum</th>
                    <th class="py-3 px-6 text-center">İşlemler</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach($reservations as $reservation)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6 text-left">{{ $reservation->id }}</td>
                    <td class="py-3 px-6 text-left">{{ $reservation->first_name }}</td>
                    <td class="py-3 px-6 text-left">{{ $reservation->last_name }}</td>
                    <td class="py-3 px-6 text-left">{{ $reservation->tc }}</td>
                    <td class="py-3 px-6 text-left">{{ $reservation->phone }}</td>
                    <td class="py-3 px-6 text-left">{{ $reservation->email }}</td>
                    <td class="py-3 px-6 text-left">
                        @if($reservation->room)
                            <span class="tooltip" title="Kapasite: {{ $reservation->room->capacity }}, Doluluk: {{ $reservation->room->current_occupants }}">
                                {{ $reservation->room->room_number }} - {{ $reservation->room->room_type }}
                                <span class="text-xs ml-1">
                                    ({{ $reservation->room->current_occupants }}/{{ $reservation->room->capacity }})
                                </span>
                            </span>
                        @else
                            <span class="text-red-500">Oda Seçilmemiş</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">
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
                    <td class="py-3 px-6 text-center">
                        @if($reservation->status == 'beklemede')
                            <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Beklemede</span>
                        @elseif($reservation->status == 'onaylandı')
                            <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Onaylandı</span>
                        @elseif($reservation->status == 'reddedildi')
                            <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Reddedildi</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($reservation->status == 'beklemede')
                            <div class="flex items-center justify-center space-x-2">
                                <button type="button" class="bg-blue-500 text-white py-1 px-2 rounded text-xs hover:bg-blue-600 flex items-center" onclick="showReservationDetails({{ $reservation->id }})">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detay
                                </button>
                                <form action="{{ route('admin.reservations.approve', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white py-1 px-2 rounded text-xs hover:bg-green-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Onayla
                                    </button>
                                </form>
                                <form action="{{ route('admin.reservations.reject', $reservation->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded text-xs hover:bg-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
    </script>
@endsection 