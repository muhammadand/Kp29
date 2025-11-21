<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    // 🔹 Menampilkan semua produk beserta variannya
   public function index(Request $request)
{
    $search = $request->input('search');

    // Ambil semua produk beserta varian, filter jika ada pencarian, dan paginate
    $products = Product::with('variants')
        ->when($search, function($q) use ($search) {
            $q->where('nama_produk', 'like', "%{$search}%")
              ->orWhere('jenis_kayu', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10) // 10 produk per halaman
        ->withQueryString(); // agar query search tetap terbawa di pagination

    return view('admin.products.index', compact('products'));
}



    // 🔹 Form tambah produk
    public function create()
    {
        $jenisKayuList = ['Jati', 'Mahoni', 'Merbau', 'Sonokeling', 'Pinus', 'Albasia'];
        return view('admin.products.create', compact('jenisKayuList'));
    }

    // 🔹 Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'jenis_kayu'  => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'variants.*.ukuran' => 'required|string|max:100',
            'variants.*.harga'  => 'required|numeric|min:0',
            'variants.*.harga_m3'  => 'nullable|numeric|min:0',
            'variants.*.stok'   => 'required|integer|min:0',
        ]);

        // Upload gambar
        $filename = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/products'), $filename);
        }

        // Simpan produk
        $product = Product::create([
            'nama_produk' => $request->nama_produk,
            'jenis_kayu'  => $request->jenis_kayu,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $filename,
        ]);

        // Simpan varian
        foreach ($request->variants as $variant) {
            $product->variants()->create($variant);
        }

        return redirect()->route('admin.products.index')
                         ->with('success', '✅ Produk berhasil ditambahkan!');
    }

    // 🔹 Form edit produk
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $jenisKayuList = ['Jati', 'Mahoni', 'Merbau', 'Sonokeling', 'Pinus', 'Albasia'];
        return view('admin.products.edit', compact('product', 'jenisKayuList'));
    }

    // 🔹 Update Produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required',
            'jenis_kayu' => 'required',
            'deskripsi' => 'nullable',
            'gambar' => 'image|mimes:png,jpg,jpeg|max:2048',
            'variants.*.ukuran' => 'required',
            'variants.*.harga' => 'required|numeric',
            'variants.*.harga_m3' => 'nullable|numeric',
            'variants.*.stok' => 'required|numeric'
        ]);

        // Gambar baru jika ada
        if ($request->hasFile('gambar')) {
            $filename = time().'.'.$request->gambar->extension();
            $request->gambar->move(public_path('uploads/products'), $filename);

            if ($product->gambar && file_exists(public_path('uploads/products/'.$product->gambar))) {
                unlink(public_path('uploads/products/'.$product->gambar));
            }
            $product->gambar = $filename;
        }

        // Update data produk
        $product->update([
            'nama_produk' => $request->nama_produk,
            'jenis_kayu' => $request->jenis_kayu,
            'deskripsi' => $request->deskripsi,
        ]);

        // ✅ Update / Tambah / Hapus Varian
        $existingIds = $product->variants->pluck('id')->toArray();
        $newIds = [];

        foreach ($request->variants as $var) {
            if (isset($var['id'])) {
                ProductVariant::where('id', $var['id'])->update($var);
                $newIds[] = $var['id'];
            } else {
                $product->variants()->create($var);
            }
        }

        $deleteIds = array_diff($existingIds, $newIds);
        ProductVariant::destroy($deleteIds);

        return redirect()->route('admin.products.index')->with('success', '✅ Produk berhasil diperbarui!');
    }

    // 🔹 Hapus Produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->gambar && file_exists(public_path('uploads/products/'.$product->gambar))) {
            unlink(public_path('uploads/products/'.$product->gambar));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', '🗑️ Produk berhasil dihapus.');
    }
}
