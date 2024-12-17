<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingCart;  // Import model ShoppingCart
use App\Models\Product;       // Import model Product
use App\Models\User;          // Import model User

class CartController extends Controller
{
    // Lấy giỏ hàng của người dùng
    public function getCart(Request $request)
    {
        $user_id = $request->user()->id; // Lấy user_id từ token (sau khi login)

        $cartItems = ShoppingCart::with('product') // Kết hợp với bảng Products để lấy thông tin sản phẩm
                                 ->where('user_id', $user_id)
                                 ->where('is_deleted', 0)
                                 ->get();

        return response()->json([
            'cart_items' => $cartItems
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $user_id = $request->user()->id; // Lấy user_id từ token
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // Mặc định quantity = 1

        // Kiểm tra sản phẩm có tồn tại không
        $product = Product::find($product_id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $cartItem = ShoppingCart::where('user_id', $user_id)
                                ->where('product_id', $product_id)
                                ->where('is_deleted', 0)
                                ->first();

        if ($cartItem) {
            // Cập nhật số lượng sản phẩm trong giỏ
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Thêm sản phẩm mới vào giỏ
            ShoppingCart::create([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
        }

        return response()->json(['message' => 'Product added to cart']);
    }

    // Xóa sản phẩm khỏi giỏ
    public function removeFromCart(Request $request, $cart_id)
    {
        $user_id = $request->user()->id; // Lấy user_id từ token

        $cartItem = ShoppingCart::where('user_id', $user_id)
                                ->where('id', $cart_id)
                                ->where('is_deleted', 0)
                                ->first();

        if ($cartItem) {
            $cartItem->is_deleted = 1; // Đánh dấu sản phẩm là đã xóa
            $cartItem->save();
            return response()->json(['message' => 'Product removed from cart']);
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }
}
