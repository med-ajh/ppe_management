<?php

// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'item_id', 'quantity', 'size'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


}
