<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
Route::get('/', function () {
    return view('welcome');
});
Route::post('/register', [HomeController::class, 'register']);
Route::get('/register', [HomeController::class, 'showRegisterForm']);
