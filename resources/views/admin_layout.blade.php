<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF"
      crossorigin="anonymous"
    />
    <!-- Css Links -->
    <link href="{{asset('public/backend/css/admin.css')}}" rel="stylesheet" />
    <link href="{{asset('public/backend/css/layout.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font -->
    <link
      href="https://fonts.googleapis.com/css?family=Pacifico"
      rel="stylesheet"
    />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="{{asset('/public/backend/ckeditor5-build-classic/ckeditor.js')}}"></script>
    {{-- <script type="text/javascript">CKEDITOR.replace('ckeditor1')</script> --}}
    <!-- JQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script> -->

    <title>Admin_index</title>
  </head>
  <body>
    <main class="container-fluid p-0">
      <!-- navbar======== -->
      <nav class="navbar">
        <div class="container-fluid">
          <div class="d-flex align-items-center">
            <a class="navbar-brand" href="#">BurgerZ</a>
            <div>Admin page & Configuration</div>
          </div>
          <div class="d-flex align-items-center">
            @php
                $user = Auth::user();
            @endphp


              <div>Hello, {{ $user->admin_name }} !</div>
              <hr />
              <a href="{{route('admin.logout')}}">Log out</a>

          </div>
        </div>
      </nav>
      <!-- end of navbar -->


      <div class="container-fluid row flex-nowrap px-0 d-flex">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 row-second">
          <!-- col-auto col-md-2 col-lg-2 col-sm-3 px-sm-2 px-0 bg-dark -->
          <!-- px for padding left and right -> set it to 0 -->
          <div
            class="
              d-flex
              flex-column
              align-items-center
              align-items-sm-start
              text-white
              left-side
            "
          >
          <!--px-3
              pt-2 -->
            <a
              href=""
              class="
                d-flex
                align-items-center
                pb-3
                mb-md-0
                me-md-auto
                text-white text-decoration-none
              "
            >
              <span class="fs-5 d-none d-sm-inline">Settings</span>
            </a>
            <ul
              class="
                nav nav-pills
                flex-column
                mb-sm-auto mb-0
                align-items-center align-items-sm-start
              "
              id="menu"
            >
            @php
                $cRN=Route::currentRouteName();
            @endphp
            


              <!-- Dashboard -->
              <li class="nav-item {{$cRN=='dashboard' ? 'active-tab' : ''}}">
                <a href="{{URL::to('/dashboard')}}"
                  class="nav-link px-0 align-middle main-link {{$cRN=='dashboard' ? 'active-tab-child' : ''}}"
                >
                <i class="fas fa-tachometer-alt"></i>
                  <span class="ms-1 d-none d-sm-inline">Dashboard</span>
                </a>
              </li>

              <!-- Order -->
              <li class="nav-item">
                <a class="nav-link px-0 align-middle main-link" href="#submenu3"
                data-bs-toggle="collapse">
                  <i class="fa fa-calendar"></i>
                  <span class="ms-1 d-none d-sm-inline">Orders</span>
                </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                  <li class="{{$cRN=='order.manage' ? 'active-tab' : ''}}">
                    <a href="{{route('order.manage')}}" class="nav-link px-0 second-link {{$cRN=='order.manage' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Manage Order</span> - </a>
                  </li>
                </ul>
              </li>

              <!-- Products -->
              <li class="nav-item">
                <a
                  data-bs-toggle="collapse"
                  href="#submenu2"
                  class="nav-link px-0 align-middle main-link "
                >
                  <i class="fa fa-inbox"></i>
                  <span class="ms-1 d-none d-sm-inline">Products</span>
                </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                  <li class="{{$cRN=='prodadd' ? 'active-tab' : ''}}">
                    <a href="{{URL::to('/add-product')}}" class="nav-link px-0 second-link {{$cRN=='prodadd' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Product Add</span> + </a>
                  </li>
                  <li class="{{$cRN=='prodlist' ? 'active-tab' : ''}}">
                    <a href="{{URL::to('/list-product')}}" class="nav-link px-0 second-link {{$cRN=='prodlist' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Product List</span> + </a>
                  </li>
                </ul>
              </li>

              <!-- Category -->
              <li class="nav-item">
                <a
                  class="nav-link px-0 align-middle main-link"
                  href="#submenu1"
                  data-bs-toggle="collapse"
                >
                  <i class="fa fa-list-alt"></i>
                  <span class="ms-1 d-none d-sm-inline">Category</span>
                </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                  <li class="{{$cRN=='catadd' ? 'active-tab' : ''}}">
                    <a href="{{URL::to('/add-category-product')}}" class="nav-link px-0 second-link {{$cRN=='catadd' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Category Add</span> * </a>
                  </li>
                  <li class="{{$cRN=='catlist' ? 'active-tab' : ''}}">
                    <a href="{{URL::to('/list-category-product')}}" class="nav-link px-0 second-link {{$cRN=='catlist' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Category List</span> * </a>
                  </li>
                </ul>
              </li>

              <!-- Coupon -->
              <li class="nav-item">
                <a
                  class="nav-link px-0 align-middle main-link"
                  href="#submenu4"
                  data-bs-toggle="collapse"
                >
                  <i class="fas fa-tags"></i>
                  <span class="ms-1 d-none d-sm-inline">Coupon</span>
                </a>
                <ul class="collapse show nav flex-column ms-1" id="submenu4" data-bs-parent="#menu">
                  <li class="{{$cRN=='coupon.add' ? 'active-tab' : ''}}">
                    <a href="{{route('coupon.add')}}" class="nav-link px-0 second-link {{$cRN=='coupon.add' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Coupon Add</span> * </a>
                  </li>
                  <li class="{{$cRN=='coupon.list' ? 'active-tab' : ''}}">
                    <a href="{{route('coupon.list')}}" class="nav-link px-0 second-link {{$cRN=='coupon.list' ? 'active-tab-child' : ''}}"> <span class="d-none d-sm-inline">Coupon List</span> * </a>
                  </li>
                </ul>
              </li>

              <!-- Customers -->
              <li class="nav-item {{$cRN=='custlist' ? 'active-tab' : ''}}">
                <a href="{{route('custlist')}}" class="nav-link px-0 align-middle main-link {{$cRN=='custlist' ? 'active-tab-child' : ''}}">
                  <i class="fa fa-users"></i>
                  <span class="ms-1 d-none d-sm-inline">Customers</span>
                </a>
              </li>

              <!-- Comment -->
              <li class="nav-item {{$cRN=='comment.list' ? 'active-tab' : ''}}">
                <a href="{{route('comment.list')}}" class="nav-link px-0 align-middle main-link {{$cRN=='comment.list' ? 'active-tab-child' : ''}}">
                  <i class="fas fa-comment-alt"></i>
                  <span class="ms-1 d-none d-sm-inline">Comment</span>
                </a>
              </li>
            
            </ul>
          
          </div>
        </div>
     

        <!-- page content goes here -->
        @yield('admin_content')
      </div>
      </div>
    
    </main>

    <!-- footer====== -->
    <!-- use php to apply fpr all pages -->
    <footer>BurgerZ © Copyright 2021</footer>

    {{-- Scripts --}}
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ"
      crossorigin="anonymous"
    ></script>
    <script src="{{asset('/public/backend/js/script.js')}}"></script>
  </body>
</html>

