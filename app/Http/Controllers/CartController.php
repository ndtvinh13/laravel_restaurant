<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ShoppingCart;
// use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

session_start();

class CartController extends Controller
{

    public function index(){
        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        return view('pages.home_cart')->with('categories',$dataCategory);
    }

    // Add
    public function save_cart(Request $request){
        $productId = $request->product_hidden;
        $quantity = $request->quantity;
        $categoryId = $request->category_hidden;
        // $quantity = $request->quantity;
        if($quantity == 0){
            return redirect()->back();
        }

        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        $dataProduct = Product::select()->where('product_id',$productId)->first();
        $dataCategoryId = Category::where('category_id', $categoryId)->first();
        // $productInfo=Product::where('product_id',$productId)->first();

        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // Cart::destroy();

        $data['id'] = $dataProduct->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $dataProduct->product_name;
        $data['price'] = $dataProduct->product_price;
        $data['weight'] = '0';
        $data['options']['image'] = $dataProduct->product_image;
        $data['options']['category'] = $dataCategoryId->category_name;
        
        // Set tax
        Cart::setGlobalTax(9);
        $this->restoreFromDb();
        Cart::add($data);
        $this->storeIntoDb();
        $this->display();
        // if(Auth::guard('customer')->check()){
        //     $user_name = Auth::guard('customer')->user()->user_name;
        //     ShoppingCart::deleteCartRecord($user_name);
        //     Cart::store($user_name);
        // }

        // return view('pages.home_cart')->with('categories',$dataCategory)->with('products',$dataProduct);

        return redirect()->route('cart.show')->with('msg','Successfully add an item');
    }

    public function save_cart_ajax(Request $request){
        $productId = $request->input('product_id');
        $quantity = $request->input('qty');
        $categoryId = $request->input('category_id');
        // $quantity = $request->quantity;

        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        $dataProduct = Product::select()->where('product_id',$productId)->first();
        $dataCategoryId = Category::where('category_id', $categoryId)->first();
        // $productInfo=Product::where('product_id',$productId)->first();

        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // Cart::destroy();

        $data['id'] = $dataProduct->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $dataProduct->product_name;
        $data['price'] = $dataProduct->product_price;
        $data['weight'] = '0';
        $data['options']['image'] = $dataProduct->product_image;
        $data['options']['category'] = $dataCategoryId->category_name;
        
        // Set tax
        Cart::setGlobalTax(9);
        $this->restoreFromDb();
        Cart::add($data);
        $this->storeIntoDb();
        $this->display();
    }

    // Display cart item using Ajax
    public function display(){
        $result = [];
        $result['count'] = Cart::content()->count();
        echo json_encode($result);
    }
    

    // Item Increment and Decrement using Ajax
    public function cart_item_ajax(Request $request){
        $rowId = $request->input('row_id');
        $itemQty = $request->input('item_qty');
        $itemPrice = $request->input('item_price');
        $this->restoreFromDb();
        Cart::update($rowId,$itemQty);
        $this->storeIntoDb();
        
        // $this->display();
        $this->item_display_ajax($itemPrice,$itemQty);
    }

    // Del cart ajax
    public function cart_item_del_ajax(Request $request){
        $rowId = $request->input('row_id');
        $this->restoreFromDb();
        Cart::remove($rowId);
        $this->storeIntoDb();
        $this->display_del_item();

    }

    public function display_del_item(){
        $result = [];
        $result['count'] = Cart::content()->count();
        $result['subtotal'] = Cart::subtotal();
        $result['total'] = Cart::total();
        $result['tax'] = Cart::tax();
        $result['del_item'] = '';
        echo json_encode($result);
    }

    // display each item Ajax
    public function item_display_ajax($price,$qty){
        $result = [];
        $itemSub = number_format($price * $qty,2);
        $result['count'] = Cart::content()->count();
        $result['subtotal'] = Cart::subtotal();
        $result['total'] = Cart::total();
        $result['tax'] = Cart::tax();
        $result['itemSub'] = $itemSub;
        echo json_encode($result);
    }

    // Delete
    public function delete_cart($rowId){
        $this->restoreFromDb();
        Cart::remove($rowId);
        $this->storeIntoDb();
        $this->display();
        return redirect()->route('cart.show')->with('msg','Successfully delete an item');
    }

    // Delete all
    public function delete_cart_all(){
        $this->restoreFromDb();
        Cart::destroy();
        $this->storeIntoDb();
        $this->display();
        return redirect()->route('cart.show')->with('msg','All cart items are successfully removed!');
    }

    // Update
    public function update_cart(Request $request){
        $rowId = $request->rowId_qty;
        $quantity = $request->quantity;
        $this->restoreFromDb();
        Cart::update($rowId,$quantity);
        $this->storeIntoDb();
        $this->display();
        return redirect()->route('cart.show')->with('msg','Successfully update an item');
    }

    public function storeIntoDb(){
        //Nếu đã đăng nhập thì store trên DB
        if(Auth::guard('customer')->check()){
            $user_name = Auth::guard('customer')->user()->user_name;
            // ShoppingCart::deleteCartRecord($user_name);
            Cart::store($user_name);
        }
    }

    public function restoreFromDb(){
        //Nếu đã đăng nhập thì store trên DB
        if(Auth::guard('customer')->check()){
            $user_name = Auth::guard('customer')->user()->user_name;
            // ShoppingCart::deleteCartRecord($user_name);
            Cart::restore($user_name);
        }
    }

    // Coupon
    public function coupon_check(Request $request){
        $data = $request->coupon;
        $coupon = Coupon::where('coupon_code',$data)->where('status',1)->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon > 0){
                // get session when there is a coupon
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $is_available = 0;
                    if($is_available == 0){
                        $cou = array(
                            'code'=>$coupon->coupon_code,
                            'function'=>$coupon->coupon_function,
                            'discount'=>$coupon->coupon_discount,
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $cou = array(
                        'code'=>$coupon->coupon_code,
                        'function'=>$coupon->coupon_function,
                        'discount'=>$coupon->coupon_discount,
                    );
                    Session::put('coupon',$cou);
                }
                Session::save();
                // return redirect()->back()->with('msg',"Successfully add a coupon!");
                return redirect()->back()->with('success',"Successfully add a coupon!");
            }
        } else {
            // return redirect()->back()->with('wrong_coupon_msg',"The coupon is invalid or expired!");
            return redirect()->back()->with('errors',"The coupon is invalid or expired!");
        }
    }

    // Delete session coupon
    public function session_coupon_del(){
        Session::forget('coupon');
        return redirect()->back()->with('info','Coupon is removed!');
    }

    // Test
    public function test(){
        echo json_encode('2');
    }

}
