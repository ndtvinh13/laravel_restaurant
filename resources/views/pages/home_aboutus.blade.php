@extends('layout')
@section('content')
    @php
        $user = Auth::guard('customer')->user();
    @endphp
    
    <div class="aboutus-wrapper">
        {{-- Title --}}
        <h3 class="title-checkout"><i class="fas fa-store"></i> About Us</h3>
        <hr>
        
        <img src="{{asset('/public/frontend/images/burger_aboutus.jpg')}}" id="aboutus_image">

        <div class="container aboutus-ourstory">
            <div class="row">
                <div class="col-md-6">
                    <h4>Our story starts with one man.</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        
                        @foreach ($dataProduct as $item)
                            <div class="col-4">
                                <img src="{{asset('/public/uploads/products/'.$item->product_image)}}" height=50>
                                <div class="aboutus-product-overlay">
                                    <div class="overlay-text">
                                        <a href="{{route('product.detail',['product_id'=>$item->product_id])}}"><i class="fas fa-hamburger aboutus-hamburger "></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

        <div class="container aboutus-category">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">

                        @foreach ($dataCategory as $item)
                            <div class="col-6">
                                <a href="{{route('menu.category',$item->category_id)}}">{{$item->category_name}}</a>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Our serving categories</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
                </div>
            </div>
        </div>
        
    </div>
@endsection