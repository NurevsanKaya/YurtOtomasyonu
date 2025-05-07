<?php

use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\student\AnnouncementController;
use App\Http\Controllers\student\ComplaintController;
use App\Http\Controllers\student\PermissionController;
use App\Http\Controllers\student\RefectorController;
use App\Http\Controllers\student\StudentPaymentController;
use App\Http\Controllers\student\StudentRoomController;
use App\Http\Controllers\student\StudentVisitorController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\ForcePasswordChange;

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



// Dashboard route'u global tanımlamasını kaldırıyorum çünkü artık ForcePasswordChange içinde tanımlandı
// Route::get('/dashboard', function () {
//    return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ForcePasswordChange middleware'i sadece giriş yapmış kullanıcılara uygulanacak
    Route::middleware([ForcePasswordChange::class])->group(function () {
        // Şifre değişikliği gereken kullanıcılar için erişim kısıtlaması olan rotalar
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Öğrenci rotaları
        Route::prefix('student')->group(function () {
            Route::get('/permission', [PermissionController::class, 'index'])->name('student.izin.index');
            Route::post('/izin-basvuru', [PermissionController::class, 'store'])->name('izin.store');
            Route::get('/izin', [PermissionController::class, 'index'])->name('izin.index');



            Route::get('/rooms', [StudentRoomController::class, 'index'])->name('student.oda.index');

            Route::get('/aidat', [StudentPaymentController::class, 'index'])->name('student.aidat.index');
            Route::get('/visitor', [StudentVisitorController::class, 'index'])->name('student.visitors.index');
            Route::get('/visitors/create', [StudentVisitorController::class, 'create'])->name('student.visitors.create');
            Route::post('/visitors', [StudentVisitorController::class, 'store'])->name('student.visitors.store');
            Route::get('/duyuru', [App\Http\Controllers\student\AnnouncementController::class, 'index'])->name('student.duyuru.index');
            Route::get('/complain', [ComplaintController::class, 'index'])->name('student.sikayet.index');

        });
    });
});

// Admin routes
Route::get('/admin', function() {
    return redirect('/admin/login');
})->middleware(['auth', AdminMiddleware::class]);

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');

// Admin rotaları
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

        Route::post('/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
        Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('admin.rooms.update');
        Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

        // Ödeme yönetimi
        Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');
        Route::post('/payments', [PaymentController::class, 'store'])->name('admin.payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('admin.payments.show');
        Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('admin.payments.edit');
        Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('admin.payments.update');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('admin.payments.destroy');

        // Duyuru yönetimi
        Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('admin.announcements.index');
        Route::get('/announcements/create', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('admin.announcements.create');
        Route::post('/announcements', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('admin.announcements.store');
        Route::get('/announcements/{announcement}/edit', [App\Http\Controllers\AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
        Route::put('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'update'])->name('admin.announcements.update');
        Route::delete('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

        // Bakım talepleri
        Route::get('/maintenance', function() {
            return view('admin.maintenance.index');
        })->name('admin.maintenance');

        //Rezervasyon Talepleri
        Route::get('/reservations', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
        Route::post('/reservations/{reservation}/approve', [AdminReservationController::class, 'approve'])->name('admin.reservations.approve');
        Route::post('/reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])->name('admin.reservations.reject');
         //ziyaretci talepleri
        Route::get('/visitors', [\App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('admin.visitors.index');
        Route::post('/visitors/{id}/approve', [VisitorController::class, 'approve'])->name('admin.visitors.approve');

        Route::post('/visitors/{id}/reject', [VisitorController::class, 'reject'])->name('admin.visitors.reject');

        //izin talepleri
        Route::get('/permission', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('admin.permission.index');
        Route::post('/admin/leaves/{id}/approve', [\App\Http\Controllers\Admin\PermissionController::class, 'approve'])->name('admin.leaves.approve');
        Route::post('/admin/leaves/{id}/reject', [\App\Http\Controllers\Admin\PermissionController::class, 'reject'])->name('admin.leaves.reject');
    });
});

// İlçeleri getir
Route::get('/district/{city}', function ($city) {
    $districts = \App\Models\District::where('city_id', $city)->get();
    return response()->json($districts);
});

// Rezervasyon rotası
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

// Şifre Değiştirme Rotaları - Bu rotalar ForcePasswordChange middleware kapsamı dışında olmalı
Route::middleware(['auth'])->group(function () {
    Route::get('/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [ProfileController::class, 'changePassword'])->name('password.change.save');
});

require __DIR__.'/auth.php';

