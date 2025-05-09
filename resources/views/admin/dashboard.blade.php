@extends('admin.layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- İstatistik Kartları -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Toplam Öğrenci -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Toplam Öğrenci</h2>
                    <p class="text-2xl font-semibold text-gray-800">{{ $totalStudents }}</p>
                </div>
            </div>
        </div>

        <!-- Boş Odalar -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Boş Odalar</h2>
                    <p class="text-2xl font-semibold text-gray-800">{{ $emptyRooms }}</p>
                </div>
            </div>
        </div>

        <!-- Bekleyen Ödemeler -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-gray-600 text-sm">Bekleyen Ödemeler</h2>
                    <p class="text-2xl font-semibold text-gray-800">{{ $pendingPayments }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Son Şikayetler -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Son Şikayetler</h2>
            </div>
            <div class="p-6">
                @if($recentComplaints->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentComplaints as $complaint)
                            <div class="flex items-start space-x-4">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            @if($complaint->student)
                                                {{ $complaint->student->first_name }} {{ $complaint->student->last_name }}
                                            @else
                                                Silinmiş Öğrenci
                                            @endif
                                        </h3>
                                        <span class="text-xs text-gray-500">
                                            {{ $complaint->created_at->format('d.m.Y H:i') }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">{{ $complaint->description }}</p>
                                    <div class="mt-2">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($complaint->status === 'bekliyor')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($complaint->status === 'çözüldü')
                                                bg-green-100 text-green-800
                                            @else
                                                bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Henüz şikayet bulunmuyor.</p>
                @endif
            </div>
        </div>

        <!-- Son Ödemeler -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Son Ödemeler</h2>
            </div>
            <div class="p-6">
                @if($recentPayments->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentPayments as $payment)
                            <div class="flex items-start space-x-4">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ $payment->student->first_name }} {{ $payment->student->last_name }}
                                        </h3>
                                        <span class="text-xs text-gray-500">
                                            {{ $payment->created_at->format('d.m.Y H:i') }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ number_format($payment->amount, 2) }} TL - {{ ucfirst($payment->payment_type) }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($payment->payment_status === 'bekliyor')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($payment->payment_status === 'onaylandı')
                                                bg-green-100 text-green-800
                                            @else
                                                bg-red-100 text-red-800
                                            @endif
                                        ">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Henüz ödeme bulunmuyor.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
