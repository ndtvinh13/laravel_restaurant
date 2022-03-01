@extends('admin_layout')
@section('admin_content')
        
        <!-- page content goes here -->
        <!-- Add coupon -->
        <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
            <div class="page-title">Add New Coupon</div>
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
                <form action="{{route('coupon.insert')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-borderless tbl-product">
                    <!-- Name section -->
                    <tr>
                        <td>Coupon Name</td>
                        <td><input type="text" class="form-control" placeholder="Enter a coupon name" name="coupon_name"></td>
                    </tr>

                    <!-- Code section -->
                    <tr>
                        <td>Coupon Code</td>
                        <td>
                            <input type="text" class="form-control" placeholder="Enter a coupon code" name="coupon_code">
                            @if ($errors->first('coupon_code'))
                            @error('coupon_code')
                                <div class="alert-warning"><i class="fas fa-exclamation"></i> {{$message}}</div>
                            @enderror
                            @endif
                        </td>
                    </tr>
  
                    <!-- Coupon number -->
                    <tr>
                        <td>Coupon Quantiy</td>
                        <td><input type="text" class="form-control" placeholder="Enter a quantity" name="coupon_qty"></td>
                    </tr>
                    
                    <!-- Coupon function -->
                    <tr>
                        <td>Coupon Function</td>
                        <td>
                            <select class="form-select" aria-label="Default select example" name="coupon_function" >
                                <option selected>Select discount type</option>
                                <option value="0">By %</option>
                                <option value="1">By Amount</option>
                            </select>
                        </td>
                    </tr>
    
                    <!-- Coupon discount input -->
                    <tr>
                        <td>% or Amount</td>
                        <td><input type="text" class="form-control" name="coupon_discount"></td>
                    </tr>
                    
                    <!-- Coupon start-end date input -->
                    <tr>
                        <td>Start Date</td>
                        <td><input type="text" class="form-control" name="coupon_start" id="start_date"></td>
                    </tr>
                    <tr>
                        <td>End Date</td>
                        <td><input type="text" class="form-control" name="coupon_end" id="end_date"></td>
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