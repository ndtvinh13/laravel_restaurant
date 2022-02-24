@extends('admin_layout')
@section('admin_content')

        <!-- page content goes here -->
        <!-- Category List page -->
        <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
            <!-- <div class="wrapper-container"> -->
            <div class="page-title">Comment List</div>
            <div class="page-content">

                @if(Session::has('msg'))
                <div class="alert alert-success">
                    {{ Session::get('msg') }}
                </div>

                

                @endif
                <div class="customer-search-wrapper container-fluid p-0 d-flex align-items-center">
                    <input class="form-control comment-search-ajax" type="text" placeholder="Enter Customer Name" aria-label="default input example">
                    <i class="fas fa-search-dollar fa-2x"></i>
                </div>
                <table class="table table-sm table-hover table-responsive-md tbl-prodlist table-striped">
                    <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Status</th>
                            <th scope="col">Name</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Product</th>
                            <th scope="col">Action*</th>
                        </tr>
                    </thead>
                    <tbody class="comment-tbody">
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
                        url: "{{route('comment.search.ajax')}}",
                        data: {query: query},
                        success: function (response) {
                            searchData(response);
                        }
                    });
                }
                function searchData(resp){
                    let item = JSON.parse(resp);
                    let data = item.data;
                    $('.comment-tbody').html(data)
                }

                $('.comment-search-ajax').keyup(function () { 
                    var query = $(this).val();
                    fetch_customer_data(query);
                });
          });
      </script>

      {{-- comment approval --}}
      <script>
        $(document).ready ( function () {
            $(document).on ("click", ".btn-comment", function () {
                var comment_status = $(this).attr('comment_status');
                var comment_id = $(this).attr('comment_id');
                // only $(this) NOT $(this).html() :[[
                var current = $(this);
                console.log(comment_status, comment_id, current);
                $.ajax({
                    type: "get",
                    url: "{{route('comment.approval.ajax')}}",
                    data: {comment_status: comment_status, comment_id: comment_id},
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        current.replaceWith(response);
                    }
                });
            });
        });
      </script>
@endsection
