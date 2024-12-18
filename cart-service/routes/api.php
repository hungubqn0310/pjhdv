<?php
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->group(function () {
    Route::get('/cart', [CartController::class, 'getCart']);  // Lấy giỏ hàng
    Route::post('/cart', [CartController::class, 'addToCart']); // Thêm sản phẩm vào giỏ
    Route::delete('/cart/{cart_id}', [CartController::class, 'removeFromCart']); // Xóa sản phẩm khỏi giỏ
});
