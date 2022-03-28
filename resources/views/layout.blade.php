<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    {{-- Meta --}}
    {{-- <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$url_canonical}}" />
    <meta property="og:title" content="{{$meta_title}}" /> --}}
    {{-- End Meta --}}
    <link
      href="{{asset('https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css')}}"
      rel="stylesheet"    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link href="{{asset('public/frontend/css/nav.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/aboutus.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/cart.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/menu.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/detail.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/customer.css')}}" rel="stylesheet" />
    <link href="{{asset('public/frontend/css/checkout.css')}}" rel="stylesheet" />

    <!-- font -->
    <link href="{{asset('https://fonts.googleapis.com/css?family=Pacifico')}}" rel='stylesheet'>
    <link
    rel="stylesheet"
    href="{{asset('http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')}}"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{asset('https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
    <script src="{{asset('public/frontend/js/jquery.creditCardValidator.js')}}"></script>

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
                <a class="nav-link active" aria-current="page" href="{{route('main.page')}}">Home</a>
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
                  Services <i class="fas fa-angle-down point-down"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Contact</a></li>
                  <li><a class="dropdown-item" href="#">About Us</a></li>
                  <li><a class="dropdown-item" href="#">Location</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{route('cart.show')}}"><i class="fa fa-shopping-cart fa-sm" aria-hidden="true"></i><span class="cart-count">{{Cart::content()->count();}}</span></a>
              </li>
              <li>
              <li class="nav-item">
                @php
                  $user = Auth::guard('customer')->user();
                @endphp
                @if (Auth::guard('customer')->check())
                  <div class="customer-wrapper">
                    <div><u>Hello, {{ $user->user_name }}</u> <i class="fas fa-angle-double-down fa-xs point-down"></i></div>
                    <ul class="dropdown-menu customer-dropdown">
                      <li><a class="dropdown-item" href="{{route('user.order.history')}}"><i class="fas fa-box fa-xs"></i> Order History</a></li>
                      <li><a class="dropdown-item" href="{{route('user.reset.password')}}"><i class="fas fa-key fa-xs"></i> Change password</a></li>
                      <li><a class="dropdown-item" href="{{route('customer.logout')}}"><i class="fas fa-sign-out-alt fa-sm"></i> Log out</a></li>
                    </ul>
                  </div>
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

      {{-- Current cart will be destroyed when there is no login 
        which will CONFLICT with the idea that if the user needs 
        to be logged in to buy items --> ????? --}}
      @php
        // if(Auth::guard('customer')->check() == FALSE){
        //   Cart::destroy();
        // }
      @endphp
    
    
    {{-- footer --}}
    <div class="container-fluid footer">
        <div class="footer-info">
          <a class="navbar-brand footer-left" href="{{URL::to('/main-page')}}">BurgerZ</a>
          <div class="footer-right">
            <a href="#"><i class="fab fa-facebook-square fa-lg"></i></a>
            <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#"><i class="fab fa-github fa-lg"></i></a>
          </div>
        </div>
        <hr style="color:#fd7e14;">
        <p class="">Copyright © 2021</p>
    </div>
  
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
  </body>
    {{-- Scripts --}}
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
      crossorigin="anonymous"
    ></script>
    <script src="{{asset('public/frontend/js/quantity.js')}}"></script>
    <script src="{{asset('public/frontend/js/scrolltop.js')}}"></script>
    <script src="{{asset('public/frontend/js/custom.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    {{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
    <script>
      // Delete an item with - using Ajax
      $(function (){
        $('.dec').click(function (e){
          let row_id = $(this).attr("row_id");
          let item_qty = $(this).next().val();
          let item_price = $(this).next().attr('item_price');
          let current = $(this).parent().parent().parent().next();
          let sum = item_qty*item_price;
          // console.log(row_id,item_qty,item_price,current);
          let pos = $(this).parent().parent().parent().parent();
          // Delete the item when its quantity = 0 - using ajax
          if(item_qty==0){
            Swal.fire({
              toast: true,
              title: "No item in cart!",
              icon: "error",
              position: "top",
              timer: 1500,
              showConfirmButton: false,
              timerProgressBar: true,
            });
            $.ajax({
              type: "get",
              url: "{{route('cart.item.del.ajax')}}",
              data: {row_id: row_id},
              success: function (response) {
                delItem(response,pos);
              }
            });
          }else{
          $.ajax({
            type: "get",
            url: "{{route('cart.item.ajax')}}",
            data: {row_id: row_id, item_qty: item_qty, item_price: item_price},
            success: function (response) {
              displayItem(response);
              current.each(function(i){
                console.log(current.eq(i).html("$"+sum.toFixed(2)));
              });
            }
          });
          }
        });
      });
      
      // // Add an item with + using Ajax
      // $(function (){
      //   $('.inc').click(function (e){
      //     let row_id = $(this).attr("row_id");
      //     let item_qty = $(this).prev().val();
      //     let item_price = $(this).prev().attr('item_price');
      //     let current = $(this).parent().parent().parent().next();
      //     let sum = item_qty*item_price;
      //     console.log(row_id,item_qty,item_price,current,sum);
      //     $.ajax({
      //       type: "get",
      //       url: "{{route('cart.item.ajax')}}",
      //       data: {row_id: row_id, item_qty: item_qty, item_price: item_price},
      //       success: function (response) {
      //         displayItem(response);
      //         current.each(function(i){
      //           console.log(current.eq(i).html("$"+sum.toFixed(2)));
      //         });
      //       }
      //     });
      //   });
      // });

      // // JSON Parse
      // function displayItem(data){
      //   let coup = parseInt($('.coupon-discount').children().children().first().html());
      //   let discount_val = $('.coupon-discount').children().children().first().attr('discount_val');
      //   console.log(discount_val);
      //   let item = JSON.parse(data);
      //   let count = item.count;
      //   let subtotal = item.subtotal;
      //   let tax = item.tax;
      //   let itemSub = item.itemSub;
      //   // let total = item.total - coup;
      //   let total_amount = item.total - coup;
      //   let total_percent = item.total * (1 - coup/100);
        
      //   if(discount_val == "amount")
      //     if(total_amount < 0){
      //       let neg_total = parseInt(0);
      //       $('.total-ajax').html("$"+neg_total.toFixed(2));
      //     }else{
      //       $('.total-ajax').html("$"+total_amount.toFixed(2));
      //     }
      //   else
      //     $('.total-ajax').html("$"+total_percent.toFixed(2));
        
        
      //   $('.cart-count').html(count);
      //   $('.subtotal-ajax').html("$"+subtotal);
      //   $('.tax-ajax').html("$"+tax);
      // }

      function delItem(data,pos){
              let item = JSON.parse(data);
              let count = item.count;
              let del_item = item.del_item;
              let posi = pos;
              let subtotal = item.subtotal;
              let total = item.total;
              let tax = item.tax;
              $('.cart-count').html(count);
              $('.subtotal-ajax').html("$"+subtotal);
              $('.total-ajax').html("$"+total);
              $('.tax-ajax').html("$"+tax);
              posi.html(del_item);
            }
    </script>
</html>
