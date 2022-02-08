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
                <div class="customer-search-wrapper container-fluid p-0 d-flex align-items-center">
                    <input class="form-control customer-search-ajax" type="text" placeholder="Enter Customer Name" aria-label="default input example">
                    <i class="fas fa-search-dollar fa-2x"></i>
                </div>
                <table class="table table-sm table-hover table-responsive-md tbl-prodlist table-striped">
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
                    <tbody class="customer-tbody">
                        {{-- table body display --}}
                        
    
                    </tbody>
                </table>
                {{-- {{$customers->links()}} --}}
            <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
      {{-- customer search ajax --}}
      <script>
          $(document).ready(function () {
                fetch_customer_data();
                function fetch_customer_data(query = ''){
                    $.ajax({
                        method: "get",
                        url: "{{route('cust.search.ajax')}}",
                        data: {query: query},
                        success: function (response) {
                            // console.log(response);
                            // $('.customer-tbody').html(response.data)
                            searchData(response);
                        }
                    });
                }
                function searchData(resp){
                    let item = JSON.parse(resp);
                    let data = item.data;
                    $('.customer-tbody').html(data)
                }

                $('.customer-search-ajax').keyup(function () { 
                    var query = $(this).val();
                    fetch_customer_data(query);
                });
          });
      </script>
@endsection