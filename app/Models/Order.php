<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status', 
        'total', 
        'payment_method', 
        'address', 
        'fullname', 
        'email', 
        'phone_number', 
        'note'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
