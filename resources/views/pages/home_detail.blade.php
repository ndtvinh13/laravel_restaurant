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


                            <button type="submit" class="btn btn-cart-detail">Add to Cart</i></button>
                        </div>
                    </div>
                </div>
            </form>
            <hr class="detail-brake-line">
        </div>
    @endforeach
    
    {{-- Related products --}}
    <div class="container related-food-wrapper">    
        
            <div class="row">
                <div class="col-6">
                    <h4 class="mb-3">Related food</h4>
                </div>
                <div class="col-6 btn-related-wrapper">
                    <div>
                        <a class="btn mb-3 mr-1 btn-related" data-bs-target="#carouselExampleIndicators2" type="button" data-bs-slide="prev">
                            <i class="fa fa-arrow-left"></i>
                            </a>
                            <a class="btn mb-3 btn-related" data-bs-target="#carouselExampleIndicators2" type="button" data-bs-slide="next">
                            <i class="fa fa-arrow-right"></i>
                            </a>
                    </div>
                </div>
                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">

                            @foreach($dataRelated as $item)
                                @if($loop->first) {{-- first loop--}}
                                <div class="carousel-item carousel-item-related active">
                                @else
                                <div class="carousel-item carousel-item-related ">
                                @endif
                                    <div class="row">
                                        @foreach($item as $sub)
                                        <div class="col-md-4 mb-3">
                                            <div class="item-related">
                                                <img class="img-fluid img-related" src="{{asset('/public/uploads/products/'.$sub->product_image)}}">
                                            </div>
                                            <div class="text-related">
                                                <p><strong>{{$sub->product_name}}</strong></p>
                                                <p>${{$sub->product_price}}</p>
                                                <button class="btn btn-add-related addItem" product_id ="{{$sub->product_id}}" category_id ="{{$sub->category_id}}">Add to cart</i></button>
                                            </div>
                                        </div>
                                        @endforeach
                        
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        
    </div>

    {{-- Review table --}}
    <hr>
    <div class="container review-wrapper">
        <h4 class="mb-3">Comments <i class="fas fa-comment"></i></h4>
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-2">
                    <img src="{{asset("/public/frontend/images/ava_icon.png")}}" class="img-thumbnail rounded">
                </div>
                <div class="col-md-8 col-10">
                    <div class="row">
                        <div class="col-4"><p><span><i class="fas fa-user-circle"></i> <strong>Name</strong></span></p></div>
                        <div class="col-8"><p><i class="fas fa-clock"></i> day-time</p></div>
                    </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="container comment-section-wrapper">
        <div class="row">
            <div class="col-md-2 col-2 text-center">
                <img src="{{asset("/public/frontend/images/ava_icon.png")}}" height="70" width="70">
            </div>
                <div class="col-md-7 col-10 text-comment-wrapper">
                    <form action="" class="d-flex flex-column">
                        <input type="text" name="name" class="review-name" placeholder="Enter your name" maxlength="15">
                        <textarea name="comment" rows="4" placeholder="Maximum 150 characters..." class="review-text" maxlength="150"></textarea>
                        <input type="hidden" product_id="{{$product->product_id}}">
                        <div class="btn-review-wrapper">
                            <button type="submit" class="btn btn-review"><i class="fas fa-comments"></i></button>
                        </div>
                    </form>
                </div>
        </div>
    </div>

@endsection