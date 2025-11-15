<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
}
