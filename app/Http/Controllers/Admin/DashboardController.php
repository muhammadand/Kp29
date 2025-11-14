<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Pastikan hanya admin guard yang bisa masuk
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }

        // ============================
        //        DASHBOARD DATA
        // ============================

        // Total semua order
        $totalOrders = \App\Models\Order::count();

        // Total pendapatan (hanya order yang sudah paid)
        $totalPendapatan = \App\Models\Order::where('payment_status', 'paid')
            ->sum('total_harga');

        // Total produk
        $totalProducts = \App\Models\Product::count();

        // Total user
        $totalUsers = \App\Models\User::count();

        // Kirim ke view
        return view('admin.pages.dashboard.index', compact(
            'totalOrders',
            'totalPendapatan',
            'totalProducts',
            'totalUsers'
        ));
    }

    public function report(Request $request)
    {
        $periode = $request->get('periode', 'harian'); // default harian
        $query = Order::query();

        // Filter berdasarkan periode
        switch ($periode) {

            case 'harian':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'mingguan':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek(),
                ]);
                break;

            case 'bulanan':
                $query->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->month);
                break;

            case 'custom':
                if ($request->start && $request->end) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($request->start),
                        Carbon::parse($request->end)
                    ]);
                }
                break;
        }

        $orders = $query->latest()->get();

        // Hitung total pemasukan
        $total_pendapatan = $orders->sum('total_harga');

        return view('admin.pages.laporan.index', [
            'orders' => $orders,
            'periode' => $periode,
            'total_pendapatan' => $total_pendapatan,
        ]);
    }
}
