@extends('admin.layouts.app')

@section('header', 'Rezervasyon Yönetimi')

@section('content')
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
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
@endsection 