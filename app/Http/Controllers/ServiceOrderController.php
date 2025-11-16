<?php

namespace App\Http\Controllers;

use App\Models\ServiceItem;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceOrderController extends Controller
{

    /**
     * Tampilkan semua order untuk admin.
     */
    public function index()
    {
        // Ambil semua order, beserta data service item, urut terbaru
        $orders = ServiceOrder::with('item')->orderBy('id', 'DESC')->paginate(15);

        return view('admin.service-orders.index', compact('orders'));
    }



    /**
     * Form membuat order baru.
     */
    public function create($itemId)
    {
        $item = ServiceItem::findOrFail($itemId);
        return view('shop.services.order', compact('item'));
    }

    /**
     * Simpan order baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_item_id' => 'required|exists:service_items,id',
            'customer_name'   => 'required|string|max:255',
            'customer_phone'  => 'required|string|max:20',
            'address'         => 'required|string|max:255',
            'note'            => 'nullable|string',
            'quantity'        => 'required|numeric|min:1',
        ]);

        $service = ServiceItem::findOrFail($request->service_item_id);

        $order = ServiceOrder::create([
            'service_item_id' => $service->id,
            'user_id'         => Auth::id(), // <-- otomatis terhubung dengan user login
            'customer_name'   => $request->customer_name,
            'customer_phone'  => $request->customer_phone,
            'address'         => $request->address,
            'note'            => $request->note,
            'total_price'     => $service->price * $request->quantity,
            'order_status'    => 'pending',
            'payment_status'  => 'unpaid',
        ]);

        return redirect()
            ->route('shop.services.order.upload', $order->id)
            ->with('success', 'Order berhasil dibuat! Silakan upload bukti pembayaran.');
    }


    /**
     * Halaman detail order.
     */
    public function show($id)
    {
        $order = ServiceOrder::with('item')->findOrFail($id);
        return view('admin.service-orders.show', compact('order'));
    }
    public function uploadPage($id)
    {
        $order = ServiceOrder::findOrFail($id);
        return view('shop.services.upload-payment', compact('order'));
    }


    /**
     * Upload bukti pembayaran.
     */
    public function uploadPayment(Request $request)
    {
        // dd('uploadPayment dipanggil', $request->all());
        $validated = $request->validate([
            'order_id' => 'required|exists:service_orders,id',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = ServiceOrder::findOrFail($request->order_id);

        // Hapus bukti lama jika ada
        if ($order->payment_proof && Storage::exists($order->payment_proof)) {
            Storage::delete($order->payment_proof);
        }

        // Upload baru
        $path = $request->file('payment_proof')->store('payments', 'public');

        $order->update([
            'payment_proof'  => $path,
            'payment_status' => 'paid',
        ]);

        return redirect()->route('orders.my')
            ->with('success', 'Pesanan berhasil dibuat!');
    }


    /**
     * Update status order oleh admin.
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = ServiceOrder::findOrFail($id);

        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,completed,canceled',
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return back()->with('success', 'Status order diperbarui!');
    }

    /**
     * Update status pembayaran oleh admin.
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $order = ServiceOrder::findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,waiting_verification,paid,rejected',
        ]);

        $order->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Status pembayaran diperbarui!');
    }
}
