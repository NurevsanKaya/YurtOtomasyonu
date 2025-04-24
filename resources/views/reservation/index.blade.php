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

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Rezervasyon Yap</button>
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
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Gönderme butonunu devre dışı bırak
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Gönderiliyor...';
            
            // Form verilerini al
            const formData = new FormData(form);
            
            // Hata mesajlarını temizle
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.textContent = '';
            });
            document.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // CSRF Token'ı alın
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // AJAX isteği gönder
            fetch('/reservation', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                // Hata kontrolü için HTTP status kodunu kontrol et
                if (!response.ok) {
                    if (response.status === 422) {
                        return response.json(); // Validation hataları
                    }
                    throw new Error('Sunucu hatası: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Sunucu yanıtı:', data);
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Rezervasyon Yap';
                
                if (data.success) {
                    // Başarılı ise formu temizle ve modalı göster
                    form.reset();
                    const modal = new bootstrap.Modal(document.getElementById('reservationSuccessModal'));
                    modal.show();
                } else if (data.errors) {
                    // Validation hatalarını göster
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.getElementById(`${key}_error`);
                        const inputEl = document.getElementById(key);
                        if (errorEl && inputEl) {
                            errorEl.textContent = data.errors[key][0];
                            inputEl.classList.add('is-invalid');
                        }
                    });
                } else if (data.error) {
                    // Genel hata mesajı
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
</script>
@endsection 