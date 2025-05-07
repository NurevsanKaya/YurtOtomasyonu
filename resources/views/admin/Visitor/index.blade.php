@extends('admin.layouts.app')
@section('content')

    <h2 class="text-2xl font-bold mb-4">Ziyaretçi Talepleri</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100 text-gray-800">
            <tr>
                <th class="py-2 px-4 border-b">Öğrenci</th>
                <th class="py-2 px-4 border-b">Ad Soyad</th>
                <th class="py-2 px-4 border-b">Telefon</th>
                <th class="py-2 px-4 border-b">Ziyaret Nedeni</th>
                <th class="py-2 px-4 border-b">Tarih</th>
                <th class="py-2 px-4 border-b">Durum</th>
                <th class="py-2 px-4 border-b">İşlem</th>
            </tr>
            </thead>
            <tbody>
            @forelse($visitors as $visitor)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">
                        {{ $visitor->student->user->name ?? '-' }}
                    </td>
                    <td class="py-2 px-4 border-b">
                        {{ $visitor->first_name }} {{ $visitor->last_name }}
                    </td>
                    <td class="py-2 px-4 border-b">{{ $visitor->phone }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->visit_reason ?? '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($visitor->check_in)->format('d.m.Y H:i') }}</td>
                    <td class="py-2 px-4 border-b">
                        @if (is_null($visitor->visit_approval))
                            <span class="text-yellow-600 font-semibold">Bekliyor</span>
                        @elseif ($visitor->visit_approval)
                            <span class="text-green-600 font-semibold">Onaylandı</span>
                        @else
                            <span class="text-red-600 font-semibold">Reddedildi</span>
                        @endif
                    </td>

                    <td class="py-2 px-4 border-b flex space-x-2">
                        @if (is_null($visitor->visit_approval))
                            <form method="POST" action="{{ route('admin.visitors.approve', $visitor->id) }}">
                                @csrf
                                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">Onayla</button>
                            </form>

                            <form method="POST" action="{{ route('admin.visitors.reject', $visitor->id) }}">
                                @csrf
                                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Reddet</button>
                            </form>
                        @else
                            <span class="text-gray-500">İşlem Yapıldı</span>
                        @endif
                    </td>

                </tr>
            @empty
                <tr><td colspan="7" class="text-center py-4">Ziyaretçi talebi bulunmamaktadır.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>



@endsection
