@extends('layout')
@section('content')

<div class="checkout-wrapper">
    @php
        $userName = Auth::guard('customer')->user()->user_name;  
        $userId = Auth::guard('customer')->user()->user_id;
        $shippingId = Session::get('shipping_id');
        $cou = Session::get('coupon');
        $content=Cart::content();
        $cartCount=Cart::content()->count();
    @endphp
    {{-- Title --}}
    <h3 class="title-checkout">{{$userName}}, You're almost there!</h3>
    {{-- Directions --}}
    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}"><i class="fas fa-chevron-circle-left"></i> Continue shopping</a>
        <a class="btn" href="{{url()->previous()}}">Back to Checkout <i class="fas fa-chevron-circle-right"></i></a>
    </div>
    <hr>
    @if(Session::has('msg'))
        <div class="alert alert-success"><i class="far fa-check-circle"></i>{{ Session::get('msg') }}
        </div>
    @endif
    {{-- Progress bar --}}
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
    </div>
    {{-- Order form --}}
    <form action="{{route('order')}}" method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    {{-- Shipping info --}}
                    <div class="cust-title">Payment Method</div>
                    <div class="container checkout-input">
                        @if ($errors->any())
                            <div class="alert alert-warning"><i class="far fa-times-circle"></i> Please choose your method below!</div>
                        @endif

                        {{-- Payment table --}}
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row"><input id="pmDebit" type="radio" name="payment" value="debit"></th>
                                    <td><label class="payment-type" for="pmDebit">Debit</label></td>
                                    <td>
                                        <i class="fab fa-cc-visa fa-2x"></i>
                                        <i class="fab fa-cc-mastercard fa-2x"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><input id="pmCredit" type="radio" name="payment" value="credit"></th>
                                    <td><label class="payment-type" for="pmCredit">Credit</label></td>
                                    <td>
                                        <i class="fab fa-cc-visa fa-2x"></i>
                                        <i class="fab fa-cc-mastercard fa-2x"></i>
                                        <i class="fab fa-apple-pay fa-2x"></i>
                                        <i class="fab fa-cc-discover fa-2x"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><input id="pmPaypal" type="radio" name="payment" value="paypal"></th>
                                    <td><label class="payment-type" for="pmPaypal">Paypal</label></td>
                                    <td><i class="fab fa-paypal fa-2x"></i></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" value="{{$shippingId}}" name="shipping_id">
                        <input type="hidden" value="{{$userId}}" name="user_id">
                        <div class="container-fluid checkout-text p-0">
                            <div class="container-fluid btn-checkout-div p-0">
                                <button class="btn btn-checkout-sub" type="submit">Make Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Review table --}}
                <div class="col-md-5">
                    <div class="cust-title">Review & Payment</div>
                    <div class="container-fluid review-div">
                        <div class="review-text">
                            <h5>Order Summary ({{$cartCount}})</h5>
                            <div><a href="{{route('cart.show')}}" class="review-edit">Edit <i class="fas fa-shopping-cart fa-sm"></i></a></div>
                        </div>
                        {{-- Loop to displayc product --}}
                        @foreach($content as $each_content)
                            <div class="review-text">
                                <div class="d-flex">
                                    <img src="{{asset('/public/uploads/products/'.$each_content->options->image)}}" width=80 height=50/>
                                    <div class="review-info">
                                        <div>{{$each_content->options->category}}</div>
                                        <div>Qty: {{$each_content->qty}}</div>
                                    </div>    
                                </div>
                                <div>${{Cart::subtotal()}}</div>
                            </div>
                            <hr>
                        @endforeach
                        <div class="review-text">
                            <div>Subtotal</div>
                            <div>${{Cart::subtotal()}}</div>
                        </div>
                        <div class="review-text">
                            <div>Sales Tax</div>
                            <div>${{Cart::tax()}}</div>
                        </div>
                        <div class="review-text review-total-div">
                            <h5 class="review-total">Total</h5>
                            <h5 class="review-total">${{Cart::total()-2}}</h5>
                            <input type="hidden" value="{{Cart::total()-2}}" name="cart_total">
                            @if ($cou == true)
                                <input type="hidden" value="{{$cou['code']}}" name="coupon_code">
                            @endif
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>   
    </form>

    <hr>

</div>

@endsection