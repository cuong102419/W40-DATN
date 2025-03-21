<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $fillable = ['user_id', 'product_id', 'rating', 'title', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
