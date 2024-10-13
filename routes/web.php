<?php

use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Dashboard\Products\ProductEdit;
use Illuminate\Support\Facades\Route;

// ------------Dashboard-------------

Route::get('/dashboard/profil', function () {
    return view('dashboard.edit-profile.index');
})->middleware('auth')->name('dashboard.kategori-produk');

Route::get('/dashboard/proyek', function () {
    return view('dashboard.projects.index');
})->middleware('auth')->name('dashboard.kategori-produk');

Route::get('/dashboard/kategori-produk', function () {
    return view('dashboard.categories.index');
})->middleware('auth')->name('dashboard.kategori-produk');

// Route untuk menampilkan daftar produk
Route::get('/dashboard/produk', function () {
    return view('dashboard.products.index');
})->middleware('auth')->name('dashboard.produk');

// Route untuk menampilkan form tambah produk
Route::get('/dashboard/produk/tambah-produk', function () {
    return view('dashboard.products.create-product');
})->middleware('auth')->name('dashboard.produk.tambah');

// Route untuk mengedit produk 
Route::get('/dashboard/produk/{id}/edit', [ProductController::class, 'edit'])->middleware('auth')->name('dashboard.produk.edit');

// Route untuk dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard-user');
// })->middleware('auth')->name('dashboard');

// Logout
Route::post('logout', [LogoutController::class, 'destroy'])
->name('logout');


// Route terkait profil
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// -------------Frontend-------------

// Route untuk halaman depan
Route::get('/', function () {
    return view('welcome');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
