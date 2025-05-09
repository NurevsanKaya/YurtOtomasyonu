@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Oda Fiyatları</h1>
        <button onclick="openAddModal()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Yeni Fiyat Ekle
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oda Kapasitesi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aylık Ücret</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($roomPrices as $price)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $price->capacity }} Kişilik</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($price->price, 2) }} TL</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="openEditModal({{ $price->id }}, {{ $price->capacity }}, {{ $price->price }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                            Düzenle
                        </button>
                        <form action="{{ route('admin.room-prices.destroy', $price->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bu fiyatı silmek istediğinizden emin misiniz?')">
                                Sil
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Fiyat Ekleme/Düzenleme Modalı -->
<div id="priceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Yeni Fiyat Ekle</h2>
        <form id="priceForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="methodField" value="POST">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Oda Kapasitesi</label>
                <input type="number" name="capacity" id="capacity" class="w-full border rounded px-3 py-2" required min="1">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Aylık Ücret (TL)</label>
                <input type="number" name="price" id="price" class="w-full border rounded px-3 py-2" required min="0" step="0.01">
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded hover:bg-gray-100">
                    İptal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Yeni Fiyat Ekle';
    document.getElementById('priceForm').reset();
    document.getElementById('priceForm').action = '{{ route("admin.room-prices.store") }}';
    document.getElementById('methodField').value = 'POST';
    document.getElementById('priceModal').classList.remove('hidden');
    document.getElementById('priceModal').classList.add('flex');
}

function openEditModal(id, capacity, price) {
    document.getElementById('modalTitle').textContent = 'Fiyat Düzenle';
    document.getElementById('capacity').value = capacity;
    document.getElementById('price').value = price;
    document.getElementById('priceForm').action = `/admin/room-prices/${id}`;
    document.getElementById('methodField').value = 'PUT';
    document.getElementById('priceModal').classList.remove('hidden');
    document.getElementById('priceModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('priceModal').classList.add('hidden');
    document.getElementById('priceModal').classList.remove('flex');
}
</script>
@endsection 