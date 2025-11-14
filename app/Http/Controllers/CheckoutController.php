<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Tampilkan form checkout
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }
        return view('checkout.index', compact('cart'));
    }

    // Proses checkout
public function placeOrder(Request $request)
{
    $request->validate([
        'no_wa' => 'required|string|max:20',
        'alamat' => 'required|string|max:500',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('warning', 'Keranjang masih kosong!');
    }

    // -----------------------------
    // CEK STOK SEMUA ITEM DULU
    // -----------------------------
    foreach ($cart as $variant_id => $item) {
        $variant = ProductVariant::find($variant_id);

        if (!$variant) {
            return back()->with('error', "Produk tidak ditemukan!");
        }

        if ($variant->stok < $item['qty']) {
            return back()->with('error', "Stok untuk ukuran {$variant->ukuran} tidak cukup!");
        }
    }

    // Hitung total
    $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);

    DB::beginTransaction();

    try {
        // Buat order
        $order = Order::create([
            'user_id'       => Auth::id(),
            'nama_pelanggan'=> Auth::user()->name,
            'no_wa'         => $request->no_wa,
            'alamat'        => $request->alamat,
            'total_harga'   => $total,
            'status'        => 'pending',
            'payment_status'=> 'pending',
        ]);

        // Simpan item order
        foreach ($cart as $variant_id => $item) {

            OrderItem::create([
                'order_id'   => $order->id,
                'variant_id' => $variant_id,
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
            ]);

            // -----------------------------
            // KURANGI STOK (AMAN)
            // -----------------------------
            ProductVariant::where('id', $variant_id)
                ->where('stok', '>=', $item['qty'])  // pastikan stok cukup
                ->decrement('stok', $item['qty']);
        }

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
    }

    // Kosongkan keranjang
    session()->forget('cart');

    return redirect()->route('checkout.success', $order->id)
        ->with('success', 'Pesanan berhasil dibuat!');
}

    // Halaman sukses checkout
    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validasi file
        $request->validate([
            'bukti_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file ke folder storage/app/public/payments
        $path = $request->file('bukti_payment')->store('payments', 'public');

        // Update order
        $order->update([
            'bukti_payment' => $path,
            'payment_status' => 'paid',
        ]);

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah!');
    }
}
