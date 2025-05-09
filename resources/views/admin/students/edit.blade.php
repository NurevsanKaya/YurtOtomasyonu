@extends('admin.layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Öğrenci Düzenle</h2>
                    <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Geri Dön
                    </a>
                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Öğrenci Bilgileri -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Öğrenci Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">
                            Ad
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('first_name') border-red-500 @enderror" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">
                            Soyad
                        </label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('last_name') border-red-500 @enderror" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="tc">
                            TC Kimlik No
                        </label>
                        <input type="text" name="tc" id="tc" value="{{ old('tc', $student->tc) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tc') border-red-500 @enderror" required>
                        @error('tc')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">
                            Telefon
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror" required>
                        @error('phone')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="birth_date">
                            Doğum Tarihi
                        </label>
                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $student->birth_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('birth_date') border-red-500 @enderror" required>
                        @error('birth_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="registration_date">
                            Kayıt Tarihi
                        </label>
                        <input type="date" name="registration_date" id="registration_date" value="{{ old('registration_date', $student->registration_date) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('registration_date') border-red-500 @enderror" required>
                        @error('registration_date')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="medical_condition">
                            Sağlık Durumu
                        </label>
                        <textarea name="medical_condition" id="medical_condition" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('medical_condition') border-red-500 @enderror" rows="3">{{ old('medical_condition', $student->medical_condition) }}</textarea>
                        @error('medical_condition')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="emergency_contact">
                            Acil Durum İletişim
                        </label>
                        <input type="text" name="emergency_contact" id="emergency_contact" value="{{ old('emergency_contact', $student->emergency_contact) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('emergency_contact') border-red-500 @enderror" required>
                        @error('emergency_contact')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                        </div>
                    </div>

                    <!-- Adres Bilgileri -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Adres Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="city_id">
                                    Şehir
                                </label>
                                <select name="city_id" id="city_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('city_id') border-red-500 @enderror" required>
                                    <option value="">Şehir Seçin</option>
                                    @foreach(\App\Models\City::all() as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $student->address->district->city_id ?? '') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="district_id">
                                    İlçe
                                </label>
                                <select name="district_id" id="district_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('district_id') border-red-500 @enderror" required>
                                    <option value="">Önce Şehir Seçin</option>
                                </select>
                                @error('district_id')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4 col-span-2">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="address_line">
                                    Adres
                                </label>
                                <textarea name="address_line" id="address_line" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address_line') border-red-500 @enderror" required>{{ old('address_line', $student->address->address_line ?? '') }}</textarea>
                                @error('address_line')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="postal_code">
                                    Posta Kodu
                                </label>
                                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $student->address->postal_code ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('postal_code') border-red-500 @enderror" required>
                                @error('postal_code')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Veli Bilgileri -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Veli Bilgileri</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_first_name">
                                    Veli Adı
                                </label>
                                <input type="text" name="guardian_first_name" id="guardian_first_name" value="{{ old('guardian_first_name', $student->guardians->first()->first_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_first_name') border-red-500 @enderror" required>
                                @error('guardian_first_name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_last_name">
                                    Veli Soyadı
                                </label>
                                <input type="text" name="guardian_last_name" id="guardian_last_name" value="{{ old('guardian_last_name', $student->guardians->first()->last_name ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_last_name') border-red-500 @enderror" required>
                                @error('guardian_last_name')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_phone">
                                    Veli Telefon
                                </label>
                                <input type="text" name="guardian_phone" id="guardian_phone" value="{{ old('guardian_phone', $student->guardians->first()->phone ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_phone') border-red-500 @enderror" required>
                                @error('guardian_phone')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_email">
                                    Veli Email
                                </label>
                                <input type="email" name="guardian_email" id="guardian_email" value="{{ old('guardian_email', $student->guardians->first()->email ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_email') border-red-500 @enderror" required>
                                @error('guardian_email')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="guardian_relationship">
                                    Yakınlık Derecesi
                                </label>
                                <select name="guardian_relationship" id="guardian_relationship" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('guardian_relationship') border-red-500 @enderror" required>
                                    <option value="">Seçin</option>
                                    <option value="Anne" {{ old('guardian_relationship', $student->guardians->first()->relationship ?? '') == 'Anne' ? 'selected' : '' }}>Anne</option>
                                    <option value="Baba" {{ old('guardian_relationship', $student->guardians->first()->relationship ?? '') == 'Baba' ? 'selected' : '' }}>Baba</option>
                                    <option value="Kardeş" {{ old('guardian_relationship', $student->guardians->first()->relationship ?? '') == 'Kardeş' ? 'selected' : '' }}>Kardeş</option>
                                    <option value="Akraba" {{ old('guardian_relationship', $student->guardians->first()->relationship ?? '') == 'Akraba' ? 'selected' : '' }}>Akraba</option>
                                    <option value="Diğer" {{ old('guardian_relationship', $student->guardians->first()->relationship ?? '') == 'Diğer' ? 'selected' : '' }}>Diğer</option>
                                </select>
                                @error('guardian_relationship')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Oda Bilgileri -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Oda Bilgileri</h3>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="room_id">
                            Oda
                        </label>
                        <select name="room_id" id="room_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('room_id') border-red-500 @enderror">
                            <option value="">Oda Seçin</option>
                            @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id', $student->room_id) == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_number }} - Kapasite: {{ $room->capacity }}, Mevcut: {{ $room->current_occupants }}, Kat: {{ $room->floor }}
                                    </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');
    const currentDistrictId = '{{ old('district_id', $student->address->district_id ?? '') }}';

    // Şehir değiştiğinde ilçeleri getir
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        if (cityId) {
            fetch(`/district/${cityId}`)
                .then(response => response.json())
                .then(districts => {
                    districtSelect.innerHTML = '<option value="">İlçe Seçin</option>';
                    districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        if (district.id == currentDistrictId) {
                            option.selected = true;
                        }
                        districtSelect.appendChild(option);
                    });
                });
        } else {
            districtSelect.innerHTML = '<option value="">Önce Şehir Seçin</option>';
        }
    });

    // Sayfa yüklendiğinde mevcut şehir seçili ise ilçeleri getir
    if (citySelect.value) {
        citySelect.dispatchEvent(new Event('change'));
    }
});
</script>


@endsection 