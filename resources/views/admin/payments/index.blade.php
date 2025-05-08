@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Ödeme Başvuruları</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Öğrenci</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borç Açıklaması</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ödeme Türü</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($payments as $payment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payment->student)
                            {{ $payment->student->first_name }} {{ $payment->student->last_name }}
                        @else
                            <span class="text-red-500">Öğrenci bilgisi bulunamadı</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($payment->debt)
                            {{ $payment->debt->description }}
                        @else
                            <span class="text-red-500">Borç bilgisi bulunamadı</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ number_format($payment->amount, 2) }} TL
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ ucfirst($payment->payment_type) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $payment->created_at->format('d.m.Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payment->payment_status === 'bekliyor')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Onay Bekliyor</span>
                        @elseif($payment->payment_status === 'onaylandı')
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Onaylandı</span>
                        @else
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                Reddedildi: {{ $payment->rejection_reason }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($payment->payment_status === 'bekliyor')
                            <button onclick="approvePayment({{ $payment->id }})" class="text-green-600 hover:text-green-900 mr-3">
                                Onayla
                            </button>
                            <button onclick="openRejectModal({{ $payment->id }})" class="text-red-600 hover:text-red-900">
                                Reddet
                            </button>
                        @endif
                        @if($payment->receipt_path)
                            <a href="{{ route('admin.payments.show-receipt', $payment->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 ml-3">
                                Dekontu Görüntüle
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Red Modalı -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Ödemeyi Reddet</h2>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Red Nedeni</label>
                <textarea name="rejection_reason" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border rounded hover:bg-gray-100">
                    İptal
                </button>
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Reddet
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function approvePayment(id) {
    if (confirm('Bu ödemeyi onaylamak istediğinizden emin misiniz?')) {
        window.location.href = `/admin/payments/${id}/approve`;
    }
}

function openRejectModal(id) {
    document.getElementById('rejectForm').action = `/admin/payments/${id}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.getElementById('rejectModal').classList.add('flex');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('rejectModal').classList.remove('flex');
}
</script>
@endpush
@endsection

