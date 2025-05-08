@extends('student.layouts.dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Borçlarım ve Ödemelerim</h1>

    <div class="grid gap-6">
        @foreach($debts as $debt)
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold">{{ $debt->description }}</h2>
                    <p class="text-gray-600">Tutar: {{ number_format($debt->amount, 2) }} TL</p>
                </div>
                <div>
                    @if($debt->status === 'bekliyor')
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Bekliyor</span>
                    @elseif($debt->status === 'ödendi')
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">Ödendi</span>
                    @else
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Ödüyor</span>
                    @endif
                </div>
            </div>

            @if($debt->status !== 'ödendi')
                <button onclick="openPaymentModal({{ $debt->id }})" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Ödeme Yap
                </button>
            @endif

            @if($debt->payments->count() > 0)
                <div class="mt-4">
                    <h3 class="font-semibold mb-2">Ödeme Geçmişi</h3>
                    <div class="space-y-2">
                        @foreach($debt->payments as $payment)
                            <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                                <div>
                                    <p class="text-sm">{{ $payment->created_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-sm">{{ number_format($payment->amount, 2) }} TL - {{ $payment->payment_type }}</p>
                                </div>
                                <div>
                                    @if($payment->payment_status === 'bekliyor')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Onay Bekliyor</span>
                                    @elseif($payment->payment_status === 'onaylandı')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Onaylandı</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">
                                            Reddedildi: {{ $payment->rejection_reason }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<!-- Ödeme Modalı -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Ödeme Yap</h2>
        <form action="{{ route('student.payments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="debt_id" id="debt_id">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Ödeme Türü</label>
                <select name="payment_type" id="payment_type" class="w-full border rounded px-3 py-2" onchange="toggleReceiptUpload()">
                    <option value="nakit">Nakit</option>
                    <option value="havale">Havale</option>
                </select>
            </div>

            <div id="receiptUpload" class="mb-4 hidden">
                <label class="block text-gray-700 text-sm font-bold mb-2">Dekont Yükle</label>
                <input type="file" name="receipt" class="w-full border rounded px-3 py-2" accept=".pdf,.jpg,.jpeg,.png">
                <p class="text-sm text-gray-500 mt-1">PDF, JPG veya PNG formatında, max 2MB</p>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closePaymentModal()" class="px-4 py-2 border rounded hover:bg-gray-100">
                    İptal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Ödeme Yap
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openPaymentModal(debtId) {
    document.getElementById('debt_id').value = debtId;
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentModal').classList.add('flex');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    document.getElementById('paymentModal').classList.remove('flex');
}

function toggleReceiptUpload() {
    const paymentType = document.getElementById('payment_type').value;
    const receiptUpload = document.getElementById('receiptUpload');
    
    if (paymentType === 'havale') {
        receiptUpload.classList.remove('hidden');
    } else {
        receiptUpload.classList.add('hidden');
    }
}
</script>
@endpush
@endsection 