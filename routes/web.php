<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'update'])->name('profile.update');
});


// Route untuk Profile
Route::get('/', [BarangController::class, 'index'])->name('barangs.index');
Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk daftar barang (user dapat melihat daftar barang dan melakukan pembelian)
Route::get('/', [BarangController::class, 'index'])->name('barangs.index');

// Route untuk pembelian barang berdasarkan ID
Route::get('barangs/{id}/beli', [BarangController::class, 'beli'])->name('barangs.beli');

// Route untuk pembelian massal (jika dibutuhkan)
Route::post('/barangs/beli-massa', [BarangController::class, 'beliMassa'])->name('barangs.beli.massa');

// Route untuk melihat detail barang
Route::get('barangs/{barang}', [BarangController::class, 'show'])->name('barangs.show');

// Route untuk menambah barang ke keranjang
Route::post('keranjang/tambah', [BarangController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');

Route::middleware(['auth', 'check.role:admin,supplier'])->group(function () {
    Route::resource('barangs', BarangController::class)->except(['index', 'show']);
    Route::resource('barangs', BarangController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
    Route::get('/barangs/{barang}/edit', [BarangController::class, 'edit'])->name('barangs.edit');
    Route::post('/barangs', [BarangController::class, 'store'])->name('barangs.store');
    Route::patch('/barangs/{barang}', [BarangController::class, 'update'])->name('barangs.update');
    Route::delete('/barangs/{barang}', [BarangController::class, 'destroy'])->name('barangs.destroy');
});

// Route untuk halaman dashboard, mengarahkan berdasarkan role
Route::middleware('auth')->get('/dashboard', function () {
    $user = auth()->user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('barangs.index')->with('success', 'Selamat datang, Admin!');
    } elseif ($user && $user->role === 'supplier') {
        return redirect()->route('barangs.index')->with('success', 'Selamat datang, Supplier!');
    }

    return redirect()->route('barangs.index');
})->name('dashboard');

// Route untuk pembelian massa
Route::post('/barangs/beli/konfirmasi', [BarangController::class, 'beliMassa'])->name('barangs.beli.massa');

// Route untuk halaman konfirmasi pembelian
Route::get('/barangs/beli/konfirmasi', [BarangController::class, 'konfirmasiPembelian'])->name('barangs.beli.konfirmasi');

// Menambahkan route untuk proses pembelian
Route::post('/barangs/beli/proses', [BarangController::class, 'prosesPembelian'])->name('barangs.beli.proses');

// Mengizinkan pengguna tanpa login untuk menambah barang ke keranjang
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
Route::post('/cancel', [CartController::class, 'cancel'])->name('cart.cancel');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/selesai', [CartController::class, 'selesai'])->name('cart.selesai');
Route::get('/cart/download-pdf', [CartController::class, 'downloadPdf'])->name('cart.downloadPdf');

// Route untuk halaman pembayaran berhasil
Route::post('/pembayaran-berhasil/{orderId}', [CartController::class, 'pembayaranBerhasil'])->name('cart.success');

// Route untuk mengunduh PDF
Route::get('pembayaran-berhasil/{id}/download', [CartController::class, 'downloadPdf'])->name('cart.downloadPdf');

Route::middleware(['auth', 'role:admin,supplier'])->group(function () {
    Route::resource('barangs', BarangController::class);
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
});

require __DIR__ . '/auth.php';