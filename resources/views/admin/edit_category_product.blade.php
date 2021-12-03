@extends('admin_layout')
@section('admin_content')

            <!-- page content goes here -->
            <!-- Category Update -->
            <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">Update New Category</div>
                <div class="page-content d-flex p-5 flex-column">

                    @if(Session::has('msg'))
                        <div class="alert alert-success">
                            {{ Session::get('msg') }}
                        </div>
                    @endif

                    <form action="{{URL::to ('/update-category-product/'.$category_products['category_id'])}}" method="post" class="container-fluid">

                        {{ csrf_field() }}
                        <input  class="form-control" value="{{$category_products['category_id']}}">
                        <div class="mb-3 col-auto">
                        <input type="text" class="form-control" placeholder="Please add product category here" name="category_name" value="{{$category_products['category_name']}}">
                        </div>
                        <div class="cont-btn">
                        <button type="submit" class="btn btn-success" name="submit" value="Update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection