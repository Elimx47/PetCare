<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'medication_name',
        'price',
        'quantity',
        'medication_type',
        'image_url'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }
}
