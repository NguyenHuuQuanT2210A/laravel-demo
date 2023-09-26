<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable=
        [
            "user_id",
            "email",
            "grand_total",
            "status",
            "tel",
            "full_name",
            "address",
            "shipping_method",
            "payment_method",
            "is_paid"
        ];

    public function Products(){ //
        return $this->belongsToMany(Product::class,"order_products")->withPivot(["qty","price"]);// withPivot lay them cot qty va price o bang thu 3
    }
}
