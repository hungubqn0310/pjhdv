<?php
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);
