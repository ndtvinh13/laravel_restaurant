@extends('menu_layout')
@section('menu-content')


    <div class="menu-items col-md-9">
        <div class="menu-title">@lang('lang.food')</div>
        <div class="menu-product">
            <div class="container">
                <div class="row">

                    {{-- Loop tp output products --}}
                    @foreach($products as $product)
                        <div class="col-md-4 col-6">
                            <div class="card menu-card">
                                <div class="menu-card-img">
                                    <img src="{{asset('/public/uploads/products/'.$product['product_image'])}}" height=160  class="card-img-top">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{$product['product_name']}}</h5>
                                    <h6 class="card-title">${{$product['product_price']}}</h6>
                                    <p class="card-text">{{Str::limit($product['product_desc'],20,'...')}}</p>
                                    <a href="{{route('product.detail',['product_id'=>$product->product_id])}}" class="btn">Detail <i class="fa fa-shopping-cart fa-xs" aria-hidden="true"></i></a>
                                    <button class="btn addItem" product_id ="{{$product->product_id}}" category_id ="{{$product->category_id}}" ><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div> 
                    @endforeach

                    {{-- Paginator --}}
                    {{$products->links()}}
                </div>
            </div>
        </div>
        </div>
    </div>

{{-- <!-- a Tag for previous page -->
    <a href="{{$products->previousPageUrl()}}">
        <!-- You can insert logo or text here --><
    </a>
    @for($i=0;$i<=$products->lastPage();$i++)
        <!-- a Tag for another page -->
        <a href="{{$products->url($i)}}">{{$i}}</a>
    @endfor
    <!-- a Tag for next page -->
    <a href="{{$products->nextPageUrl()}}">
        <!-- You can insert logo or text here -->
    </a> --}}


@endsection