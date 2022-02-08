@extends('layout')
@section('content')

<div class="cart-wrapper">

    {{-- Title --}}
    <h3 class="title-checkout">Your Shopping Cart</h3>

    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}"><i class="fas fa-chevron-circle-left"></i> Continue shopping</a>
        <a class="btn">Go to Checkout <i class="fas fa-chevron-circle-right"></i></a>
    </div>

    <hr>

    @if(Session::has('msg'))
    <div class="alert alert-success"><i class="far fa-check-circle"></i>
        {{ Session::get('msg') }}
    </div>
    @endif

    @php
        $cartCount = Cart::content()->count();
        // echo "<pre>";
        // print_r($cartCount);
        // echo "</pre>";
    @endphp

    @php
        $content = Cart::content();
        // echo "<pre>";
        // print_r($content);
        // echo "</pre>";
        // $coupon = Session::get('coupon');
        // print_r($coupon['function']);
        print_r(json_encode(Session::get('coupon')));
    @endphp
    
    

    {{-- Shopping cart --}}
    <div class="container-fluid p-0 what-is">
        <div class="row shopping-row">
            {{-- Items products --}}
            <div class="col-md-8 col-12">
                <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th class="column-display" scope="col">Image</th>
                        <th scope="col">Item</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Sub-total</th>
                        <th></th>
                      </tr>
                    </thead>
                    {{-- {{dd(Cart::instance('cart')->count())}}  --}}
                    <tbody>
                      @php
                        if(Auth::guard('customer')->check()){
                          Cart::destroy();
                          Cart::restore(Auth::guard('customer')->user()->user_name);
                          Cart::store(Auth::guard('customer')->user()->user_name);
                        }
                        @endphp 
                      @if ($cartCount > 0)
                          {{-- if there are cart items --}}
                          {{-- Loop to display item products --}}
                        @foreach($content as $each_content)
                          <tr>
                            <td class="column-display">
                              <img src="{{asset('/public/uploads/products/'.$each_content->options->image)}}" width=100 height=70/>
                            </td>
                            <td>{{$each_content->name}}</td>
                            <td>{{"$".$each_content->price}}</td>
                            <td>

                              {{-- Form to update cart --}}
                              <form action="{{route('cart.update')}}" method="POST">
                                @csrf
                                <div class="qty-box">
                                  <span></span>
                                  <div class="menu-btn dec" row_id="{{$each_content->rowId}}" item_qty="{{$each_content->qty}}">-</div>
                                  <input class="quantity-input" type="" item_price="{{$each_content->price}}" value="{{$each_content->qty}}" name="quantity"/>
                                  <div class="menu-btn inc" row_id="{{$each_content->rowId}}">+</div>
                                </div>
                                <div class="d-flex justify-content-center">
                                  <input type="hidden" value="{{$each_content->rowId}}" name="rowId_qty"/>
                                  <button type="submit" class="btn-cart-update" name="submit">
                                    <a><i class="fa fa-repeat fa-lg"></i></a>
                                  </button>
                                </div>
                              </form>
                            </td>
                            
                            {{-- Total = price * qty --}}
                            <td class="item-sub-ajax">${{$total = $each_content->price * $each_content->qty}}</td>
                            <td>
                              <a href="{{route('cart.delete',['rowId' => $each_content->rowId])}}"><i class="fa fa-trash fa-lg"></i></a>
                            </td>
                          </tr>
                        @endforeach
                      {{-- End of loop --}}
                      @else
                      {{-- If there is no cart item --}}
                        <tr> 
                          <td colspan="5" rowspan="5" class="no-cart-item" >
                            <h5>No Cart Item</h5>
                            <a class="btn" href="{{route('menu')}}">Check Our Menu</a>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
            </div>

            {{-- payment method --}}
            <div class="col-md-4">
                <div class="card card-checkout">
                    <div class="card-header">Oder Summary</div>
                    <div class="card-body">
                        <div class="cart-text">
                          <h6 class="card-text">Subtotal:</h6>
                          <h6 class="card-text subtotal-ajax">${{Cart::subtotal()}}</h6>
                        </div>
                        <div class="cart-text">
                          <h6 class="card-text">Tax (9%):</h6>
                          <h6 class="card-text tax-ajax">${{Cart::tax()}}</h6>
                        </div>
                        <div class="cart-text">
                          <h6 class="card-text">Discount:</h6>
                          <h6 class="card-text coupon-discount">
                            @if ($cou = Session::get('coupon'))
                                @if ($cou['function']==0)
                                  - {{$cou['discount']}}%
                                @else
                                  {{-- - ${{$cou['discount']}} --}}
                                  <div class="d-flex">- $<h6>{{$cou['discount']}}</h6><div>
                                @endif 
                            @else
                              - $0 
                            @endif
                          </h6>
                        </div>
                        <hr>
                        <div class="cart-text">
                          <h5 class="card-text">Total:</h5>
                          {{-- <h5 class="card-text total-ajax">${{Cart::total()-$cou['discount']}}</h5> --}}
                          <h5 class="card-text total-ajax">
                            @if ($cou = Session::get('coupon'))
                              @if ($cou['function'] == 1)
                                  @if (Cart::total() < $cou['discount'])
                                      $0.00
                                  @else
                                      ${{Cart::total() - $cou['discount']}}
                                  @endif
                              @else
                              asdasdasd
                              @endif
                            @else
                              ${{Cart::total()}}
                            @endif
                          </h5>
                        </div>
                        <a href="{{route('checkout')}}" class="btn btn-checkout">Checkout</a>
                    </div>
                  </div>
            </div>
            <hr class="col-md-8 col-12">
            <h6><i class="fas fa-tag"></i> Coupon</h6>
            <div class="col-md-8 col-12">
              @if(Session::has('coupon_msg'))
                <div class="alert alert-success"><i class="far fa-check-circle"></i>
                {{ Session::get('coupon_msg') }}
                </div>
              @endif
              @if(Session::has('wrong_coupon_msg'))
                <div class="alert alert-danger"><i class="far fa-times-circle"></i>
                {{ Session::get('wrong_coupon_msg') }}
                </div>
              @endif
              {{-- Coupon form --}}
              <form action="{{route('coupon.check')}}" method="POST">
                @csrf
                <input type="text" placeholder="Enter Coupon" name="coupon">
                <button type="submit">Add</button>
              </form>
            </div>
        </div>
        
    </div>
</div>

@endsection