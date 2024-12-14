<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index'); // Hiển thị danh sách thanh toán
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create'); // Hiển thị form tạo thanh toán mới
Route::post('/payments', [PaymentController::class, 'store']); // Lưu thanh toán mới vào cơ sở dữ liệu
Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show'); // Hiển thị chi tiết thanh toán
Route::post('/payments/momo', [PaymentController::class, 'online_checkout'])->name('payments.momo');
Route::post('/payments/vnpay', [PaymentController::class, 'online_checkout'])->name('payments.vnpay');
Route::get('/thank-you', [PaymentController::class, 'thankYou'])->name('thank-you');


