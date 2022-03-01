<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['coupon_name','coupon_code','coupon_qty','coupon_function','coupon_discount'];
    protected $table = 'tbl_coupon';
    protected $primaryKey = 'coupon_id';
}
