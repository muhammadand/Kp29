<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ServiceCategoryController extends Controller
{
    /**
     * Tampilkan semua kategori
     */
    public function index()
    {
        $categories = ServiceCategory::latest()->paginate(10);

        return view('admin.service_categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('admin.service_categories.create');
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category = new ServiceCategory();
        $category->name = $request->name;
        $category->description = $request->description;

        // Simpan image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }

        $category->save();

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:service_categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $category->name = $request->name;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }

        $category->save();

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }




    /**
     * Form edit kategori
     */
    public function edit($id)
    {
        $category = ServiceCategory::findOrFail($id);

        return view('admin.service_categories.edit', compact('category'));
    }



    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $category = ServiceCategory::findOrFail($id);

        // Opsional: cek apakah masih punya item
        if ($category->items()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena memiliki item.');
        }

        $category->delete();

        return redirect()
            ->route('admin.service_categories.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}
