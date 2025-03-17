<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers'; 

    protected $fillable = [
        'name',
        'product_id',
        'code',
        'value',
        'type',
        'quantity',
        'expiration_date',
    ];


    
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withDefault();
    }

}
