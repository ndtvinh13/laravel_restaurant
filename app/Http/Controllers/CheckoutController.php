<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

use function Psy\sh;

class CheckoutController extends Controller
{
    public function index(){
        if(Cart::content()->count() == 0){
            alert()->warning('You need at least one item before checkout!','')->autoClose(3000);
            return redirect()->back();
        }
        return view('pages.home_checkout');
    }

    public function save_checkout(Request $request){
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'note' => 'nullable'

        ]);
        //Array to get all requested values
        $data = $request->all();
        
        //Update shipping address when there is one that exists
        $dataShipping = Shipping::where('user_id', $data['user_id'])->first();
        if($shippingCount = Shipping::where('user_id', $data['user_id'])->count() > 0){
            $dataShipping->email = $data['email'];
            $dataShipping->name = $data['name'];
            // $dataShipping->user_id = $data['user_id'];
            $dataShipping->address = $data['address'];
            $dataShipping->phone = $data['phone'];
            $dataShipping->note = $data['note'];
            $dataShipping->update();

            $shipping_id = Shipping::select('shipping_id')->where('user_id', $data['user_id'])->value('shipping_id');
            Session::put('shipping_id',$shipping_id);
            return redirect()->route('payment')->with('msg','Shipping order is successfully created!');

        }

        $shipping = new Shipping();
        $shipping->email = $data['email'];
        $shipping->name = $data['name'];
        $shipping->user_id = $data['user_id'];
        $shipping->address = $data['address'];
        $shipping->phone = $data['phone'];
        $shipping->note = $data['note'];
        $shipping->save();

        $shipping_id = Shipping::select('shipping_id')->where('user_id', $data['user_id'])->value('shipping_id');
        Session::put('shipping_id',$shipping_id);
        return redirect()->route('payment')->with('msg','Shipping order is successfully created!');
    }

    //Payment
    public function payment(){
        return view('pages.home_payment');
    }

    

    //Place order
    public function place_order(Request $request){
        // Get all requested values
        $data = $request->all();
        $contents = Cart::content();


        $request->validate([
            'payment' => 'required|in:debit,credit,paypal'
        ]);

        // Insert payment method
        $payment = new Payment();
        $payment->method = $data['payment'];
        $payment->status = 'Processing';
        $payment->save();

        // Get the last payment id
        $payment_id = $payment->payment_id;

        // Order code
        $order_code = substr(md5(microtime()),rand(0,26),5);

        //Insert order
        $order = new Order();
        $order->user_id = $data['user_id'];
        $order->shipping_id = $data['shipping_id'];
        $order->payment_id =  $payment_id;
        $order->total = $data['cart_total'];
        $order->status = 'Processing';
        $order->code = $order_code;
        $order->save();
        
        // Get the last order id
        $order_id = $order->order_id;

        // Insert order details
        foreach($contents as $content){
            $orderDetails = new OrderDetails();
            $orderDetails->order_id = $order_id;
            $orderDetails->product_id = $content->id;
            $orderDetails->code = $order_code;
            $orderDetails->product_name = $content->name;
            $orderDetails->product_price = $content->price;
            $orderDetails->product_sale_quantity = $content->qty;
            if(Session::get('coupon') == true){
                $orderDetails->coupon_code = $data['coupon_code'];
            }else{
                $orderDetails->coupon_code = 'none';
            }
            $orderDetails->save();
        }

        // Coupon code is decreased by 1 after each checkout
        if(Session::get('coupon') == true){
            $orderDetails->coupon_code = $data['coupon_code'];
            $coupon = Coupon::where('coupon_code',$data['coupon_code'])->first();
            $coupon->coupon_qty = $coupon->coupon_qty - 1;
            $coupon->save();
        }

        // Display order number and date
        $orderId = OrderDetails::select('order_id')->where('order_id',$order_id)->value('order_id');
        $orderCode = OrderDetails::select('code')->where('code',$order_code)->value('code');
        $orderDate = OrderDetails::select('created_at')->where('order_id',$order_id)->value('created_at');
        

        Session::put('orderId',$orderId);
        Session::put('orderDate', $orderDate);
        Session::put('code',$orderCode);
        
        // $coupon_session = Session::get('coupon');
        // if($coupon_session == true){
        // }
        Session::forget('coupon');
        Session::forget('success_paypal');

        return redirect()->route('confirmation')->with('msg','Your order has been confirmed!');
    }

    // Confirmation
    public function confirmation(){
        if($userId = Auth::guard('customer')->user()->user_id){
            $orderShipping = Shipping::where('user_id',$userId)->get();
            $orderId = Order::select('order_id')->where('user_id',$userId)->latest('order_id')->value('order_id');
            if($orderId){      //Use relation model to output product info
                
                $dataOrder = OrderDetails::with('toProduct')->where('order_id',$orderId)->get();

                $orderMethod = Order::with('payment')->where('order_id',$orderId)->first();
                $order = Order::where('order_id',$orderId)->first();
                $couponCode = OrderDetails::select('coupon_code')->where('order_id',$orderId)->value('coupon_code');
                
                $coupon = Coupon::where('coupon_code', $couponCode)->first();
                
            }
        }

        // paypal payment session delete
        Session::forget('success_paypal');
        Session::forget('total_paypal');

        // card payment session delete
        Session::forget('success_card');
        Session::forget('total_card');

        alert()->success('Order is being processed!','Thank you for your support.')->autoClose(3000);
        return view('pages.home_confirmation')->with(compact('orderMethod','orderShipping','dataOrder','order','couponCode','coupon'));
    }

}
