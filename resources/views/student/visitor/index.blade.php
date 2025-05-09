@extends('student.layouts.dashboard')

@section('title', 'Duyurular')
@section('content')

    <!-- Yeni Ziyaretçi Talep Butonu -->
    <div class="flex justify-end mb-4">
        <button onclick="openModal()"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Yeni Ziyaretçi Talebi
        </button>
    </div>

    <!-- Modal -->
    <div id="visitorModal" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-xl">&times;</button>

            <h2 class="text-lg font-semibold mb-4">Yeni Ziyaretçi Talebi</h2>

            <form method="POST" action="{{ route('student.visitors.store') }}">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="first_name" placeholder="Ad" class="border p-2 rounded" required>
                    <input type="text" name="last_name" placeholder="Soyad" class="border p-2 rounded" required>
                    <input type="text" name="phone" placeholder="Telefon" class="border p-2 rounded" required>
                    <input type="text" name="tc" placeholder="TC Kimlik No (Opsiyonel)" class="border p-2 rounded">
                    <textarea name="address" placeholder="Adres" class="border p-2 rounded col-span-2"></textarea>
                    <textarea name="visit_reason" placeholder="Ziyaret Nedeni" class="border p-2 rounded col-span-2"></textarea>
                    
                    <!-- Giriş Tarihi ve Saati -->
                    <div class="col-span-2 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Giriş Tarihi</label>
                            <input type="date" name="check_in_date" class="border p-2 rounded w-full" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Giriş Saati</label>
                            <input type="time" name="check_in_time" class="border p-2 rounded w-full" required>
                        </div>
                    </div>

                    <!-- Çıkış Tarihi ve Saati -->
                    <div class="col-span-2 grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Çıkış Tarihi</label>
                            <input type="date" name="check_out_date" class="border p-2 rounded w-full" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Çıkış Saati</label>
                            <input type="time" name="check_out_time" class="border p-2 rounded w-full" required>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Talebi Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Dinamik Tablo -->
    <div class="overflow-x-auto max-w-[1100px] mx-auto">
        <table class="w-full border border-gray-300 text-sm">
            <thead class="bg-gray-100 text-gray-800">
                <tr>
                    <th class="py-3 px-4 border-b text-left">Adı</th>
                    <th class="py-3 px-4 border-b text-left">Soyadı</th>
                    <th class="py-3 px-4 border-b text-left">Telefon</th>
                    <th class="py-3 px-4 border-b text-left">TC</th>
                    <th class="py-3 px-4 border-b text-left">Adresi</th>
                    <th class="py-3 px-4 border-b text-left">Ziyaret Nedeni</th>
                    <th class="py-3 px-4 border-b text-left">Giriş Tarihi</th>
                    <th class="py-3 px-4 border-b text-left">Çıkış Tarihi</th>
                    <th class="py-3 px-4 border-b text-left">Ziyaret Onayı</th>
                </tr>
            </thead>
            <tbody>
            @forelse($visitors as $visitor)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b">{{ $visitor->first_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->last_name }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->phone }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->tc ?? '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->address ?? '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->visit_reason ?? '-' }}</td>
                    <td class="py-2 px-4 border-b">{{ $visitor->check_in ? $visitor->check_in->format('d.m.Y H:i') : '-' }}</td>
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
                </tr>
            @empty
                <tr><td colspan="9" class="text-center py-4">Henüz ziyaretçi kaydınız bulunmamaktadır.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function openModal() {
            document.getElementById('visitorModal').classList.remove('hidden');
            document.getElementById('visitorModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('visitorModal').classList.remove('flex');
            document.getElementById('visitorModal').classList.add('hidden');
        }
    </script>

@endsection
