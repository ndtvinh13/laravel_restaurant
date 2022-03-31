@extends('layout')
@section('content')

<div class="container">
    {{-- Title --}}
    <h3 class="title-checkout"><i class="fas fa-box-open"></i> Order Details</h3>

    <div class="container-fluid shopping-option">
        <a class="btn" href="{{url()->previous()}}"><i class="fas fa-chevron-circle-left"></i> Back to Orders</a>
    </div>

    <hr>

    @php
    $phoneNo = $orderById->phone;
    @endphp
    <!-- Manage order details -->
    <div class="container-fluid order-history-details-wrapper">
        <label><strong><i class="fas fa-list-ul"></i> LIST ORDER DETAILS</strong> <i class="fas fa-caret-down"></i></label>
        <div class="container d-flex order-item-date">
            <div><strong>Order Date:</strong> {{date('m-d-Y', strtotime($orderById->created_at))}}</div>
            <div class="d-flex"><strong>Order Status: </strong> 
                @if ($mangeOrderStatus == "Processing")
                    <div class="order-process-status">{{$mangeOrderStatus}}  <i class="fas fa-ellipsis-h"></i></div>
                @else
                    <div class="order-complete-status">{{$mangeOrderStatus}} <i class="fas fa-check"></i></div>
                @endif 
            </div>   
        </div>

        {{-- General Info --}}
        <div class="container order-item-info-wrapper">
            <div class="row">
                <div class="col-md-4 col-4">
                    <div><i class="fas fa-building"></i> <strong>BurgerZ Company</strong></div>
                    <div><i class="fas fa-clipboard-list"></i> <strong>Order #:</strong> {{$orderById->code}}</div>
                    <div><i class="fas fa-user"></i> <strong>Name:</strong> {{$orderById->name}}</div>
                </div>
                <div class="col-md-4 col-4">
                    <div><i class="fas fa-map-marker-alt"></i> <strong>Address:</strong></div>
                    <div>{{$orderById->address}}</div>
                    <div>{{$orderById->email}}</div>
                    <div>{{$orderById->phone}}</div>
                </div>
                <div class="col-md-4 col-4">
                    <div><i class="fas fa-coins"></i> <strong>Order Total:</strong></div>
                    <div>${{$orderById->total}}</div>
                </div>
            </div>
        </div>

        {{-- Loop product info --}}
        @php
            $i = 0;
            $subtotal_all = 0;
        @endphp
        @foreach ($orderDetailsById as $item)
            @php
                $i++;
            @endphp
            <div class="container order-item-details-wrapper">
                <div class="row">
                    <div class="col-md-6 order-name-detail col-6">{{$item->product_name}}</div>
                    <div class="col-md-3 col-2">Qty: {{$qty = $item->product_sale_quantity}}</div>
                    <input type="hidden" value="{{$price = $item->product_price}}">
                    <div class="col-md-3 col-4">${{$subtotal = $qty * $price}}</div>
                    <input type="hidden" value="{{$subtotal_all += $subtotal}}">
                </div>
            </div>
        @endforeach

        {{-- payment and Summary --}}
        <div class="container order-item-summary-wrapper">
            <div><i class="fas fa-money-check"></i> <strong>Payment Details</strong></div>
            <div class="row">
                <div class="col-md-5 order-item-payment">
                    <div><strong>Payment Method</strong></div>
                    <div>{{$orderById->method}}</div>
                </div>
                <div class="col-md-5 order-item-sum">
                    <div><strong>Order Summary</strong></div>
                    <div class="d-flex order-item-sum">
                        <div>Subtotal (<small>{{$i}} Items</small>)</div>
                        <div>${{$subtotal_all}}</div>
                    </div>
                    <div class="d-flex order-item-sum">
                        <div>Tax</div>
                        <div>
                            @if($couponCode != "none")
                                @if($couponFuction == 1)
                                    ${{number_format($orderById->total + $couponDiscount - $subtotal_all,2)}}
                                @else
                                    ${{number_format($orderById->total/(1 - $couponDiscount/100) - $subtotal_all,2)}}
                                @endif
                            @else
                                ${{number_format($orderById->total - $subtotal_all,2)}}
                            @endif
                        </div>
                    </div>
                    <div class="d-flex order-item-sum">
                        <div>Discount</div>
                        <div>
                            @if ($couponCode != "none")
                                @if ($couponFuction == 1)
                                    - ${{$couponDiscount}}
                                @else
                                    - {{$couponDiscount}}%
                                @endif
                            @else
                                0
                            @endif
                        </div>
                    </div>
                    <div class="d-flex order-item-sum">
                        <div><strong>Total</strong></div>
                        <div>${{$orderById->total}}</div>
                    </div>
                    <hr>
                    <div class="text-center"><small><em>Final taxes will be calculated upon order fulfillment.</em></small></div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection