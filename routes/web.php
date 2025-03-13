<?php

use App\Http\Controllers\ProfileController;
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

require __DIR__.'/auth.php';

