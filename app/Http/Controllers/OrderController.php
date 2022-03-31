<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Shipping;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\App;


class OrderController extends Controller
{
    // Order Management for Admin
    public function manage_order(){
        $orderData = Order::join('tbl_user', 'tbl_order.user_id','=', 'tbl_user.user_id')->select('tbl_order.*', 'tbl_user.user_name')->orderby('order_id','desc')->get();
        return view('admin.manage_order')->with('orderData',$orderData);
    }

    // Order status change
    public function manage_order_status(Request $request){
        if($request->ajax()){
            $status = $request->input('status');
            $orderId = $request->input('orderId');

            $data = Order::find($orderId);
            $data->status = $status;
            $data->save();   

            if($status == "Received") {
                $result = '<input type="button" value="'.$status.'" order_status="Processing" class="order-status-btn order-status-receive" order_id="'.$orderId.'">';

                echo json_encode($result);
            } else {
                $result = '<input type="button" value="'.$status.'" order_status="Received" class="order-status-btn order-status-process" order_id="'.$orderId.'">';

                echo json_encode($result);
            }
            
            
        }

    }

    // Order View
    public function view_order($orderId){
        //Create 2 array , 1 for order details if one order has many items
        //1 for other information
        $orderById = Order::select('tbl_order.*', 'tbl_user.*', 'tbl_shipping.*', 'tbl_order_details.*','tbl_payment.*')->where('tbl_order.order_id',$orderId)->join('tbl_user', 'tbl_order.user_id','=', 'tbl_user.user_id')->join('tbl_shipping', 'tbl_order.shipping_id','=', 'tbl_shipping.shipping_id' )->join('tbl_order_details', 'tbl_order.order_id','=','tbl_order_details.order_id' )->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->first();
        
        $couponCode = $orderById->coupon_code;

                
        $orderDetailsById = Order::select('tbl_order.*', 'tbl_user.*', 'tbl_order_details.*')->where('tbl_order.order_id',$orderId)->join('tbl_user', 'tbl_order.user_id','=', 'tbl_user.user_id')->join('tbl_order_details', 'tbl_order.order_id','=','tbl_order_details.order_id' )->get();

        // $couponDetail = OrderDetails::select('tbl_coupon.*', 'tbl_order_details.*')->where('tbl_order_details.coupon_code',$couponCode)->join('tbl_coupon', 'tbl_order_details.coupon_code','=', 'tbl_coupon.coupon_code')->first();

        if($couponCode != "none"){
            $coupon = Coupon::where('coupon_code',$couponCode)->first();
            $couponFuction = $coupon->coupon_function;
            $couponDiscount = $coupon->coupon_discount;
            return view('admin.view_order')->with(compact('orderById','orderDetailsById','couponFuction','couponDiscount','couponCode'));

        }else{
            return view('admin.view_order')->with(compact('orderById','orderDetailsById','couponCode'));
        }

        
    }

    // Order Delete
    public function delete_order(Request $request){
        
    }

    // Print order
    public function print_order($code){
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($code));

