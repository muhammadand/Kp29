<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan halaman checkout
    public function showCheckout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang masih kosong!');
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

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);

        // Buat order baru
        $order = Order::create([
            'user_id' => Auth::id(),
            'nama_pelanggan' => Auth::user()->name, // ← tambahkan ini
            'no_wa' => $request->no_wa,
            'alamat' => $request->alamat,
            'total_harga' => $total,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);


        // Simpan item order
        foreach ($cart as $variant_id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'], // ⛔ kolom ini ga ada di DB
                'variant_id' => $variant_id,
                'qty' => $item['qty'],
                'harga' => $item['harga'],
            ]);


            // Kurangi stok produk
            $variant = ProductVariant::find($variant_id);
            if ($variant) {
                $variant->stok -= $item['qty'];
                $variant->save();
            }
        }

        // Kosongkan keranjang
        session()->forget('cart');

        // Redirect ke halaman sukses dengan parameter order
        return redirect()->route('checkout.success', ['order' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    // Halaman sukses checkout
    public function success(Order $order)
    {
        return view('checkout.success', compact('order'));
    }

    // Upload bukti pembayaran
    public function uploadPayment(Request $request, Order $order)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $request->validate([
            'bukti_payment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cek kepemilikan order & status order
        if ($order->user_id !== Auth::id() || $order->status !== 'pending') {
            return back()->with('error', 'Order tidak ditemukan atau sudah diproses.');
        }

        // Upload file
        if ($request->hasFile('bukti_payment')) {
            $file = $request->file('bukti_payment');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName()); // hindari spasi
            $path = $file->storeAs('public/bukti_payment', $filename);

            if (!$path) {
                return back()->with('error', 'Gagal mengunggah bukti pembayaran.');
            }

            // Simpan ke database
            $order->update([
                'bukti_payment' => $filename,
                'payment_status' => 'uploaded', // nanti admin bisa ubah jadi 'approved'
            ]);

            return back()->with('success', 'Bukti pembayaran berhasil diunggah. Tunggu konfirmasi admin.');
        }

        return back()->with('error', 'Tidak ada file yang diunggah.');
    }

    public function myOrder()
{
    $user = Auth::user(); // ambil user yang sedang login

    $orders = Order::with(['Items.variant']) // load relasi item & variant
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('orders.my_order', compact('orders'));
}




}
