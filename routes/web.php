<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\student\AnnouncementController;
use App\Http\Controllers\student\ComplaintController;
use App\Http\Controllers\student\PaymentController;
use App\Http\Controllers\student\PermissionController;
use App\Http\Controllers\student\RefectorController;
use App\Http\Controllers\student\StudentRoomController;
use App\Http\Controllers\student\StudentVisitorController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Welcome');
});

Route::get('/contact', function () {
    return view('contact'); // contact.blade.php dosyasını döndürür
});
Route::get('/about', function () {
    return view('aboutus');
});
Route::get('/room', function () {
    return view('room');
});Route::get('/gallery', function () {
    return view('gallery');
});
Route::get('/oneroom', function () {
    return view('oneroom');
});
Route::get('/tworoom', function () {
    return view('tworoom');
});
Route::get('/threeroom', function () {
    return view('threeroom');
});
Route::get('/fourroom', function () {
    return view('fourroom');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::get('/admin', function() {
    return redirect('/admin/login');
})->middleware(['auth', AdminMiddleware::class]);

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Admin protected routes
Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Öğrenci yönetimi
        Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
        Route::post('/students', [StudentController::class, 'store'])->name('admin.students.store');
        Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
        Route::put('/students/{id}', [StudentController::class, 'update'])->name('admin.students.update');
        Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('admin.students.destroy');

        // Oda yönetimi
        Route::get('/rooms', function() {
            return view('admin.rooms.index');
        })->name('admin.rooms');

        Route::get('rooms', [RoomController::class, 'index'])->name('admin.rooms.index');
        Route::resource('rooms', RoomController::class);



        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');

        // Ödeme yönetimi
        Route::get('/payments', function() {
            return view('admin.payments.index');
        })->name('admin.payments');

        // Duyuru yönetimi
        Route::get('/announcements', function() {
            return view('admin.announcements.index');
        })->name('admin.announcements');

        // Bakım talepleri
        Route::get('/maintenance', function() {
            return view('admin.maintenance.index');
        })->name('admin.maintenance');
    });


// Öğrenci korumalı rotalar
    Route::prefix('student')->middleware(['web', 'auth'])->group(function () {



        // 1. İzin Alma Sistemi
        Route::get('/permission', [PermissionController::class, 'index'])->name('student.izin.index');       // İzin başvurularını listeleme, durum takibi


        // 2. Oda Bilgileri Görüntüleme ve Değişiklik Talebi
        Route::get('/rooms', [StudentRoomController::class, 'index'])->name('student.oda.index');            // Mevcut oda bilgilerini gösterme


        // 3. Yemekhane Takibi ve Menü Görüntüleme
        Route::get('/refector', [RefectorController::class, 'index'])->name('student.menu.index');            // Günlük/haftalık menü, öğün saatleri

        // 4. Aidat ve Borç Takibi
        Route::get('/payment', [PaymentController::class, 'index'])->name('student.aidat.index');         // Aidat geçmişi ve borç bilgileri

        // 5. Ziyaretçi Bildirimi
        Route::get('/visitor', [StudentVisitorController::class, 'index'])->name('student.ziyaretci.index');       // Mevcut ziyaretçi başvurularını listeleme


        // 6. Duyuru Sistemi
        Route::get('/announcement', [AnnouncementController::class, 'index'])->name('student.duyuru.index');      // Duyuruların listesi

        // 7. Dilek ve Şikayet Bildirimi
        Route::get('/complain', [ComplaintController::class, 'index'])->name('student.sikayet.index');       // Dilek/şikayet listesi

    });



});

// İlçeleri getir
Route::get('/district/{city}', function ($city) {
    $districts = \App\Models\District::where('city_id', $city)->get();
    return response()->json($districts);
});

require __DIR__.'/auth.php';

