<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Dashboard\Products\ProductEdit;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\json;

// ------------Dashboard-------------


Route::get('/dashboard/profil', function () {
    return view('dashboard.edit-profile.index');
})->middleware('auth')->name('dashboard.kategori-produk');

Route::get('/dashboard/aduan-masyarakat', function () {
    return view('dashboard.aduans.index');
})->middleware('auth')->name('dashboard.aduan');

Route::get('/dashboard/pengaturan', function () {
    return view('dashboard.settings.index');
})->middleware('auth')->name('dashboard.pengaturan');

Route::get('/dashboard/tentang-kami', function () {
    return view('dashboard.about.index');
})->middleware('auth')->name('dashboard.tentang-kami');

Route::get('/dashboard/kelola-akun', function () {
    return view('dashboard.users.index');
})->middleware('auth')->name('dashboard.kelola-akun');

Route::get('/dashboard/proyek', function () {
    return view('dashboard.projects.index');
})->middleware('auth')->name('dashboard.kategori-produk');

// Route untuk menampilkan daftar postingan
Route::get('/dashboard/postingan', function () {
    return view('dashboard.posts.index');
})->middleware('auth')->name('dashboard.postingan');

// Route untuk menampilkan form tambah postingan
Route::get('/dashboard/postingan/tambah-data', function () {
    return view('dashboard.posts.create-post');
})->middleware('auth')->name('dashboard.postingan.tambah');

Route::get('/dashboard/kategori-postingan', function () {
    return view('dashboard.categories.post-category');
})->middleware('auth')->name('dashboard.kategori-postingan');

Route::get('/dashboard/tag-postingan', function () {
    return view('dashboard.tags.index');
})->middleware('auth')->name('dashboard.tag-postingan');

Route::get('/dashboard/kategori-produk', function () {
    return view('dashboard.categories.product-category');
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

// Route untuk mengedit post
Route::get('/dashboard/postingan/{slug}/edit', [PostController::class, 'edit'])->middleware('auth')->name('dashboard.post.edit');

// Logout
Route::post('logout', [LogoutController::class, 'destroy'])
->name('logout')->middleware('auth');

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
