<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;


class CartController extends Controller
{
    // Tampilkan isi keranjang + order terakhir untuk upload bukti
    public function index()
    {
        $cart = session()->get('cart', []);

        $order = null;
        if (Auth::check()) {
            // Ambil order terakhir milik user yang statusnya pending
            $order = Order::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->latest()
                ->first();
        }

        return view('cart.index', compact('cart', 'order'));
    }

    // Tambah ke keranjang
    public function add(Request $request, $variant_id)
    {
        $variant = ProductVariant::with('product')->findOrFail($variant_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$variant_id])) {
            $cart[$variant_id]['qty'] += 1;
        } else {
            $cart[$variant_id] = [
                'product_id'  => $variant->product->id,
                'nama_produk' => $variant->product->nama_produk,
                'ukuran'      => $variant->ukuran,
                'harga'       => $variant->harga,
                'qty'         => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with([
            'success' => 'Produk berhasil ditambahkan ke keranjang!',
            'product_name' => $variant->product->nama_produk,
            'variant_size' => $variant->ukuran,
            'variant_price' => number_format($variant->harga, 0, ',', '.'),
        ]);
    }

    // Update qty
    public function update(Request $request, $variant_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$variant_id])) {
            $cart[$variant_id]['qty'] = max(1, (int) $request->qty);
            session()->put('cart', $cart);
        }

        return back();
    }

    // Hapus dari keranjang
    public function remove($variant_id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$variant_id])) {
            unset($cart[$variant_id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    // Halaman checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu masih kosong.');
        }

        return view('cart.checkout', compact('cart'));
    }

    // Proses checkout
    public function processCheckout(Request $request)
    {
        $request->validate([
            'no_wa'   => 'required|string|max:15',
            'alamat'  => 'required|string|max:255',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        // Hitung total harga
        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['qty']);

        // Simpan order ke tabel orders
        $order = Order::create([
            'user_id'     => Auth::id(),
            'no_wa'       => $request->no_wa,
            'alamat'      => $request->alamat,
            'total_harga' => $total,
            'status'      => 'pending',
            'payment_status' => 'pending', // tambahkan default payment_status
        ]);

        // Simpan item pesanan ke order_items
        foreach ($cart as $variant_id => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'variant_id' => $variant_id,
                'qty'        => $item['qty'],
                'harga'      => $item['harga'],
            ]);

            // Kurangi stok varian
            $variant = ProductVariant::find($variant_id);
            if ($variant) {
                $variant->stok -= $item['qty'];
                $variant->save();
            }
        }

        // Kosongkan keranjang
        session()->forget('cart');

        // Redirect ke halaman sukses + kirim order terakhir untuk upload payment
        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Pesanan berhasil dibuat! Admin akan menghubungi melalui WhatsApp.');
    }
}
