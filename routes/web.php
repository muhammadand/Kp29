<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceOrderController;

// =================== AUTH PELANGGAN ===================
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'loginProcess'])->name('login.process');

Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
Route::post('/register', [LoginController::class, 'registerProcess'])->name('register.process');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
 
// =================== AUTH ADMIN ===================
Route::prefix('admin')->name('admin.')->group(function () {
    // Login admin
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'loginProcess'])->name('login.process');
  Route::resource('products', ProductController::class);
    Route::get('/service-orders', [ServiceOrderController::class, 'index'])
        ->name('service-orders.index');
    Route::get('/service-orders/{id}', [ServiceOrderController::class, 'show'])
        ->name('service-orders.show');
           Route::put('/service-orders/{id}/status', [ServiceOrderController::class, 'updateOrderStatus'])
        ->name('service-orders.updateOrderStatus');
          Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderAdminController::class, 'index'])->name('index');
            Route::get('/processing', [OrderAdminController::class, 'processing'])->name('processing');
            Route::get('/completed', [OrderAdminController::class, 'completed'])->name('completed');
            Route::get('/cancelled', [OrderAdminController::class, 'cancelled'])->name('cancelled');
            Route::get('/{id}', [OrderAdminController::class, 'show'])->name('show');

            Route::post('/{id}/status', [OrderAdminController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{id}/mark-paid', [OrderAdminController::class, 'markPaid'])->name('markPaid');
            Route::post('/{id}/approve-payment', [OrderAdminController::class, 'approvePayment'])->name('approvePayment');
            Route::post(
                '/{order}/reject-payment',
                [OrderAdminController::class, 'rejectPayment']
            )->name('rejectPayment');
        });
    Route::middleware('auth:admin')->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Produk (CRUD)
     

        // Pesanan
      
        Route::get('/laporan/transaksi', [DashboardController::class, 'report'])
            ->name('laporan.transaksi');
        // Logout admin
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });

    //service
    Route::resource('service-categories', \App\Http\Controllers\ServiceCategoryController::class);
    Route::resource('service-items', \App\Http\Controllers\ServiceItemController::class);
});

// ===================== HALAMAN UMUM =====================
Route::view('/', 'home')->name('home');
Route::view('/contact', 'contact')->name('contact');
Route::view('/about', 'about')->name('about');

// ===================== SHOP =====================
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/produk/{id}', [ShopController::class, 'show'])->name('shop.show');

// ===================== CART & CHECKOUT =====================
Route::middleware('auth:web')->group(function () {
    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{variant}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{variant}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{variant}', [CartController::class, 'remove'])->name('cart.remove');

    // Halaman Checkout
    Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout.index');

    // Proses checkout
    Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.process');

    // Halaman sukses
    // Route::get('/checkout/success/{order}', [OrderController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');
    // Upload bukti pembayaran
    // Route::post('/checkout/upload-payment/{order}', [OrderController::class, 'uploadPayment'])->name('checkout.uploadPayment');
    // Route::get('/checkout/upload-payment', [CheckoutController::class, 'showUploadForm'])->name('checkout.upload-form');

    // // Upload bukti pembayaran
    // Route::post('/checkout/upload-payment/{order}', [OrderController::class, 'uploadPayment'])
    //     ->name('checkout.uploadPayment.post');

    Route::post('/checkout/{order}/upload-payment', [CheckoutController::class, 'uploadPayment'])
        ->name('checkout.uploadPayment.post');
    Route::get('/my-order', [OrderController::class, 'myOrder'])->name('orders.my');
    //REVIEW
    Route::post('/review/{order}', [ReviewController::class, 'store'])->name('review.store');
    //Buys Service
    // Services
    Route::get('/services', [ShopController::class, 'services'])->name('shop.services');
    Route::get('/services/{id}', [ShopController::class, 'serviceShow'])->name('shop.services.show');
    Route::post('/services/buy', [ShopController::class, 'buyService'])->name('shop.services.buy');
    Route::post('/services/order/store', [ServiceOrderController::class, 'store'])->name('shop.services.order.store');
    // Route::post('/services/order/upload', [ServiceOrderController::class, 'uploadPayment'])
    // ->name('shop.services.order.upload');
    Route::get('/services/order/upload/{id}', [ServiceOrderController::class, 'uploadPage'])
    ->name('shop.services.order.upload');
    Route::post('/services/order/upload/{id}', [ServiceOrderController::class, 'uploadPayment'])
    ->name('shop.services.order.send');
});
