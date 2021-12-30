@extends('layout')
@section('content')

<div class="checkout-wrapper">
    @php
        $userName = Auth::guard('customer')->user()->user_name;  
        $userId = Auth::guard('customer')->user()->user_id;
        $content=Cart::content();
        $cartCount=Cart::content()->count();
    @endphp
    {{-- Title --}}
    <h3 class="title-checkout">Welcome, {{$userName}}!</h3>
    {{-- Directions --}}
    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}">Continue shopping</a>
        <a class="btn" href="{{url()->previous()}}">Back to Cart</a>
    </div>
    <hr>
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>
    {{-- Order form --}}
    <form action="{{route('checkout.save')}}" method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    {{-- Shipping info --}}
                    <div class="cust-title">{{$userName}}, More about you</div>
                    <div class="container checkout-input">
                        @if ($errors->any())
                            <div class="alert alert-warning">Please answer below!</div>
                        @endif
                        <div class="mb-3">
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email*" name="email">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="nameHelp" placeholder="Name*" name="name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="addressHelp" placeholder="Address*" name="address">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="phoneHelp" placeholder="Phone No*" name="phone">
                        </div>
                        <input type="hidden" value="{{$userId}}" name="user_id">
                        <div class="cust-title">Shipping notes</div>
                        {{-- Shipping notes --}}
                        <div class="container-fluid checkout-text p-0">
                            <textarea class="form-control" placeholder="Tell us what to do" rows="6" name="note"></textarea>
                            <div class="container-fluid btn-checkout-div p-0">
                                <button class="btn btn-checkout-sub" type="submit">Continue</button>
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
                            <h5 class="review-total">${{Cart::total()}}</h5>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>   
    </form>

    <hr>

    

</div>
@endsection