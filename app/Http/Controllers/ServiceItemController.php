<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceItem;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceItemController extends Controller
{
    public function index()
    {
        $items = ServiceItem::with('category')->orderBy('id', 'DESC')->get();
        return view('admin.service-items.index', compact('items'));
    }

    public function create()
    {
        $categories = ServiceCategory::orderBy('name')->get();
        return view('admin.service-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // tambah validasi image
        ]);

        $item = new ServiceItem();
        $item->category_id = $request->category_id;
        $item->name        = $request->name;
        $item->price       = $request->price;
        $item->unit        = $request->unit;

        // Upload image jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('service-items', 'public');
            $item->image = $path;
        }

        $item->save();

        return redirect()
            ->route('admin.service-items.index')
            ->with('success', 'Item layanan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = ServiceItem::findOrFail($id);
        $categories = ServiceCategory::orderBy('name')->get();
        return view('admin.service-items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = ServiceItem::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'unit'        => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // tambah validasi image
        ]);

        $item->category_id = $request->category_id;
        $item->name        = $request->name;
        $item->price       = $request->price;
        $item->unit        = $request->unit;

        // Update image jika ada
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $path = $request->file('image')->store('service-items', 'public');
            $item->image = $path;
        }

        $item->save();

        return redirect()
            ->route('admin.service-items.index')
            ->with('success', 'Item layanan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = ServiceItem::findOrFail($id);

        // Hapus image lama jika ada
        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()
            ->route('admin.service-items.index')
            ->with('success', 'Item layanan berhasil dihapus!');
    }
}