        return $pdf->stream();
    }

    public function print_order_convert($code){
        $orderDetails = OrderDetails::where('code',$code)->get();
        $order = Order::where('code',$code)->first();

        $customerId = $order->user_id;
        $shippingId = $order->shipping_id;

        $customer = Customer::where('user_id',$customerId)->first();
        $shipping = Shipping::where('shipping_id',$shippingId)->first();

        $phoneNo = $shipping->phone;
        $note = $shipping->note;

        foreach($orderDetails as $item){
            $couponCode = $item->coupon_code;
        }

        if ($couponCode != "none"){
            $coupon = Coupon::where('coupon_code',$couponCode)->first();
            $couponFuction = $coupon->coupon_function;
            $couponDiscount = $coupon->coupon_discount;
        }
        

        $output = '';
        $output .= '
        <style>
            table{
                width:100%;
            }

            th > h4 {
                text-transform: uppercase;
                text-align: left;
                top:0;
                margin: 10px 0;
            }

            span{
                text-transform: lowercase;
                font-weight: normal;
            }

            .receipt-total {
                width: 100%;
                font-size: 1.45rem;
            }

            .table-item-detail > tbody > tr {
                padding-bottom: 5px;
            }

            .total{
                width: 30%;
            }

            .table-item-detail > tbody > tr > td {
                padding: 10px 0;
            }


        </style>

        <div style="width:100%; height:1.3rem; background-color:#FD7E14"></div>
        <h3>BurgerZ Restaurant Co.</h3>
        <p>1234 Nordhoff St<br>Northridge, CA 91330 </p>
        <br>
        
        <table>
            <thead>
                <tr>
                    <th colspan="3"><h4>Bill To</h4></th>
                    <th>
                        <h4>Receipt#: <span>'. $code .'<span></h4>
                        
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3">'. $shipping->name .'<br><br>
                        '. $shipping->email .'<br>
                        '. $shipping->address .'<br>
                        ('. substr($phoneNo, 0, 3).') '.substr($phoneNo, 3, 3).'-'.substr($phoneNo,6) .'
                    </td>
                    <th>
                        <h4>Date: <span>'. date('d-m-Y', strtotime($order->created_at)) .'<span></h4>
                        <h4>Time: <span>'. date('H:i:s', strtotime($order->created_at)) .'<span></h4>
                    </th>
                    
                </tr>
            </tbody>
        </table>

        <br>
        <br>
        <hr>
        <div class="receipt-total">
            <table>
                <thead>
                    <tr class="total-wrapper">
                        <th><h4>Total</h4></th>
                        <th class="total">
                            <h4>$'. $order->total .'</h4>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
        <hr>

        <br>
        <table class="table-item-detail">
            <thead>
                <tr>
                    <th><h4>Qty</h4></th>
                    <th><h4>Description</h4></th>
                    <th><h4>Code</h4></th>
                    <th><h4>Price</h4></th>
                    <th><h4>Amount</h4></th>
                </tr>
            </thead>
            <tbody>';
            
            $sum = 0;
            foreach ($orderDetails as $item){

                $subTotal = $item->product_sale_quantity * $item->product_price;
                $sum += $subTotal;

                $output .='
                <tr>
                    <td>'. $item->product_sale_quantity .'</td>
                    <td>'. $item->product_name .'</td>
                    <td>'. $couponCode .'</td>
                    <td>$'. $item->product_price .'</td>
                    <td>$'. number_format($item->product_sale_quantity,2) *  number_format($item->product_price,2).'</td>
                </tr>
                ';
            }

            $output .='
                <tr class="tax-discount">
                    <td colspan="3"></td>
                    <td><b>Discount</b></td>
                    <td>';

                        if($couponCode != "none"){
                            if($couponFuction == 1){
                                $output .='- $'. $couponDiscount .'';
                            }else{
                                $output .='- '. $couponDiscount .'%';
                            }
                                    
                        }else{
                            $output .='$0';
                        }
                    $output .=            
                    '</td>
                </tr>';

                $output .='
                <tr>
                    <td colspan="3"></td>
                    <td><b>Tax (<em>9%</em>)</b></td>
                    <td>';
                        
                        if($couponCode != "none"){
                            if($couponFuction == 1){
                                $output .=''. number_format($order->total + $couponDiscount - $sum,2) .'';
                            }else{
                                $output .='- '. number_format($order->total/(1 - $couponDiscount/100) - $sum,2) .'';
                            }
                                    
                        }else{
                            $output .= '$'. number_format($order->total - $sum,2) .'';
                        }
                        
                    $output .='
                    <td>
                </tr>
            </tbody>
        </table>

        <p><b>Note: <b></p>
        <p>'. $note .'</p>
        <br>
        <br>
        <center><em>Thank your for choosing our restaurant!</em></center>
        <center><em>See you again</em></center>
        ';
        
        return $output;


    }
}
