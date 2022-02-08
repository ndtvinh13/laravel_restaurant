@extends('layout')
@section('content')

<div class="confirmation-wrapper">

    @php
        $userName = Auth::guard('customer')->user()->user_name;  
        $userId = Auth::guard('customer')->user()->user_id;
        $order_id = Session::get('orderId');
        $order_date = Session::get('orderDate');
        $content = Cart::content();
        $cartCount = Cart::content()->count();
        // clear out the cart when the order is placed
        Cart::restore($userName);
        Cart::destroy();
        Cart::store($userName);
    @endphp

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
        <div><b>Oder#</b>{{$order_id}}</div>
        <hr id="confirmation-info-line">
        <div>{{$cartCount}} items</div>
    </div>
    <div><b>Date</b> {{date('m-d-Y H:i:s', strtotime($order_date))}}</div>

    <hr class="confirmation-line">
    
    {{-- Review table --}}
    <table class="table table-borderless">
        <thead>
            <tr>
                <th class="col-2">Quantity</th>
                <th >Item</th>
                <th class="col-2">Amount</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($content as $each_content)
                <tr>
                    <td class="col-2 align-middle">{{$each_content->qty}}</td>
                    <td class="d-flex align-items-center">
                        <img style="border-radius:5px; margin-right:10px;" src="{{asset('/public/uploads/products/'.$each_content->options->image)}}" width=80 height=50/>
                        <div>{{$each_content->name}}</div>
                    </td>
                    <td class="col-2 align-middle">${{$each_content->price}}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <hr>

    <div>
        <p><b>Additional Details</b></p>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p><b>Payment</b></p>
                    <div>
                        {{-- {{$orderMethod}} --}}
                        @if ($orderMethod === "paypal")
                            <i class="fab fa-paypal fa-3x"></i>
                        @elseif ($orderMethod === "debit")
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
                        <b>Billing</b>
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