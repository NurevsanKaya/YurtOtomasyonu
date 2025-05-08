@extends('home')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Rezervasyon Formu</h3>
                </div>
                <div class="card-body">
                    <form id="reservationForm" method="POST" action="{{ route('reservation.store') }}">
                        @csrf
                        
                        <!-- Adım Göstergeleri -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <div class="step-item active" data-step="1">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">1</div>
                                    <span class="small">Öğrenci Bilgileri</span>
                                </div>
                                <div class="step-item" data-step="2">
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">2</div>
                                    <span class="small">Adres Bilgileri</span>
                                </div>
                                <div class="step-item" data-step="3">
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">3</div>
                                    <span class="small">Veli Bilgileri</span>
                                </div>
                                <div class="step-item" data-step="4">
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">4</div>
                                    <span class="small">Oda Bilgileri</span>
                                </div>
                            </div>
                        </div>

                        <!-- Adım 1: Öğrenci Bilgileri -->
                        <div class="form-step" id="step-1">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="first_name">Ad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    <div class="invalid-feedback" id="first_name_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="last_name">Soyad <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    <div class="invalid-feedback" id="last_name_error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tc">TC Kimlik No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="tc" name="tc" maxlength="11" required>
                                    <div class="invalid-feedback" id="tc_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_date">Doğum Tarihi <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                    <div class="invalid-feedback" id="birth_date_error"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">Telefon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                    <div class="invalid-feedback" id="phone_error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email">E-posta <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback" id="email_error"></div>
                                </div>
                            </div>
                        </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="registration_date">Kayıt Tarihi <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="registration_date" name="registration_date" required>
                                        <div class="invalid-feedback" id="registration_date_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="medical_condition">Sağlık Durumu</label>
                                <textarea class="form-control" id="medical_condition" name="medical_condition" rows="3"></textarea>
                                <div class="invalid-feedback" id="medical_condition_error"></div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="emergency_contact">Acil Durum İletişim <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required>
                                <div class="invalid-feedback" id="emergency_contact_error"></div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" onclick="nextStep(1)">İleri</button>
                            </div>
                        </div>

                        <!-- Adım 2: Adres Bilgileri -->
                        <div class="form-step" id="step-2" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="city_id">İl <span class="text-danger">*</span></label>
                                        <select class="form-control" id="city_id" name="city_id" required>
                                            <option value="">İl Seçiniz</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="city_id_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="district_id">İlçe <span class="text-danger">*</span></label>
                                        <select class="form-control" id="district_id" name="district_id" required>
                                            <option value="">İlçe Seçiniz</option>
                                        </select>
                                        <div class="invalid-feedback" id="district_id_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="postal_code">Posta Kodu <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" maxlength="5" required>
                                        <div class="invalid-feedback" id="postal_code_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="address_line">Detaylı Adres <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address_line" name="address_line" rows="3" required></textarea>
                                <div class="invalid-feedback" id="address_line_error"></div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Geri</button>
                                <button type="button" class="btn btn-primary" onclick="nextStep(2)">İleri</button>
                            </div>
                        </div>

                        <!-- Adım 3: Veli Bilgileri -->
                        <div class="form-step" id="step-3" style="display: none;">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guardian_first_name">Veli Adı <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="guardian_first_name" name="guardian_first_name" required>
                                        <div class="invalid-feedback" id="guardian_first_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guardian_last_name">Veli Soyadı <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="guardian_last_name" name="guardian_last_name" required>
                                        <div class="invalid-feedback" id="guardian_last_name_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guardian_phone">Veli Telefon <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="guardian_phone" name="guardian_phone" required>
                                        <div class="invalid-feedback" id="guardian_phone_error"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guardian_email">Veli E-posta <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="guardian_email" name="guardian_email" required>
                                        <div class="invalid-feedback" id="guardian_email_error"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="guardian_relationship">Yakınlık Derecesi <span class="text-danger">*</span></label>
                                <select class="form-control" id="guardian_relationship" name="guardian_relationship" required>
                                    <option value="">Seçiniz</option>
                                    <option value="Anne">Anne</option>
                                    <option value="Baba">Baba</option>
                                    <option value="Kardeş">Kardeş</option>
                                    <option value="Akraba">Akraba</option>
                                    <option value="Diğer">Diğer</option>
                                </select>
                                <div class="invalid-feedback" id="guardian_relationship_error"></div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Geri</button>
                                <button type="button" class="btn btn-primary" onclick="nextStep(3)">İleri</button>
                            </div>
                        </div>

                        <!-- Adım 4: Oda Bilgileri -->
                        <div class="form-step" id="step-4" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="room_id">Oda Seçimi <span class="text-danger">*</span></label>
                            <select class="form-control" id="room_id" name="room_id" required>
                                <option value="">Oda Seçiniz</option>
                                @foreach($rooms as $room)
                                    @php
                                        $isDolu = $room->current_occupants >= $room->capacity;
                                        $dolulukOran = ($room->current_occupants / $room->capacity) * 100;
                                    @endphp
                                    <option value="{{ $room->id }}" 
                                        {{ $isDolu ? 'disabled' : '' }}
                                        data-doluluk="{{ $dolulukOran }}"
                                        data-kapasite="{{ $room->capacity }}"
                                        data-current="{{ $room->current_occupants }}">
                                        {{ $room->room_number }} - {{ $room->room_type }} - 
                                        Kat: {{ $room->floor }} - 
                                        Doluluk: {{ $room->current_occupants }}/{{ $room->capacity }}
                                        {{ $isDolu ? '(DOLU)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="room_id_error"></div>
                        </div>

                        <div class="mb-3" id="dolulukBilgisi" style="display:none;">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" id="odaBaslik"></h5>
                                    <div class="progress mb-3">
                                        <div id="dolulukBar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p id="odaDetay" class="card-text"></p>
                                </div>
                            </div>
                        </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Geri</button>
                                <button type="submit" class="btn btn-success">Rezervasyon Yap</button>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Başarılı Rezervasyon Modalı -->
<div class="modal fade" id="reservationSuccessModal" tabindex="-1" aria-labelledby="reservationSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationSuccessModalLabel">Rezervasyon Alındı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <p>Rezervasyon talebiniz iletildi. En kısa sürede arayarak bilgilendirileceksiniz.</p>
                <p><strong>İletişim:</strong> 0 (312) 000 00 00</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('reservationForm');
    const submitBtn = document.querySelector('button[type="submit"]');
        const roomSelect = document.getElementById('room_id');
        const dolulukBilgisi = document.getElementById('dolulukBilgisi');
        const dolulukBar = document.getElementById('dolulukBar');
        const odaBaslik = document.getElementById('odaBaslik');
        const odaDetay = document.getElementById('odaDetay');
    const citySelect = document.getElementById('city_id');
    const districtSelect = document.getElementById('district_id');

    // İl seçildiğinde ilçeleri getir
    citySelect.addEventListener('change', function() {
        const cityId = this.value;
        if (cityId) {
            fetch(`/get-districts/${cityId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.innerHTML = '<option value="">İlçe Seçiniz</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                    });
                });
        } else {
            districtSelect.innerHTML = '<option value="">İlçe Seçiniz</option>';
        }
    });

        // Oda seçimi değiştiğinde doluluk bilgilerini göster
        roomSelect.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                const doluluk = selectedOption.dataset.doluluk;
                const kapasite = selectedOption.dataset.kapasite;
                const current = selectedOption.dataset.current;
                const odaNo = selectedOption.textContent.split('-')[0].trim();
                
                dolulukBar.style.width = doluluk + '%';
                
                if (doluluk < 50) {
                    dolulukBar.className = 'progress-bar bg-success';
                } else if (doluluk < 75) {
                    dolulukBar.className = 'progress-bar bg-warning';
                } else {
                    dolulukBar.className = 'progress-bar bg-danger';
                }
                
                odaBaslik.textContent = odaNo + ' - Doluluk Durumu';
                odaDetay.textContent = 'Mevcut Kişi: ' + current + ' / Kapasite: ' + kapasite;
                
                dolulukBilgisi.style.display = 'block';
            } else {
                dolulukBilgisi.style.display = 'none';
            }
        });

    // Form gönderimi
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Gönderiliyor...';
            
            const formData = new FormData(form);
            
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });
            document.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('/reservation', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 422) {
                    return response.json();
                    }
                    throw new Error('Sunucu hatası: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Rezervasyon Yap';
                
                if (data.success) {
                    form.reset();
                dolulukBilgisi.style.display = 'none';
                    const modal = new bootstrap.Modal(document.getElementById('reservationSuccessModal'));
                    modal.show();
                } else if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.getElementById(`${key}_error`);
                        const inputEl = document.getElementById(key);
                        if (errorEl && inputEl) {
                            errorEl.textContent = data.errors[key][0];
                            inputEl.classList.add('is-invalid');
                        }
                    });
                } else if (data.error) {
                    alert(data.error);
                }
            })
            .catch(error => {
                console.error('AJAX hatası:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Rezervasyon Yap';
                alert('Bir hata oluştu. Lütfen daha sonra tekrar deneyin. Hata: ' + error.message);
            });
        });
    });

// Form adımları arasında gezinme
function showStep(stepNumber) {
    document.querySelectorAll('.form-step').forEach(step => {
        step.style.display = 'none';
    });
    document.getElementById('step-' + stepNumber).style.display = 'block';

    // Adım göstergelerini güncelle
    document.querySelectorAll('.step-item').forEach(item => {
        const itemStep = parseInt(item.getAttribute('data-step'));
        const circle = item.querySelector('.rounded-circle');
        
        if (itemStep <= stepNumber) {
            circle.classList.remove('bg-secondary');
            circle.classList.add('bg-primary');
        } else {
            circle.classList.remove('bg-primary');
            circle.classList.add('bg-secondary');
        }
    });
}

function nextStep(currentStep) {
    showStep(currentStep + 1);
}

function prevStep(currentStep) {
    showStep(currentStep - 1);
}
</script>
@endsection 