<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'shopping_cart'; // Tên bảng trong CSDL
    protected $fillable = ['user_id', 'product_id', 'quantity', 'is_deleted'];

    // Mối quan hệ với Product (mỗi item trong giỏ có một sản phẩm)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
