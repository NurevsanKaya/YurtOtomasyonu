<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\RoomController;
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

        // Oda yönetimi
        Route::get('/rooms', function() {
            return view('admin.rooms.index');
        })->name('admin.rooms');

        Route::get('/students', function() {
            return view('admin.students.index');
        })->name('admin.students');

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




});

require __DIR__.'/auth.php';

