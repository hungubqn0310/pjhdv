<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    //category
    public function add_category_product(){
        //$this->AuthLogin();
    	return view('layout.admin.categories.add_category_product');
    }

    public function all_category_product(){
        //$this->AuthLogin();
        $response = Http::get('http://localhost:8000/all-category-product');
        $categories =  $response->json();
        return view('layout.admin.categories.all_category_product', compact('categories'));
    }

    public function edit_category_product($category_product_id){
        //$this->AuthLogin();
        $response = Http::get('http://localhost:8000/edit-category-product/'.$category_product_id);
        $edit_category_product =  $response->json();
        return view('layout.admin.categories.edit_category_product', compact('edit_category_product'));
    }

    //product
    public function add_product(){
        //$this->AuthLogin();
        $response = Http::get('http://localhost:8000/add-product');
        $data = $response->json();

        $cate_product = $data['cate_product'];
        $discounts = $data['discounts'];

        return view('layout.admin.products.add_product', [
            'cate_product' => $cate_product,
            'discounts' => $discounts,
        ]);
    }

    public function all_product(){
        //$this->AuthLogin();
    	$response = Http::get('http://localhost:8000/all-product');
        $all_product = $response->json();
        return view('layout.admin.products.all_product', compact('all_product') );
    }

    public function edit_product($product_id){
        //$this->AuthLogin();
        $response = Http::get('http://localhost:8000/edit-product/'.$product_id);
        $edit_product = $response->json();
        return view('layout.admin.products.edit_product', compact('edit_product') );
    }

    //discount
    public function add_discount(){
        //$this->AuthLogin();
    	return view('layout.admin.discounts.add_discount');
    }

    public function all_discount(){
        //$this->AuthLogin();
        $response = Http::get('http://localhost:8000/all-discount');
        $discounts =  $response->json();
    	return view('layout.admin.discounts.all_discount', compact('discounts'));
    }

    public function edit_discount($discount_id){
        //$this->AuthLogin();
        $response = Http::get('http://localhost:8000/edit-discount/'.$discount_id);
        $edit_discount =  $response->json();
        return view('layout.admin.discounts.edit_discount', compact('edit_discount'));
    }
}
