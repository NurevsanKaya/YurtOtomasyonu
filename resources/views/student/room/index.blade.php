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
            </div>
        @else
            <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
                Henüz bir odaya yerleştirilmediniz.
            </div>
        @endif
    </div>
@endsection
