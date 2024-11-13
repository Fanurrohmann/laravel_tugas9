<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OngkirController;
use App\Http\Controllers\API\TransactionController;

// Route untuk homepage yang mengarahkan ke dashboard
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

// Route dengan prefix "admin" yang dilindungi oleh middleware "auth"
Route::prefix('admin')->middleware('auth')->group(function () {
    // Route resource untuk kategori, produk, pelanggan, dan transaksi
    Route::resource('kategori', KategoriController::class)->names('kategori');
    Route::resource('produk', ProdukController::class)->names('produk');
    Route::resource('pelanggan', PelangganController::class)->names('pelanggan');
    Route::resource('transaksi', TransaksiController::class)->names('transaksi');

    // Route untuk transaksi
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');  // View untuk create transaksi
    Route::post('/transactions/create', [TransactionController::class, 'store'])->name('transactions.store');  // Proses store transaksi

    // Route untuk memulai pembayaran dan mendapatkan Snap Token
    Route::post('/transactions/initiate-payment', [TransactionController::class, 'initiatePayment'])->name('transactions.initiatePayment');  // Proses pembayaran dan Snap Token

    // Route khusus untuk dashboard admin
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Route untuk Cek Ongkir
    Route::post('/ongkir/cek', [OngkirController::class, 'cekOngkir'])->name('admin.ongkir.cek');
});

// Menambahkan rute Auth default dari Laravel UI
Auth::routes();

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login')->with('success', 'Anda telah berhasil logout.');
})->name('logout');

// Route untuk register
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisterController::class, 'register'])
    ->middleware('guest');

// Auth routes for password reset
Auth::routes(['reset' => true]);

Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

// Test email route (remove in production)
use Illuminate\Support\Facades\Mail;

Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from Laravel!', function ($message) {
        $message->to('alfa@mailtrap.io')
            ->subject('Test Email');
    });
    return 'Test email sent!';
});
