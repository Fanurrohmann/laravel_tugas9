<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDT_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Method untuk membuat transaksi
    public function create(Request $request)
    {
        // Validasi input data
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'ongkir' => 'required|numeric',
            'gross_amount' => 'required|numeric',
        ]);

        // Ambil data produk
        $produk = Produk::findOrFail($request->produk_id);

        // Buat transaksi baru
        $transaction = Transaction::create([
            'produk_id' => $request->produk_id,
            'ongkir' => $request->ongkir,
            'gross_amount' => $request->gross_amount,
            'status' => 'pending',
        ]);

        // Ambil Snap token dari Midtrans
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->gross_amount,
            ],
        ]);

        // Kirimkan snapToken ke halaman yang sama (create)
        return view('transactions.create', compact('produk', 'transaction', 'snapToken'));
    }

    public function store(Request $request)
    {
        // Validasi input data
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'ongkir' => 'required|numeric',
            'gross_amount' => 'required|numeric',
        ]);

        // Ambil data produk
        $produk = Produk::findOrFail($request->produk_id);

        // Buat transaksi baru
        $transaction = Transaction::create([
            'produk_id' => $request->produk_id,
            'ongkir' => $request->ongkir,
            'gross_amount' => $request->gross_amount,
            'status' => 'pending',
        ]);

        // Ambil Snap token dari Midtrans
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->gross_amount,
            ],
        ]);

        // Kirimkan snapToken ke halaman yang sama (create)
        return view('transactions.create', compact('produk', 'transaction', 'snapToken'));
    }

    // Method untuk inisiasi transaksi dan mendapatkan Snap token
    public function initiatePayment(Request $request)
    {
        // Buat transaksi baru di database dengan status pending
        $transaction = Transaction::create([
            'produk_id' => $request->produk_id,
            'ongkir' => $request->ongkir,
            'gross_amount' => $request->gross_amount,
            'status' => 'pending',
        ]);

        // Konfigurasi Snap Midtrans dan dapatkan token pembayaran
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->gross_amount,
            ],
        ]);

        return response()->json(['snapToken' => $snapToken, 'transaction_id' => $transaction->id]);
    }

    // Method untuk mendapatkan Snap token berdasarkan transaction_id
    public function getSnapToken(Request $request)
    {
        $transactionId = $request->query('transaction_id');
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            return response()->json(['error' => 'Transaksi tidak ditemukan.'], 404);
        }

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->gross_amount,
            ],
        ]);

        return response()->json(['snapToken' => $snapToken]);
    }

    // Callback handler dari Midtrans untuk memperbarui status transaksi
    public function handleMidtransCallback(Request $request)
    {
        $transactionId = $request->order_id;
        $transactionStatus = $request->transaction_status;

        $transaction = Transaction::find($transactionId);

        if ($transaction) {
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $transaction->status = 'paid';
            } elseif ($transactionStatus == 'pending') {
                $transaction->status = 'pending';
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $transaction->status = 'failed';
            }
            $transaction->save();
        }

        return response()->json(['status' => 'Transaction status updated']);
    }
}
