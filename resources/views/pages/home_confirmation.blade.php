@extends('layout')
@section('content')

<div class="confirmation-wrapper">

    @php
        $userName = Auth::guard('customer')->user()->user_name;  
        $userId = Auth::guard('customer')->user()->user_id;
        $order_id = Session::get('orderId');
        // $order_date = Session::get('orderDate');
        // $code = Session::get('code');
        // $content = Cart::content();
        // $cartCount = Cart::content()->count();
        $itemCount = $dataOrder->count();
        // clear out the cart when the order is placed
        Cart::restore($userName);
        Cart::destroy();
        Cart::store($userName);
        $sum = 0;
    @endphp

        {{$couponCode}}
     {{-- Title --}}
     <h3 class="title-checkout">Your order has been placed, Thanks {{$userName}}!</h3>

     <div class="container-fluid shopping-option">
         <a class="btn" href="{{route('menu')}}"><i class="fas fa-chevron-circle-left"></i> Continue shopping</a>
     </div>
 
     <hr>

     @if(Session::has('msg'))
        <div class="alert alert-success"><i class="far fa-check-circle"></i> {{ Session::get('msg') }}
        </div>
    @endif
    {{-- Progress bar --}}
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
    </div>

    <div class="confirm-order d-flex align-items-center">
        <div><i class="fas fa-box"></i> <b>Oder#: </b>{{$order->code}}</div>
        <hr id="confirmation-info-line">
        <div>{{$itemCount}} items</div>
    </div>
    <div><i class="fas fa-calendar-day"></i> <b>Date:</b> {{date('m-d-Y H:i:s', strtotime($order->created_at))}}</div>

    <hr class="confirmation-line">
    
    {{-- Review table --}}
    <table class="table table-borderless">
        <thead>
            <tr>
                <th class="col-2 text-center"><h5><b>Quantity</b></h5></th>
                <th><h5><b>Item</b></h5></th>
                <th class="col-2"><h5><b>Amount</b></h5></th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($dataOrder as $each_content)
                @php
                    $subtotal = $each_content->product_sale_quantity * $each_content->product_price;
                    $sum += $subtotal;
                @endphp
                <tr>
                    <td class="col-2 align-middle text-center">{{$each_content->product_sale_quantity}}</td>
                    <td class="d-flex align-items-center">
                        <img style="border-radius:5px; margin-right:10px;" src="{{asset('/public/uploads/products/'.$each_content->toProduct->product_image)}}" width=80 height=50/>
                        <div>{{$each_content->product_name}}</div>
                    </td>
                    <td class="col-2 align-middle">${{$each_content->product_price}}</td>
                </tr>
            @endforeach
                <tr style="border-top: solid 1px #C0C0C0;">
                    <td colspan="2"><h5>Tax (9%)</h5></td>
                    <td>
                        <h5>
                            @if ($couponCode != "none")
                                @if ($coupon->coupon_function == 1)
                                    ${{number_format($order->total + $coupon->coupon_discount - $sum,2)}}
                                    
                                @else
                                    ${{number_format($order->total/(1 - $coupon->coupon_discount/100) - $sum,2)}}
                                @endif
                            @else
                                ${{number_format($order->total - $sum,2)}}
                            @endif
                        </h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><h5>Total</h5></td>
                    <td><h5>${{$order->total}}</h5></td>
                </tr>
        </tbody>
    </table>

    <hr>

    <div>
        <p><i class="fas fa-info-circle"></i> <b>Additional Details</b></p>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p><i class="fas fa-cash-register"></i> <b>Payment</b></p>
                    <div>
                        {{-- {{$orderMethod}} --}}
                        @if ($orderMethod->payment->method === "paypal")
                            <i class="fab fa-paypal fa-3x"></i>
                        @elseif ($orderMethod->payment->method === "debit")
                            <i class="fab fa-cc-visa fa-3x"></i>
                            <i class="fab fa-cc-mastercard fa-3x"></i>
                        @else
                            <i class="fab fa-cc-visa fa-3x"></i>
                            <i class="fab fa-cc-mastercard fa-3x"></i>
                            <i class="fab fa-apple-pay fa-3x"></i>
                            <i class="fab fa-cc-discover fa-3x"></i>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <p>
                        <i class="fas fa-map-marker-alt"></i> <b>Billing</b> 
                        <div>
                            @foreach ($orderShipping as $item)
                                {{$item->name}}<br>
                                {{$item->email}}<br>
                                {{$item->address}}<br>
                            @endforeach
                        </div>
                    </p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection