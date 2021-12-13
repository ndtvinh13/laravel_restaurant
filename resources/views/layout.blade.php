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
    <link href="{{asset('public/frontend/css/nav.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/aboutus.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/cart.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/menu.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/detail.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/customer.css')}}" rel="stylesheet" />

    <!-- font -->
    <link href="{{asset('https://fonts.googleapis.com/css?family=Pacifico')}}" rel='stylesheet'>
    <link
    rel="stylesheet"
    href="{{asset('http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')}}"
    />

    <title>Restaurant</title>
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
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 d-flex">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{URL::to('/menu')}}">Menu</a>
              </li>
              <li class="nav-item dropdown active">
                <a
                  class="nav-link dropdown-toggle active"
                  href="#"
                  id="navbarDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  Services
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Contact</a></li>
                  <li><a class="dropdown-item" href="#">About Us</a></li>
                  <li><a class="dropdown-item" href="#">Location</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="fa fa-shopping-cart fa-xs" aria-hidden="true"></i><span class="cart-count">{{Cart::content()->count();}}</span></a>
              </li>
              <li>
              <li class="nav-item">
                @php
                  $user = Auth::guard('customer')->user();
                @endphp
                @if (Auth::guard('customer')->check())
                  <div>Hello, {{ $user->user_name }} !</div>
                  <a href="{{route('customer.logout')}}">Log out</a>
                @else
                  <a class="nav-link active" aria-current="page" href="{{route('customer')}}"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
                @endif
              </li>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      {{-- Move-to-top button --}}
      <div id="btn-top-wrapper-wrapper"> 
        <div class="btn-top-wrapper">
       
          <div id="btn-move-top">
            <i class="fa fa-chevron-up"></i>
          </div>
        </div>
      </div>
    </header>

    

    <main>  
      {{-- Content --}}
      @yield('content')
    </main> 


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
    <script src="{{asset('public/frontend/js/scrolltop.js')}}"></script>
</html>
