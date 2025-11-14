<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderAdminController extends Controller
{
public function index()
{
    $query = Order::with(['user', 'items.product']);

    // Filter status jika ada di request
    if (request('status')) {
        $query->where('status', request('status'));
    }

    $orders = $query->latest()->get();

    return view('admin.orders.index', compact('orders'));
}


    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,diproses,selesai,batal']);
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        return back()->with('success','Status order berhasil diperbarui.');
    }

    public function markPaid($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'uploaded') {
            $order->payment_status = 'paid';
            if($order->status == 'pending') $order->status = 'diproses';
            $order->save();
            return back()->with('success','Pesanan telah diverifikasi dan dibayar.');
        }

        return back()->with('error','Pesanan belum ada bukti pembayaran atau sudah dibayar.');
    }

    public function rejectPayment($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'ditolak';
        $order->save();
        return back()->with('error','Pembayaran telah ditolak.');
    }
}
