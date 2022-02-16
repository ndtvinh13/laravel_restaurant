@extends('admin_layout')
@section('admin_content')
    
    <!-- page content goes here -->
            @php
                $phoneNo = $orderById->phone;
            @endphp
            <!-- Manage order details -->
            <div class="container-fluid page-ti-co-order p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">List Order Details</div>
                <div class="page-content-order">
                    <div class="list-order-title">Customer Info</div>
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
                    <div class="list-order-title">Shipping Info</div>
                    <table class="table table-sm table-hover table-responsive tbl-order">
                        <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Method</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone#</th>
                            <th scope="col">Note</th>
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
                                <td>{{$orderById->method}}</td>
                                <td>{{$orderById->address}}</td>
                                <td>({{substr($phoneNo, 0, 3).') '.substr($phoneNo, 3, 3).'-'.substr($phoneNo,6)}}</td>
                                <td>{{$orderById->note}}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                    
                    <br><br>
                    <hr class="hr-order-detail">
                    <div class="list-order-title">Order Details</div>
                    <table class="table table-sm table-hover table-responsive tbl-order">
                        <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Product Name</th>
                            <th scope="col">Coupon</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Sub-Total</th>
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
                                <td>{{$item->coupon_code}}</td>
                                <td>{{$qty = $item->product_sale_quantity}}</td>
                                <td>${{$price = $item->product_price}}</td>
                                <td>${{$subtotal = $qty * $price}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"><b>Discount</b></td>
                            <td>
                                @if ($couponCode != "none")
                                    @if ($couponFuction == 1)
                                        - ${{$couponDiscount}}
                                    @else
                                        - {{$couponDiscount}}%
                                    @endif
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"><b>Total</b> <em>(After Tax and Discount)</em></td>
                            <td><u>${{$item->total}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="1"><b>Order Code</b></td>
                            <td><u>{{$item->code}}</u></td>
                        </tr>
                        <tr>
                            <td colspan="1"><b>Print Order</b></td>
                            <td><a href="{{route('order.print',$item->code)}}"><i class="fas fa-print fa-lg"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>    
            </div>
@endsection