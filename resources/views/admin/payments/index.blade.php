@extends('admin.layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Ödeme Yönetimi</h2>
                        <button type="button" onclick="openPaymentModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Yeni Ödeme Ekle
                        </button>
                    </div>

                    <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                        <table class="w-full">
                            <thead>
                            <tr class="text-left">
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Öğrenci</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Ödeme Tarihi</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Tutar</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Ödeme Türü</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Durum</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İşlemler</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($payments as $payment)
                                <tr>
                                    <td class="border-t px-6 py-4">
                                        {{ $payment->student->first_name }} {{ $payment->student->last_name }}
                                    </td>
                                    <td class="border-t px-6 py-4">
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}
                                    </td>
                                    <td class="border-t px-6 py-4">
                                        ₺{{ number_format($payment->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="border-t px-6 py-4">
                                        {{ $payment->payment_type }}
                                    </td>
                                    <td class="border-t px-6 py-4">
                                        @if ($payment->payment_status == 'Ödendi')
                                            <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">
                                                {{ $payment->payment_status }}
                                            </span>
                                        @elseif($payment->payment_status == 'İptal')
                                            <span class="px-2 py-1 text-sm rounded-full bg-red-100 text-red-800">
                                                {{ $payment->payment_status }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                                                {{ $payment->payment_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="border-t px-6 py-4">
                                        <div class="flex space-x-3">
                                            <button type="button" onclick="openEditModal({{ $payment->id }})" class="text-blue-600 hover:text-blue-900">
                                                Düzenle
                                            </button>
                                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Emin misiniz?')">
                                                    Sil
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yeni Ödeme Ekleme Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Yeni Ödeme Ekle</h3>
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Öğrenci</label>
                        <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Öğrenci Seçin</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Tutar</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="payment_date" class="block text-sm font-medium text-gray-700">Ödeme Tarihi</label>
                        <input type="date" name="payment_date" id="payment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="block text-sm font-medium text-gray-700">Son Ödeme Tarihi</label>
                        <input type="date" name="due_date" id="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="payment_type" class="block text-sm font-medium text-gray-700">Ödeme Türü</label>
                        <select name="payment_type" id="payment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Ödeme Türü Seçin</option>
                            <option value="Nakit">Nakit</option>

                            <option value="Diğer">Diğer</option>
                        </select>
                        @error('payment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="payment_status" class="block text-sm font-medium text-gray-700">Ödeme Durumu</label>
                        <select name="payment_status" id="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Durum Seçin</option>
                            <option value="Ödendi">Ödendi</option>
                            <option value="Beklemede">Beklemede</option>
                            <option value="İptal">İptal</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            İptal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Kaydet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ödeme Düzenleme Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ödeme Düzenle</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_student_id" class="block text-sm font-medium text-gray-700">Öğrenci</label>
                        <select name="student_id" id="edit_student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Öğrenci Seçin</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_amount" class="block text-sm font-medium text-gray-700">Tutar</label>
                        <input type="number" step="0.01" name="amount" id="edit_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_payment_date" class="block text-sm font-medium text-gray-700">Ödeme Tarihi</label>
                        <input type="date" name="payment_date" id="edit_payment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_due_date" class="block text-sm font-medium text-gray-700">Son Ödeme Tarihi</label>
                        <input type="date" name="due_date" id="edit_due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_payment_type" class="block text-sm font-medium text-gray-700">Ödeme Türü</label>
                        <select name="payment_type" id="edit_payment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Ödeme Türü Seçin</option>
                            <option value="Nakit">Nakit</option>

                            <option value="Diğer">Diğer</option>
                        </select>
                        @error('payment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="edit_payment_status" class="block text-sm font-medium text-gray-700">Ödeme Durumu</label>
                        <select name="payment_status" id="edit_payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Durum Seçin</option>
                            <option value="Ödendi">Ödendi</option>
                            <option value="Beklemede">Beklemede</option>
                            <option value="İptal">İptal</option>
                        </select>
                        @error('payment_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            İptal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Güncelle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        function openEditModal(paymentId) {
            // Ödeme bilgilerini getir
            fetch(`/admin/payments/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    // Form alanlarını doldur
                    document.getElementById('edit_student_id').value = data.student_id;
                    document.getElementById('edit_amount').value = data.amount;
                    document.getElementById('edit_payment_date').value = data.payment_date;
                    document.getElementById('edit_due_date').value = data.due_date;
                    document.getElementById('edit_payment_type').value = data.payment_type;
                    document.getElementById('edit_payment_status').value = data.payment_status;

                    // Form action'ını güncelle
                    document.getElementById('editForm').action = `/admin/payments/${paymentId}`;

                    // Modal'ı göster
                    document.getElementById('editModal').classList.remove('hidden');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // Modal dışına tıklandığında kapatma
        window.onclick = function(event) {
            const paymentModal = document.getElementById('paymentModal');
            const editModal = document.getElementById('editModal');

            if (event.target == paymentModal) {
                closePaymentModal();
            }
            if (event.target == editModal) {
                closeEditModal();
            }
        }
    </script>
@endsection

