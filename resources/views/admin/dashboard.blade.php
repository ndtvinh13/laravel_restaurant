@extends('admin_layout')
@section('admin_content')

        <!-- page content goes here -->
        <!-- Home page -->
            <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">Dashboard</div>
                <div class="page-content container-fluid d-flex justify-content-evenly flex-row">
                  {{-- Product Card --}}
                  <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                    <div class="card-header">Product</div>
                    <div class="card-body">
                      <h5 class="card-title">Number of Products</h5>
                      <hr>
                      <p class="card-text">{{$products}}</p>
                    </div>
                  </div>

                  {{-- Category Card --}}
                  <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">Category</div>
                    <div class="card-body">
                      <h5 class="card-title">Number of Categories</h5>
                      <hr>
                      <p class="card-text">{{$categories}}</p>
                    </div>
                  </div>


                </div>
          </div>
        </div>
      </div>

@endsection