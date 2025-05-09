@extends('admin.layouts.app')

@section('title', 'Oda Değişikliği Talepleri')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Oda Değişikliği Talepleri</h1>

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

        <div class="overflow-x-auto">
            <div class="max-h-[583px] overflow-y-auto">
                <table class="min-w-full bg-white">
                    <thead class="sticky top-0">
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Öğrenci</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mevcut Oda</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Talep Edilen Oda</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Durum</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Açıklama</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tarih</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($requests as $request)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->user->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $request->currentRoom->room_number ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $request->requestedRoom->room_number ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-sm rounded-full
                                        @if($request->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($request->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $request->admin_message ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $request->created_at->format('d.m.Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($request->status === 'pending')
                                        <form action="{{ route('admin.room-change-requests.approve', $request->id) }}" method="POST" class="inline-block mr-2">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Onayla</button>
                                        </form>
                                        <form action="{{ route('admin.room-change-requests.reject', $request->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <input type="text" name="admin_message" placeholder="Red nedeni" class="border rounded px-2 py-1 text-sm" required>
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded ml-1">Reddet</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 