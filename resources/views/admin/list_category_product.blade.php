@extends('admin_layout')
@section('admin_content')


    <!-- page content goes here -->
    <!-- Category Add -->
            <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
                <!-- <div class="wrapper-container"> -->
                <div class="page-title">Category List</div>
                <div class="page-content">
                <table class="table table-sm table-hover table-responsive tbl-catlist">
                    <thead>
                    <tr class="bg-warning tbl-header p-0">
                        <th scope="col">Serial Number</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Action*</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @if(Session::has('msg'))
                        <div class="alert alert-success">
                            {{ Session::get('msg') }}
                        </div>
                    @endif
                    <!-- Loop to display created cateogry-->
                    @foreach($category_products as $category_product)
                        <tr class="tbl-content">
                            <td>{{$category_product['category_id']}}</td>
                            <td>{{$category_product['category_name']}}</td>
                            <td>
                                <a href="{{URL::to('/edit-category-product/'.$category_product['category_id'])}}" class="btn btn-primary">Edit</a>
                                <a onclick="return confirm('Do you want to delete?')" href="{{URL::to('/delete-category-product/'.$category_product['category_id'])}}" class="btn btn-danger">Delete</a>
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