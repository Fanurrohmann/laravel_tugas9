<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total penjualan bulanan berdasarkan kolom 'gross_amount'
        $totalPenjualanBulanan = Transaction::whereMonth('created_at', Carbon::now()->month)
            ->sum('gross_amount');

        // Total jumlah pesanan
        $totalPesanan = Order::count();

        // Total jumlah pengguna
        $totalPengguna = User::count();

        // Jumlah pesanan dengan status 'pending'
        $pesananPending = Order::where('status', 'pending')->count();

        // Transaksi terbaru dengan pengurutan waktu pembuatan
        $transaksiTerbaru = Transaction::orderBy('created_at', 'desc')->take(5)->get();

        // Kirim data ke view dashboard
        return view('pages.admin.dashboard', [
            'totalPenjualanBulanan' => $totalPenjualanBulanan,
            'totalPesanan' => $totalPesanan,
            'totalPengguna' => $totalPengguna,
            'pesananPending' => $pesananPending,
            'transaksiTerbaru' => $transaksiTerbaru,
        ]);
    }
}
