<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'unit_price'
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product_variant() {
        return $this->belongsTo(ProductVariant::class);
    }
    protected $table = 'order_items';

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
