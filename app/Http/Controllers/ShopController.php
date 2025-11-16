<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $jenisKayu  = $request->input('jenis_kayu'); // samakan dengan form

        $products = Product::when($search, function ($q) use ($search) {
            $q->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('jenis_kayu', 'like', "%{$search}%");
        })
            ->when($jenisKayu, function ($q) use ($jenisKayu) {
                $q->where('jenis_kayu', $jenisKayu);
            })
            ->latest()
            ->get();

        // Ambil semua jenis kayu unik untuk dropdown
        $jenisKayuList = Product::select('jenis_kayu')
            ->distinct()
            ->pluck('jenis_kayu');

        return view('shop.index', compact('products', 'jenisKayuList'));
    }




    public function show($id)
    {
        // Ambil produk beserta variannya + reviewnya
        $product = Product::with(['variants', 'reviews'])->findOrFail($id);

        return view('shop.show', compact('product'));
    }

    public function services(Request $request)
    {
        // Ambil semua kategori untuk dropdown
        $categories = ServiceCategory::with('items')->get();

        // Ambil items untuk ditampilkan berdasarkan filter
        $itemsQuery = \App\Models\ServiceItem::with('category');

        // Filter kategori
        if ($request->category) {
            $itemsQuery->where('category_id', $request->category);
        }

        // Filter pencarian
        if ($request->search) {
            $itemsQuery->where('name', 'like', "%{$request->search}%");
        }

        $items = $itemsQuery->orderBy('category_id')->get();

        return view('shop.services.index', compact('categories', 'items'));
    }


    // 2. Detail layanan yang dipilih
    public function serviceShow($id)
    {
        $service = ServiceItem::with('category')->findOrFail($id);

        return view('shop.services.show', compact('service'));
    }


    // 3. Proses pembelian jasa — versi simpel
    public function buyService(Request $request)
    {
        $request->validate([
            'service_item_id' => 'required|exists:service_items,id',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
        ]);

        $service = ServiceItem::findOrFail($request->service_item_id);

        // Hitung total harga
        $total = $service->price * $request->quantity;

        // Simpan order (versi simple — belum pakai table orders)
        // Bisa kamu kembangkan ke tabel transaksi
        // ----------------------------------------------------
        // Untuk sekarang hanya tampilkan ringkasan checkout
        // ----------------------------------------------------

        return view('shop.services.checkout', [
            'service' => $service,
            'quantity' => $request->quantity,
            'customer_name' => $request->customer_name,
            'total' => $total,
        ]);
    }
}
