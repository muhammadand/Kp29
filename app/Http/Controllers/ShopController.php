<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil semua produk dan filter jika ada pencarian
        $products = Product::when($search, function ($q) use ($search) {
            $q->where('nama_produk', 'like', "%{$search}%")
                ->orWhere('jenis_kayu', 'like', "%{$search}%");
        })
            ->latest()
            ->get();

        return view('shop.index', compact('products'));
    }



    public function show($id)
    {
        // Ambil produk beserta variannya
        $product = Product::with('variants')->findOrFail($id);
        return view('shop.show', compact('product'));
    }
}
