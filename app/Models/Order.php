<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Payment;


class Order extends Model
{
    use HasFactory;
    protected $table = 'tbl_order';
    protected $primaryKey = 'order_id';

    public function orderDetails() {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function payment(){
        return $this->belongsTo(Payment::class, 'payment_id');
    }

}
