@extends('admin.layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Öğrenci Yönetimi</h2>
                    <button onclick="openModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Yeni Öğrenci Ekle
                    </button>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">ID</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Ad</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Soyad</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">TC Kimlik</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Telefon</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Email</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">Oda No</th>
                                <th class="bg-gray-50 sticky top-0 border-b border-gray-200 px-6 py-3 text-gray-600 font-bold tracking-wider uppercase text-xs">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->first_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->tc }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $student->room ? $student->room->room_number : 'Oda Atanmamış' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.students.edit', $student->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Düzenle</a>
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Bu öğrenciyi silmek istediğinizden emin misiniz?')">Sil</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Henüz kayıtlı öğrenci bulunmamaktadır.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Yeni Öğrenci Ekleme Modal -->
<div id="studentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Yeni Öğrenci Ekle</h3>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                
                <!-- Adım Göstergeleri -->
                <div class="flex justify-center mb-4">
                    <div id="step-indicator" class="flex justify-between w-full max-w-3xl">
                        <div class="step-item active" data-step="1">
                            <div class="rounded-full bg-indigo-600 text-white w-8 h-8 flex items-center justify-center">1</div>
                            <span class="text-xs mt-1">Öğrenci Bilgileri</span>
                        </div>
                        <div class="step-item" data-step="2">
                            <div class="rounded-full bg-gray-300 text-gray-700 w-8 h-8 flex items-center justify-center">2</div>
                            <span class="text-xs mt-1">Adres Bilgileri</span>
                        </div>
                        <div class="step-item" data-step="3">
                            <div class="rounded-full bg-gray-300 text-gray-700 w-8 h-8 flex items-center justify-center">3</div>
                            <span class="text-xs mt-1">Veli Bilgileri</span>
                        </div>
                        <div class="step-item" data-step="4">
                            <div class="rounded-full bg-gray-300 text-gray-700 w-8 h-8 flex items-center justify-center">4</div>
                            <span class="text-xs mt-1">Oda Bilgileri</span>
                        </div>
                    </div>
                </div>
                
                <!-- Adım 1: Öğrenci Bilgileri -->
                <div id="step-1" class="form-step">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                                Ad *
                            </label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('first_name') border-red-500 @enderror" required>
                            @error('first_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                                Soyad *
                            </label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror" required>
                            @error('last_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="tc">
                                TC Kimlik No *
                            </label>
                            <input type="text" name="tc" id="tc" value="{{ old('tc') }}" maxlength="11" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tc') border-red-500 @enderror" required>
                            @error('tc')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                                Telefon *
                            </label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror" required placeholder="05XXXXXXXXX">
                            @error('phone')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email *
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="birth_date">
                                Doğum Tarihi *
                            </label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('birth_date') border-red-500 @enderror" required>
                            @error('birth_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="registration_date">
                                Kayıt Tarihi *
                            </label>
                            <input type="date" name="registration_date" id="registration_date" value="{{ old('registration_date', date('Y-m-d')) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('registration_date') border-red-500 @enderror" required>
                            @error('registration_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="emergency_contact">
                                Acil Durum İletişim *
                            </label>
                            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('emergency_contact') border-red-500 @enderror" required placeholder="05XXXXXXXXX">
                            @error('emergency_contact')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="medical_condition">
                                Sağlık Durumu
                            </label>
                            <textarea name="medical_condition" id="medical_condition" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('medical_condition') border-red-500 @enderror" rows="3">{{ old('medical_condition') }}</textarea>
                            @error('medical_condition')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-indigo-600">
                                <span class="text-gray-700 text-sm font-bold">Aktif mi?</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="nextStep(1)" class="bg-indigo-600 text-white px-4 py-2 rounded-md">İleri</button>
                    </div>
                </div>
                
                <!-- Adım 2: Adres Bilgileri -->
                <div id="step-2" class="form-step hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="city_id">
                                Şehir *
                            </label>
                            <select name="city_id" id="city_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('city_id') border-red-500 @enderror" required>
                                <option value="">Şehir Seçin</option>
                                @foreach(\App\Models\City::all() as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="district_id">
                                İlçe *
                            </label>
                            <select name="district_id" id="district_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('district_id') border-red-500 @enderror" required>
                                <option value="">Önce Şehir Seçin</option>
                            </select>
                            @error('district_id')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="postal_code">
                                Posta Kodu *
                            </label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" maxlength="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('postal_code') border-red-500 @enderror" required>
                            @error('postal_code')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4 col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="address_line">
                                Detaylı Adres *
                            </label>
                            <textarea name="address_line" id="address_line" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address_line') border-red-500 @enderror" rows="3" required>{{ old('address_line') }}</textarea>
                            @error('address_line')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(2)" class="bg-gray-500 text-white px-4 py-2 rounded-md">Geri</button>
                        <button type="button" onclick="nextStep(2)" class="bg-indigo-600 text-white px-4 py-2 rounded-md">İleri</button>
                    </div>
                </div>
                
                <!-- Adım 3: Veli Bilgileri -->
                <div id="step-3" class="form-step hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_first_name">
                                Veli Adı *
                            </label>
                            <input type="text" name="guardian_first_name" id="guardian_first_name" value="{{ old('guardian_first_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_first_name') border-red-500 @enderror" required>
                            @error('guardian_first_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_last_name">
                                Veli Soyadı *
                            </label>
                            <input type="text" name="guardian_last_name" id="guardian_last_name" value="{{ old('guardian_last_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_last_name') border-red-500 @enderror" required>
                            @error('guardian_last_name')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_phone">
                                Veli Telefon *
                            </label>
                            <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_phone') border-red-500 @enderror" required placeholder="05XXXXXXXXX">
                            @error('guardian_phone')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_email">
                                Veli Email *
                            </label>
                            <input type="email" name="guardian_email" id="guardian_email" value="{{ old('guardian_email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_email') border-red-500 @enderror" required>
                            @error('guardian_email')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_relationship">
                                Yakınlık Derecesi *
                            </label>
                            <select name="guardian_relationship" id="guardian_relationship" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_relationship') border-red-500 @enderror" required>
                                <option value="">Seçin</option>
                                <option value="Anne" {{ old('guardian_relationship') == 'Anne' ? 'selected' : '' }}>Anne</option>
                                <option value="Baba" {{ old('guardian_relationship') == 'Baba' ? 'selected' : '' }}>Baba</option>
                                <option value="Kardeş" {{ old('guardian_relationship') == 'Kardeş' ? 'selected' : '' }}>Kardeş</option>
                                <option value="Akraba" {{ old('guardian_relationship') == 'Akraba' ? 'selected' : '' }}>Akraba</option>
                                <option value="Diğer" {{ old('guardian_relationship') == 'Diğer' ? 'selected' : '' }}>Diğer</option>
                            </select>
                            @error('guardian_relationship')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(3)" class="bg-gray-500 text-white px-4 py-2 rounded-md">Geri</button>
                        <button type="button" onclick="nextStep(3)" class="bg-indigo-600 text-white px-4 py-2 rounded-md">İleri</button>
                    </div>
                </div>
                
                <!-- Adım 4: Oda Bilgileri -->
                <div id="step-4" class="form-step hidden">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="room_id">
                            Oda *
                        </label>
                        <select name="room_id" id="room_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('room_id') border-red-500 @enderror" required>
                            <option value="">Oda Seçin</option>
                            @if($rooms->count() > 0)
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_number }} - Kapasite: {{ $room->capacity }}, Mevcut: {{ $room->current_occupants }}, Kat: {{ $room->floor }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>Kayıtlı oda bulunmamaktadır</option>
                            @endif
                        </select>
                        @error('room_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        
                        @if($rooms->count() > 0)
                            <p class="text-sm text-gray-500 mt-1">Toplam {{ $rooms->count() }} oda bulunmaktadır</p>
                        @endif
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="button" onclick="prevStep(4)" class="bg-gray-500 text-white px-4 py-2 rounded-md">Geri</button>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md">Öğrenciyi Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function openModal() {
    document.getElementById('studentModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('studentModal').classList.add('hidden');
}

// Modal dışına tıklandığında kapatma
window.onclick = function(event) {
    const modal = document.getElementById('studentModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Form adımları arasında gezinme
function showStep(stepNumber) {
    document.querySelectorAll('.form-step').forEach(step => {
        step.classList.add('hidden');
    });
    document.getElementById('step-' + stepNumber).classList.remove('hidden');
    
    // Adım göstergelerini güncelle
    document.querySelectorAll('.step-item').forEach(item => {
        const itemStep = item.getAttribute('data-step');
        if (itemStep <= stepNumber) {
            item.querySelector('div').classList.remove('bg-gray-300', 'text-gray-700');
            item.querySelector('div').classList.add('bg-indigo-600', 'text-white');
        } else {
            item.querySelector('div').classList.remove('bg-indigo-600', 'text-white');
            item.querySelector('div').classList.add('bg-gray-300', 'text-gray-700');
        }
    });
}

function nextStep(currentStep) {
    // Burada geçerli adımın validasyonunu yapabilirsiniz
    showStep(currentStep + 1);
}

function prevStep(currentStep) {
    showStep(currentStep - 1);
}

// jQuery ile şehir-ilçe ilişkisi
$(document).ready(function() {
    $('#city_id').on('change', function() {
        var city_id = $(this).val();
        
        if (city_id) {
            $.ajax({
                url: '/district/' + city_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#district_id').empty();
                    $('#district_id').append('<option value="">İlçe Seçin</option>');
                    $.each(data, function(key, district) {
                        $('#district_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                    });
                }
            });
        } else {
            $('#district_id').empty();
            $('#district_id').append('<option value="">Önce Şehir Seçin</option>');
        }
    });
    
    // Sayfa yüklendiğinde, eğer şehir seçili ise ilçeleri getir
    var selectedCity = $('#city_id').val();
    if (selectedCity) {
        $('#city_id').trigger('change');
    }
});
</script>
@endsection
