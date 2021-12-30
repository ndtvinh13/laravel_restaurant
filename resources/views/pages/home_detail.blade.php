@extends('layout')
@section('content')

    @foreach($dataDetails as $product)
        <div class="detail-wrapper">

            {{-- Title --}}
            <h3 class="title-checkout">Food Detail</h3>

            <div class="container-fluid">
                <a class="btn" href="{{route('menu')}}">Back to Menu</a>
                {{-- <div>Another search box??</div> --}}
                <hr class="detail-brake-line">
            </div>
            <form action="{{route('cart.save')}}" method="POST">
                @csrf
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5 detail-image">
                            {{-- Make the image circle --}}
                            <img src="{{asset('/public/uploads/products/'.$product['product_image'])}}"  class="card-img-top detail-img-cont p-0"/>
                        </div>
                        <div class="col-md-6 mx-0">
                            <h5 class="card-title">{{$product['product_name']}}</h5>
                            <h6 class="card-title">${{$product['product_price']}}</h6>
                            <input type="hidden" name="category_hidden" value="{{$product['category_id']}}">
                            <p class="card-text">{{$product['product_desc']}}</p>
                            <p class="card-text fst-italic fw-bold">{{$product['product_type']==0 ? 'None featured' : 'Featured'}}</p>
                            {{-- Quantity box --}}
                            <div class="qty-box">
                                <label class="fw-bold">Quantity:</label>
                                <div class="menu-btn dec">-</div>
                                <input class="quantity-input" type="" value="1" name="quantity"/>
                                <div class="menu-btn inc">+</div>
                            </div>

                            <input type="hidden" name="product_hidden" value="{{$product['product_id']}}"/>

                            @if (Auth::guard('customer')->check())
                                {{-- {{Cart::instance(Auth::guard('customer')->user())->store()}} --}}
                            @endif

                            <button type="submit" class="btn btn-cart-detail">Add to Cart</i></button>
                        </div>
                    </div>
                </div>
            </form>
            <hr class="detail-brake-line">
        </div>
    @endforeach

    Review Table here

@endsection