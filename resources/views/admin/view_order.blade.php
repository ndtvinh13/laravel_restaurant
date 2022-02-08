@extends('admin_layout')
@section('admin_content')
    
    <!-- page content goes here -->
            <!-- Manage order details -->
            <div class="container-fluid page-ti-co-order p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">List Order Details</div>
                <div class="page-content-order">
                    <caption>Customer Info</caption>
                    <table class="table table-sm table-hover table-responsive tbl-order">
                        <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Customer Name</th>
                            <th scope="col">Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @if(Session::has('msg'))
                            <div class="alert alert-success">
                                {{ Session::get('msg') }}
                            </div>
                        @endif
                            <tr class="tbl-content">
                                <td>{{$orderById->user_name}}</td>
                                <td>{{$orderById->address}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <br><br>
                    <hr class="hr-order-detail">
                    <caption>Shipping Info</caption>
                    <table class="table table-sm table-hover table-responsive tbl-order">
                        <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Shipping#</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone#</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @if(Session::has('msg'))
                            <div class="alert alert-success">
                                {{ Session::get('msg') }}
                            </div>
                        @endif
                        
                        <!-- Loop to display created order-->
                        
                            <tr class="tbl-content">
                                <td>{{$orderById->shipping_id}}</td>
                                <td>{{$orderById->address}}</td>
                                <td>{{$orderById->phone}}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                    
                    <br><br>
                    <hr class="hr-order-detail">
                    <caption>Order Details</caption>
                    <table class="table table-sm table-hover table-responsive tbl-order">
                        <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @if(Session::has('msg'))
                            <div class="alert alert-success">
                                {{ Session::get('msg') }}
                            </div>
                        @endif

                        <!-- Loop to display created order-->
                        @foreach ($orderDetailsById as $item)
                            <tr class="tbl-content">
                                <td>{{$item->product_name}}</td>
                                <td>{{$item->product_sale_quantity}}</td>
                                <td>{{$item->product_price}}</td>
                                <td>{{$item->total}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>    
            </div>
@endsection