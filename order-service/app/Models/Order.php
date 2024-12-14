<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'oder_id',
        'user_id',
        'order_date',
        'status',
        'total_amount',
    ];
    // public function user() {
    //     return $this->belongTo(User::class);
    // }
}
