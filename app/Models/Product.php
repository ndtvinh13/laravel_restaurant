<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'tbl_product';
    protected $primaryKey = 'product_id';

    //use model to join 2 tables (product and category)
    //belongsTo
    public function category(){
        //                                      foreign-key  ,primary-key
        return $this->belongsTo(Category::class,'product_id','category_id');
        // return $this->belongsTo(Category::class,'category_id','product_id');
    }

    // public function getRouteKeyName(){
    //     return 'slug';
    // }
}
