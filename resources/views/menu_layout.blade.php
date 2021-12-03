<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css')}}"
      rel="stylesheet"    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="{{asset('public/frontend/css/nav.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/aboutus.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/menu.css')}}" rel="stylesheet" />

    <!-- font -->
    <link href="{{asset('https://fonts.googleapis.com/css?family=Pacifico')}}" rel='stylesheet'>
    <link
    rel="stylesheet"
    href="{{asset('http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')}}"
    />

    <title>Menu</title>
  </head>
  <body>
    <header class="header">
      <!-- Navigation bar -->
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{URL::to('/main-page')}}">BurgerZ</a>
          <button
            class="navbar-toggler ms-auto"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span></span>
            <span></span>
            <span></span>
          </button>

          <divs
            class="collapse navbar-collapse justify-content-between"
            id="navbarSupportedContent"
          >
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 ">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{URL::to('/main-page')}}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{URL::to('/menu')}}">Menu</a>
              </li>
              <li class="nav-item dropdown active">
                <a
                  class="nav-link dropdown-toggle active"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Services
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="{{route('contact')}}">Contact</a></li>
                  <li><a class="dropdown-item" href="#">About Us</a></li>
                  <li><a class="dropdown-item" href="#">Location</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="fa fa-shopping-cart fa-xs" aria-hidden="true"></i></a>
              </li>
              <li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
              </li>
              </li>
            </ul>
            {{-- search bar --}}
            <form class="d-flex" action="{{route('search.result')}}" id="search-form" method="POST">
              @csrf

              <input
                class="form-control me-2 box-search"
                type="search"
                placeholder="Find food ..."
                aria-label="Search"
                id="search_text"
                name="search_item"
              />
              <button class="btn" type="submit" name="btn_search">
                <i class="fa fa-search"></i>
              </button>
            </form>

          </div>
        </div>
      </nav>
      
      <!-- carousel -->
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="{{asset('public/frontend/images/burger_1.jpg')}}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>First slide label</h5>
              <p>Some representative placeholder content for the first slide.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{asset('public/frontend/images/burger_2.jpg')}}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h5>Second slide label</h5>
              <p>Some representative placeholder content for the second slide.</p>
            </div>
          </div>
          <div class="carousel-item">
            <img src="{{asset('public/frontend/images/burger_3.jpg')}}" class="d-block w-100" alt="...">
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
    
   
    

    <main>
      
      <hr class="page-break">
      <div class="container-fluid p-0">
        <span class="fw-bold font-weight-bold">Sort By:</span>
        <a href="{{route('menu')}}" class="sort-font">All</a>
        <a href="{{route('sort').'?sort=price_des'}}" class="sort-font">Price - High to Low</a>
        <a href="{{route('sort').'?sort=price_asc'}}" class="sort-font">Price - Low to High</a>
        <a href="{{route('sort').'?sort=popularity'}}" class="sort-font">Popularity</a>
      </div>
      
      <div class="menu-content container-fluid col-auto p-0">
        <div class="row">
          <div class="categories col-md-3">
            <div class="menu-title">Categories</div>

            {{-- Loop for outputing all categories --}}
            @foreach($categories as $category)
              <div class="cat-name-wrapper"><a class="cat-name" href="{{URL::to('/category/'.$category['category_id'])}}">{{$category['category_name']}}</a></div>
            @endforeach


          </div>

          {{-- Content --}}
          @yield('menu-content')
        
        
        </div>
      </div>
    <main>
    

    {{-- footer --}}
    <div class="container-fluid footer">
        <div class="footer-info">
          <a class="navbar-brand footer-left" href="{{URL::to('/main-page')}}">BurgerZ</a>
          <div class="footer-right">
            <a href="#"><i class="fa fa-facebook-square fa-lg"></i></a>
            <a href="#"><i class="fa fa-instagram fa-lg"></i></a>
          </div>
        </div>
        <hr style="color:#fd7e14;">
        <p class="">Copyright © 2021</p>
      </div>
  
  
  </body>
  
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
    <script src="{{asset('public/frontend/js/quantity.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script>
      $(document).ready(function(){
        
        src="{{ route('search.product') }}";
        $( "#search_text" ).autocomplete({
          source: function(request,response){
            $.ajax({
              url: src,
              data:{
                term: request.term
              },
              dataType:"json",
              success:function(data){
                response(data);
              }

            })
          },
          minLength:1,
        });
        
        $(document).on('click','ui-menu-item',function(){
          $('#search-form').submit();
        });

      });
      
    </script>
</html>
