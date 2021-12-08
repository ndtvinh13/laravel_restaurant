<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
// use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Laravel\Ui\Presets\React;

class CartController extends Controller
{

    public function index(){
        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        return view('pages.home_cart')->with('categories',$dataCategory);
    }

    public function save_cart(Request $request){
        $productId = $request->product_hidden;
        $quantity = $request->quantity;

        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        $dataProduct = Product::select()->where('product_id',$productId)->first();
        // $productInfo=Product::where('product_id',$productId)->first();

        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // Cart::destroy();

        $data['id'] = $dataProduct->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $dataProduct->product_name;
        $data['price'] = $dataProduct->product_price;
        $data['weight'] = '123';
        $data['options']['image'] = $dataProduct->product_image;
        
        // Set tax
        Cart::setGlobalTax(9);
        Cart::add($data);

        // return view('pages.home_cart')->with('categories',$dataCategory)->with('products',$dataProduct);

        return redirect()->route('cart.show')->with('msg','Successfully add an item');
    }

    public function delete_cart($rowId){
        Cart::update($rowId,0);
        return redirect()->route('cart.show')->with('msg','Successfully delete an item');
    }

    public function update_cart(Request $request){
        $rowId = $request->rowId_qty;
        $quantity = $request->quantity;
        Cart::update($rowId,$quantity);
        return redirect()->route('cart.show')->with('msg','Successfully update an item');
    }

}
