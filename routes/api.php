<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\API\RajaOngkirController;
use App\Http\Controllers\API\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//

Route::Resource('categories', CategoryController::class);
Route::Resource('products', ProductController::class);

Route::get('/produk', [ProdukController::class, 'getProducts']);
Route::get('/kategori/produk', [KategoriController::class, 'getCategoriesWithProductCount']);
Route::get('/produk/transaksi', [ProdukController::class, 'getProductTransactionCount']);
Route::get('/pelanggan/transaksi', [PelangganController::class, 'getCustomerTransactionCount']);

Route::get('provinces', [RajaOngkirController::class, 'provinces']);
Route::get('cities/{provinceId}', [RajaOngkirController::class, 'cities']);
Route::post('cost', [RajaOngkirController::class, 'cekOngkir']);

// api.php (untuk API dan callback)
Route::post('/transactions/initiate', [TransactionController::class, 'initiatePayment']);
Route::post('/transactions/callback', [TransactionController::class, 'handleMidtransCallback']);
Route::get('/api/get-snap-token', [TransactionController::class, 'getSnapToken']);



