<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;
    protected $table = 'shoppingcart';

    public static function deleteCartRecord($identifier)
    {
        $cart = static::where('identifier' , $identifier);
        $cart->delete();
    }

}
