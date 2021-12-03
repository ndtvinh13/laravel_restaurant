@extends('admin_layout')
@section('admin_content')

            <!-- page content goes here -->
            <!-- Category Add -->
            <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">Add New Category</div>

                @if($errors->any())
                    <div class="alert alert-danger">Category MUST NOT be empty</div>
                @endif
                
                <div class="page-content d-flex p-5 flex-column">
                    
                    @if(Session::has('msg'))
                        <div class="text-success">
                            {{ Session::get('msg') }}
                        </div>
                    @endif

                    <form action="{{URL::to ('/save-category-product')}}" method="post" class="container-fluid">

                        {{ csrf_field() }}

                        <div class="mb-3 col-auto">
                        <input type="text" class="form-control" placeholder="Please add product category here" name="category_name">
                        </div>
                        <div class="cont-btn">
                        <button type="submit" class="btn btn-success" name="submit" value="Save">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection