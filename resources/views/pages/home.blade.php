@extends('layout')
@section('content')


<!-- carousel -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{('public/frontend/images/burger_1.jpg')}}" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>First slide label</h5>
          <p>Some representative placeholder content for the first slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{('public/frontend/images/burger_2.jpg')}}" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Second slide label</h5>
          <p>Some representative placeholder content for the second slide.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="{{('public/frontend/images/burger_3.jpg')}}" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h5>Third slide label</h5>
          <p>Some representative placeholder content for the third slide.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</header>



<!-- <div class="container-fluid" id="break-line"></div> -->
<div class="d-flex flex-column align-items-center justify-content-center order-now">
  <div class="order-p1-2">
    <h1 class="order-p1">Order</h1>
    <h1 class="order-p2"><span> with us now!</span></h1>
  </div>
  <button class="btn btn-order" id="btn-order">
    <a class="btn-order-link" href="{{route('menu')}}">Order</a>
  </button>
</div>




<div class="container-fluid" id="aboutus">
    <div class="row">
        <div class="col-lg-6 column-left"><img src="public/frontend/images/burger_about_1.jpg"></div>
        <div class="col-lg-6 column-right ">
          <h1 class="aboutus-heading text-center">About Us</h1>
          <p class="paragraph">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
          </p>
        </div>
    </div>
</div>

<!-- <div class="container-fluid" id="break-line"></div> -->

<div class="testimonials">
  <h1>You can review....</h1>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card comment-card">
          <img src="" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card comment-card">
          <img src="" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title2</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card comment-card">
          <img src="" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title3</h5>
            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </p>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<div class="container-fluid m-specials">
  <h1 class="text-center">Here are our specials</h1>
  <div class="row">
    <div class="col-md-4"><span>Drink</span><img src="{{('public/frontend/images/side_1.jpeg')}}"></div>
    <div class="col-md-4"><span>main course</span><img src="{{('public/frontend/images/side_2.jpeg')}}"></div>
    <div class="col-md-4"><span>side</span><img src="{{('public/frontend/images/side_3.jpeg')}}"></div>
  </div>
</div>

<div class="container-fluid end-text">
  <h1>We ensure to bring to the customers our best service and experience</h1>
</div>


@endsection 