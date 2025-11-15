<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    public function store(Request $request, $orderId)
    {
        // Validasi minimal struktur array
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|array',
            'content' => 'required|array',
        ]);

        $order = Order::findOrFail($orderId);
         $contentArray = $request->input('content');

        // Loop setiap produk unik
        foreach ($request->rating as $productId => $ratingValue) {

            // Validasi tiap item
            if ($ratingValue < 1 || $ratingValue > 5) {
                continue; // skip invalid value
            }

            ProductReview::create([
                'product_id' => $productId,
                'name'       => $request->name,
                'rating'     => $ratingValue,
                'content'    => $contentArray[$productId] ?? '',
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih, review Anda telah dikirim!');
    }
}
