<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

//page home
Route::get('/', [HomeController::class, 'index']);
Route::get('trang-chu', [HomeController::class, 'index']);
Route::post('tim-kiem', [HomeController::class, 'search']);
Route::get('san-pham', [HomeController::class,'list_product']);
Route::get('login', [HomeController::class, 'login'])->name('login');
Route::post('login-home', [HomeController::class, 'login_home']);
Route::get('logout-home', [HomeController::class, 'logout_home']);

//page admin
Route::get('/', function () {
    return view('layout-admin');
});
Route::get('admin', [AdminController::class, 'index']);
Route::get('dashboard', [AdminController::class, 'showDashboard']);
Route::get('logout', [AdminController::class, 'logout']);
Route::post('admin-dashboard', [AdminController::class, 'dashboard']);

//category
Route::get('add-category-product', [AdminController::class, 'add_category_product']);
Route::get('all-category-product', [AdminController::class, 'all_category_product'])->name('all-category');
Route::get('edit-category-product/{category_product_id}', [AdminController::class, 'edit_category_product']);

//product
Route::get('/add-product',[AdminController::class,'add_product']);
Route::get('/edit-product/{product_id}',[AdminController::class,'edit_product']);
Route::get('/all-product',[AdminController::class,'all_product'])->name('all-product');

//discount
Route::get('/add-discount',[AdminController::class,'add_discount']);
Route::get('/all-discount',[AdminController::class,'all_discount'])->name('all-discount');
Route::get('edit-discount/{discount_id}', [AdminController::class, 'edit_discount']);

