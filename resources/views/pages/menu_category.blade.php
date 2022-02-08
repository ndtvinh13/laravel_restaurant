@extends('menu_layout')
@section('menu-content')



    <div class="menu-items col-md-9">
        @foreach($categoryNames as $categoryName )
        <div class="menu-title">{{$categoryName['category_name']}}</div>
        @endforeach

        <div class="menu-product">
            <div class="container">
                <div class="row">

                    {{-- Loop tp output category products NOT all products--}}
                    {{-- Use this $key => already have to avoid typing again --}}
                    @foreach($dataCatProds as $key=>$product)
                        <div class="col-md-4 col-6">
                            <div class="card menu-card">
                                <img src="{{asset('/public/uploads/products/'.$product['product_image'])}}" height=160  class="card-img-top"/>
                                <div class="card-body">
                                    <h5 class="card-title">{{$product['product_name']}}</h5>
                                    <h6 class="card-title">${{$product['product_price']}}</h6>
                                    <p class="card-text">{{Str::limit($product['product_desc'],20,'...')}}</p>
                                    <a href="" class="btn"><i class="fa fa-shopping-cart fa-xs" aria-hidden="true"></i></a>
                                    {{-- {{URL::to('/product-detail/'.$product['product_id'])}} --}}

                                    {{-- Modal to display the same product --}}
                                    {{-- same data-bs-target and id --}}
                                    <a  class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal{{$product['product_id']}}">More</a>
                                    {{-- This form returns quantity and shopping cart buton --}}

                                    <form action="{{route('cart.save')}}" method="POST">
                                        @csrf
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{$product['product_id']}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    {{-- Modal body --}}
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-5">
                                                                    <img src="{{asset('/public/uploads/products/'.$product['product_image'])}}"  class="card-img-top"/>
                                                                </div>
                                                                <div class="col-md-7 ms-auto">
                                                                    <h5 class="card-title">{{$product['product_name']}}</h5>
                                                                    <h6 class="card-title">${{$product['product_price']}}</h6>
                                                                    <p class="card-text">{{$product['product_desc']}}</p>
                                                                    <p class="card-text fst-italic fw-bold">{{$product['product_type']==0 ? 'None featured' : 'Featured'}}</p>
                                                                    
                                                                    <div class="qty-box">
                                                                        <label class="fw-bold">Quantity:</label>
                                                                        <div class="menu-btn dec">-</div>
                                                                        <input class="quantity-input" type="number" value="1" name="quantity"/>
                                                                        <div class="menu-btn inc">+</div>
                                                                    </div>
                                                                    <input type="hidden" name="product_hidden" value="{{$product['product_id']}}"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Modal footer --}}
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn"><i class="fa fa-shopping-cart fa-xs" aria-hidden="true"></i></button>
                                                        <button type="button" class="btn" data-bs-dismiss="modal">Back</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
           
                                </div>
                            </div>
                        </div> 
                    @endforeach

                    {{-- Paginator --}}
                    {{$dataCatProds->links()}}

                </div>
            </div>
        </div>
        
        </div>
    </div>



@endsection