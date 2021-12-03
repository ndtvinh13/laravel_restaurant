@extends('admin_layout')
@section('admin_content')

        <!-- page content goes here -->
        <!-- Category List page -->
        <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
            <!-- <div class="wrapper-container"> -->
            <div class="page-title">Category List</div>
            <div class="page-content">

                @if(Session::has('msg'))
                <div class="alert alert-success">
                    {{ Session::get('msg') }}
                </div>
                @endif

                <table class="table table-sm table-hover table-responsive-md tbl-prodlist">
                    <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th class="column-display" scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Type</th>
                            <th scope="col">Action*</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop to display created cateogry from catadd.php -->
                        @foreach($products as $product)
                            <tr>
                                <td>{{$product['product_id']}}</td> {{-- or {{$product->product_id}} --}}
                                <td>{{$product['product_name']}}</td>
                                <td>{{$product['product_price']}}</td>
                                <td>{{$product['category_name']}}</td>
                                <!-- Outputing image -->
                                <td class="column-display"><img src="{{asset('/public/uploads/products/'.$product['product_image'])}}" width=65></td>
                                <!-- Outputing product description -->
                                <td>{{Str::limit($product['product_desc'],30,'...')}}</td>
                                <!-- Ouput type -->
                                <td>
                                    @if($product['product_type'] == 0)
                                        Non-featured
                                    @else
                                        Featured
                                    @endif
                                </td>
                                <td>
                                    <!-- Edit and Delete buttons -->
                                    <a href="{{URL::to('/edit-product/'.$product['product_id'])}}" class="btn btn-primary">Edit</a>
                                    <a onclick="return confirm('Do you want to delete?')" href="{{URL::to('/delete-product/'.$product['product_id'])}}" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <!-- </div> -->
            </div>
          </div>
        </div>
      </div>

@endsection