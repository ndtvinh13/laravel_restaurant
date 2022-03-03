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
                    <th scope="col" class="col-2">Action*</th>
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
                        <td class="col-2">
                            <a href="{{URL::to('/edit-category-product/'.$category_product['category_id'])}}" class="btn btn-primary">Edit</a>
                            <a  href="{{URL::to('/delete-category-product/'.$category_product['category_id'])}}" product_id="{{$category_product->category_id}}" class="btn btn-danger submit-form">Delete</a>
                            {{-- onclick="return confirm('Do you want to delete?')" --}}
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        <!-- </div> -->

        <div class="container d-flex">
            <form action="{{route('admin.import')}}" method="POST" enctype="multipart/form-data">
                @if(Session::has('error_msg'))
                    <div class="text-danger p-0">
                        {{ Session::get('error_msg') }}
                    </div>
                @endif
                @csrf
                    <input type="file" name="file" accept=".xlsx"><br>
                    <input type="submit" value="Import" name="import_csv" class="btn btn-info btn-import">
            </form>
            <form action="{{route('admin.export')}}" method="POST">
                @csrf
                <input type="submit" value="Export" name="export_csv" class="btn btn-warning btn-export">
            </form>
        </div>

        </div>
    </div>

</div>
</div>


<script>
    
</script>

@endsection