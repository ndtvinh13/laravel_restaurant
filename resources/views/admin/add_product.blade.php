@extends('admin_layout')
@section('admin_content')
        
        <!-- page content goes here -->
        <!-- Add product -->
        <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
            <div class="page-title">Add New Product</div>
            <div class="page-content">

                <!-- Error message either successful or fail -->
                @if(Session::has('msg'))
                    <div class="alert alert-success">
                        {{ Session::get('msg') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">All fields MUST be required</div>
                @endif
  
                <!-- enctype is a MUST to import images -->
                <form action="{{URL::to("/save-product")}}" method="post" enctype="multipart/form-data">
                    <table class="table table-borderless tbl-product">

                        {{ csrf_field() }}
                    <!-- Name section -->
                    <tr>
                        <td>Name</td>
                        <td><input type="text" class="form-control" placeholder="Enter a Product Name" name="product_name"></td>
                    </tr>
  
                    <!-- Category seciton -->
                    <tr>
                        <td>Category</td>
                        <td>
                        <select class="form-select" aria-label="Default select example" name="category_id">
                            <option selected>Select a Category</option>
                            
                            {{-- loop to output Categories --}}
                            @foreach($category_products as $category_product)                     
                                <option value="{{$category_product['category_id']}}">{{$category_product['category_name']}}</option>
                            @endforeach

                        </select>
                        </td>
                    </tr>
  
                    <!-- Description secton -->
                    <tr>
                        <td>Description</td>
                        <td>
                        <textarea class="form-control" rows="4"placeholder="Leave a description" id="floatingTextarea" name="product_desc"></textarea>
                        </td>
                    </tr>
    
                    <!-- Price Section -->
                    <tr>
                        <td>Price</td>
                        <td><input type="text" class="form-control" placeholder="Enter a Price" name="product_price"></td>
                    </tr>
    
                    <!-- Image Section -->
                    <tr>
                        <td>Image Upload</td>
                        <td><input type="file" name="product_image" /></td>
                    </tr>
    
                    <!-- Type section -->
                    <tr>
                        <td>Product Type</td>
                        <td>
                        <select class="form-select" aria-label="Default select example" name="product_type" >
                            <option selected>Select a Type</option>
                            <option value="1">Featured</option>
                            <option value="0">Non-Featured</option>
                        </select>
                        </td>
                    </tr>
    
                    <!-- Button Section -->
                    <tr>
                        <td></td>
                        <td><button type="submit" class="btn btn-success" name="submit" value="Save">Save</button></td>
                    </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>

@endsection