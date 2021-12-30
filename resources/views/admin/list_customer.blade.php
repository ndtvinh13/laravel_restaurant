@extends('admin_layout')
@section('admin_content')

        <!-- page content goes here -->
        <!-- Category List page -->
        <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
            <!-- <div class="wrapper-container"> -->
            <div class="page-title">Customer List</div>
            <div class="page-content">

                @if(Session::has('msg'))
                <div class="alert alert-success">
                    {{ Session::get('msg') }}
                </div>
                @endif

                <table class="table table-sm table-hover table-responsive-md tbl-prodlist">
                    <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Customer Email</th>
                            {{-- <th scope="col">Password</th> --}}
                            <th scope="col">Updated</th>
                            <th scope="col">Action*</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($customers as $customer)    
                        <tr>
                            <td>{{$customer->user_id}}</td>
                            <td>{{$customer->user_name}}</td>
                            <td>{{$customer->email}}</td>
                            {{-- <td>{{Str::limit($customer->password,15,'xxx')}}</td> --}}
                            <td>{{$customer->updated_at}}</td>
                            <td>
                                <!-- Edit and Delete buttons -->
                                {{-- <a href="" class="btn btn-primary">Edit</a> --}}
                                <a onclick="return confirm('Do you want to delete?')" href="{{route('custdelete',['user_id' => $customer->user_id])}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
    
                    </tbody>
                </table>
                {{-- {{$customers->links()}} --}}
            <!-- </div> -->
            </div>
          </div>
        </div>
      </div>

@endsection