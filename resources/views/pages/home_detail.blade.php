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
                            <h5 class="card-title"><strong>{{$product['product_name']}}</strong></h5>
                            <h6 class="card-title">${{$product['product_price']}}</h6>
                            <input type="hidden" name="category_hidden" value="{{$product['category_id']}}">
                            <p class="card-text">{{$product['product_desc']}}</p>
                            <p class="card-text fst-italic fw-bold">{{$product['product_type']==0 ? 'None featured' : 'Featured'}}</p>
                            {{-- Quantity box --}}
                            <div class="qty-box">
                                <label class="fw-bold">Quantity:</label>
                                <div class="menu-btn dec">-</div>
                                <input class="quantity-input" value="1" name="quantity"/>
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
        <h4 class="mb-3">Comments <i class="fas fa-comment"></i> ({{$commentCount}})</h4>
        @if ($commentCount > 0)
            {{-- If there are comments --}}
            @foreach ($dataComment as $comment)
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-2">
                            <img src="{{asset("/public/frontend/images/ava_icon.png")}}" class="img-thumbnail rounded">
                        </div>
                        <div class="col-md-8 col-10">
                            <div class="row">
                                <div class="col-4"><p><span><i class="fas fa-user-circle"></i> <strong>{{$comment->name}}</strong></span></p></div>
                                <div class="col-8"><p><i class="fas fa-clock"></i> {{date('d-m-Y h:i A', strtotime($comment->created_at))}}</p></div>
                            </div>
                            <p>{{$comment->comment}}</p>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
            <div class="container comment-paginate">
                {{$dataComment->links()}}
            </div>
            <hr>
        @else
            {{-- If there is no comment --}}
            <div class="container text-center">
                <i class="fas fa-comment-dots fa-lg"></i>
                <h5>No Comments Yet</h5>
            </div>
            <hr>
        @endif
        
    </div>

    
    {{-- Comment box --}}
    <div class="container comment-section-wrapper">
        <div class="row">
            <div class="col-md-2 col-2 text-center">
                <img src="{{asset("/public/frontend/images/ava_icon.png")}}" height="70" width="70">
            </div>
            <div class="col-md-7 col-10 text-comment-wrapper">

                @if(Session::has('msg'))
                <div class="alert alert-success"><i class="far fa-check-circle"></i>
                    {{ Session::get('msg') }}
                </div>
                @endif

                {{-- rating stars --}}
                <div class="rating-wrapper">
                    <div class="rating-css">
                        <div class="star-icon">
                            <input type="radio" value="1" name="product_rating" checked id="rating1">
                            <label for="rating1" class="fa fa-star"></label>
                            <input type="radio" value="2" name="product_rating" id="rating2">
                            <label for="rating2" class="fa fa-star"></label>
                            <input type="radio" value="3" name="product_rating" id="rating3">
                            <label for="rating3" class="fa fa-star"></label>
                            <input type="radio" value="4" name="product_rating" id="rating4">
                            <label for="rating4" class="fa fa-star"></label>
                            <input type="radio" value="5" name="product_rating" id="rating5">
                            <label for="rating5" class="fa fa-star"></label>
                        </div>
                    </div>

                </div>

                <form action="{{route('comment')}}" method="POST" class="d-flex flex-column">
                    @csrf
                    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}" class="review-token"> --}}
                    @if (Auth::guard('customer')->check())
                        @php
                            $userName = Auth::guard('customer')->user()->user_name;
                        @endphp
                        <p>Hi, <b>{{$userName}}</b>, How do you think?</p>
                        <input type="hidden" name="name" class="review-name" value="{{$userName}}">
                    @else
                        Share your thoughts:
                        <input type="text" name="name" class="review-name" placeholder="Enter your name" maxlength="15">
                    @endif
                        
                    
                    @if ($errors->first('name'))
                        @error('name')
                            <div class="alert-warning" style="width: 200px;"><i class="fas fa-exclamation"></i> {{$message}}</div>
                        @enderror
                    @endif
                    
                    <textarea name="comment" rows="4" placeholder="Maximum 150 characters..." class="review-comment-text" maxlength="150"></textarea>
                    
                    @if ($errors->first('comment'))
                        @error('comment')
                            <div class="alert-warning"><i class="fas fa-exclamation"></i> {{$message}}</div>
                        @enderror
                   
                        @endif
                    <input type="hidden" value="{{$product->product_id}}" name="product_id" class="productId">
                    <div class="btn-review-wrapper">
                        <button type="submit" class="btn btn-review"><i class="fas fa-comments"></i></button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
{{-- {{now()->toDateTimeString()}} --}}
@endsection