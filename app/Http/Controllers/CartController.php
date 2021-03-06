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
use Alert;

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

        return redirect()->route('cart.show')->with('success','Successfully add an item');
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
        $this->item_display_ajax($itemPrice,$itemQty,$rowId);
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
    public function item_display_ajax($price,$qty,$id){
        $result = [];
        $itemSub = number_format($price * $qty,2);
        $result['count'] = Cart::content()->count();
        $result['subtotal'] = Cart::subtotal();
        $result['total'] = Cart::total();
        $result['tax'] = Cart::tax();
        $result['itemSub'] = $itemSub;
        $result['itemQty'] = $qty;
        $result['itemId'] = $id;
        echo json_encode($result);
    }

    // Delete
    public function delete_cart($rowId){
        $this->restoreFromDb();
        Cart::remove($rowId);
        $this->storeIntoDb();
        $this->display();
        toast('Deleted an item!','info')->width('250px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(1000);
        return redirect()->route('cart.show')->with('msg','Successfully delete an item');
    }

    // Delete all
    public function delete_cart_all(){
        $this->restoreFromDb();
        Cart::destroy();
        $this->storeIntoDb();
        $this->display();
        return redirect()->route('cart.show')->with('success','All cart items are successfully removed!');
    }

    // Cart display on hover
    public function cart_item_hover_ajax(Request $request){
        $cart_count = Cart::content()->count();
        $cart_subtotal = Cart::subtotal();
        $cart = $request->input('cart_content');
        $cart_decode = json_decode($cart);
        $output = '';
        if($cart_count > 0){
            $output .= 
            '<table class="table cart-item-hover-wrapper">
                <tbody>';
            foreach($cart_decode as $item){
                    $output .= '
                    <tr>
                        <td><img src="'.url('/public/uploads/products/'.$item->options->image).'" width="50" height="40" /></td>
                        <td><span class="cart-item-hover-name">'.$item->name.'</span><br><span class="cart-display-qty">'.$item->qty.'</span> x '.$item->price.'</td>
                        <td>
                            <input type="hidden" row_id="'.$item->rowId.'" class="item-display-id"/>
                            <i class="fas fa-backspace fa-xs"></i>
                        </td>
                    </tr>';
            }
                $output .= '
                    <tr>
                        <td colspan="2"><b>Subtotal</b></td>
                        <td class="cart-display-subtotal">$'.$cart_subtotal.'</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><a class="btn btn-view-cart-display" href="'.url('/cart').'">View Cart</a></td>
                    </tr>
                ';
            
            $output .= 
            '   </tbody>
            </table>';
            
            echo json_encode($output);
        }else{
            $output .= 
            '<table class="table cart-item-hover-wrapper">
                <tbody>';
                    $output .= '
                    <tr>
                        <td class="text-center">There is no cart item!</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center"><a class="btn btn-view-cart-display" href="'.url('/cart').'">View Cart</a></td>
                    </tr>';
            
            $output .= 
            '   </tbody>
            </table>';
            
            echo json_encode($output);
        }
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
        //N???u ???? ????ng nh???p th?? store tr??n DB
        if(Auth::guard('customer')->check()){
            $user_name = Auth::guard('customer')->user()->user_name;
            // ShoppingCart::deleteCartRecord($user_name);
            Cart::store($user_name);
        }
    }

    public function restoreFromDb(){
        //N???u ???? ????ng nh???p th?? store tr??n DB
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
        // return redirect()->back()->with('info','Coupon is removed!');
        toast('Coupon is removed!','info')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(1500);
        return redirect()->back();
    }

    // Test
    public function test(){
        echo json_encode('2');
    }

}
