@extends('layout')
@section('content')

<div class="cart-wrapper">


    {{-- Title --}}
    <h3 class="title-checkout">Your Shopping Cart</h3>

    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}">Continue shopping</a>
        <div class="btn">Go to Checkout</div>
    </div>

    <hr>

    @if(Session::has('msg'))
    <div class="alert alert-success">
        {{ Session::get('msg') }}
    </div>
    @endif

    @php
        $cartCount=Cart::content()->count();
        // echo "<pre>";
        // print_r($cartCount);
        // echo "</pre>";
    @endphp

    @php
        $content=Cart::content();
        // echo "<pre>";
        // print_r($content);
        // echo "</pre>";
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

                    <tbody>
                    @if(Auth::guard('customer')->check())
                      This is user table
                      {{dd(Cart::instance(Auth::guard('customer')->user())->content())}}
                    @else  
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
                              <div class="menu-btn dec">-</div>
                              <input class="quantity-input" type="" value="{{$each_content->qty}}" name="quantity"/>
                              <div class="menu-btn inc">+</div>
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
                        <td>{{"$".$total = $each_content->price * $each_content->qty}}</td>
                        <td>
                          <a href="{{route('cart.delete',['rowId' => $each_content->rowId])}}"><i class="fa fa-trash fa-lg"></i></a>
                        </td>
                      </tr>
                      @endforeach
                      {{-- End of loop --}}
                    
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
                          <h6 class="card-text">${{Cart::subtotal()}}</h6>
                        </div>
                        <div class="cart-text">
                          <h6 class="card-text">Tax (9%):</h6>
                          <h6 class="card-text">${{Cart::tax()}}</h6>
                        </div>
                        <hr>
                        <div class="cart-text">
                          <h5 class="card-text">Total:</h5>
                          <h5 class="card-text">${{Cart::total()}}</h5>
                        </div>
                        <a href="#" class="btn btn-checkout">checkout</a>
                    </div>
                  </div>
            </div>
        </div>
    </div>

    {{-- <h3 class="title-checkout">Thank you for choosing BurgerZ</h3>
    <h3 class="title-checkout">Hope to see you soon!</h3> --}}

</div>

@endsection