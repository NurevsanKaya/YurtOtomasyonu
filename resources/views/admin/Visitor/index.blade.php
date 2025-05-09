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

    <!-- Filtreleme Formu -->
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <form action="{{ route('admin.visitors.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Öğrenci</label>
                <select name="student_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Tümü</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->user?->name ?? 'İsimsiz Öğrenci' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Tümü</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Bekliyor</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Başlangıç Tarihi</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bitiş Tarihi</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            </div>

            <div class="md:col-span-4 flex justify-end space-x-2">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Filtrele
                </button>
                <a href="{{ route('admin.visitors.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Sıfırla
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <div class="max-h-[371px] overflow-y-auto">
            <table class="min-w-full border border-gray-300 text-sm">
                <thead class="bg-gray-100 text-gray-800 sticky top-0">
                <tr>
                    <th class="py-2 px-4 border-b">Öğrenci</th>
                    <th class="py-2 px-4 border-b">Ad Soyad</th>
                    <th class="py-2 px-4 border-b">TC Kimlik No</th>
                    <th class="py-2 px-4 border-b">Telefon</th>
                    <th class="py-2 px-4 border-b">Adres</th>
                    <th class="py-2 px-4 border-b">Ziyaret Nedeni</th>
                    <th class="py-2 px-4 border-b">Giriş Tarihi</th>
                    <th class="py-2 px-4 border-b">Çıkış Tarihi</th>
                    <th class="py-2 px-4 border-b">Durum</th>
                    <th class="py-2 px-4 border-b">İşlem</th>
                </tr>
                </thead>
                <tbody>
                @forelse($visitors as $visitor)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">
                            {{ $visitor->student?->user?->name ?? 'İsimsiz Öğrenci' }}
                        </td>
                        <td class="py-2 px-4 border-b">
                            {{ $visitor->first_name }} {{ $visitor->last_name }}
                        </td>
                        <td class="py-2 px-4 border-b">{{ $visitor->tc }}</td>
                        <td class="py-2 px-4 border-b">{{ $visitor->phone }}</td>
                        <td class="py-2 px-4 border-b">{{ $visitor->address }}</td>
                        <td class="py-2 px-4 border-b">{{ $visitor->visit_reason ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $visitor->check_in->format('d.m.Y H:i') }}</td>
                        <td class="py-2 px-4 border-b">{{ $visitor->check_out ? $visitor->check_out->format('d.m.Y H:i') : '-' }}</td>
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
                    <tr><td colspan="10" class="text-center py-4">Ziyaretçi talebi bulunmamaktadır.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
