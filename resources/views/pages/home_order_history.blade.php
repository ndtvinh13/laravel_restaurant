@extends('layout')
@section('content')

<div class="container-fluid order-history-wrapper">
    {{-- Title --}}
    <h3 class="title-checkout"><i class="fas fa-history"></i> Order History</h3>

    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}"><i class="fas fa-chevron-circle-left"></i> Back to Menu</a>
    </div>

    <hr>

    <label><strong>ALL PAST ORDERS</strong> <i class="fas fa-caret-down"></i></label>
    <div class="container-fluid p-3">
        <div class="row">
            <div class="col-md-4">{{$orderCount}} Total Orders</div>
            <div class="col-md-8 d-flex justify-content-sm-end">{{$order->links()}}</div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-middle order-history-table">
            <thead class="order-history-thead">
                <tr>
                    <th scope="col">Number</th>
                    <th scope="col">Order Code</th>
                    <th scope="col">Date</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">View</th>
                </tr>
            </thead>
            <tbody>
                @if ($orderCount > 0)
                    @foreach ($order as $key => $value)
                        <tr>
                            <td>{{$order->firstItem() + $key}}</td>
                            <td>{{$value->code}}</td>
                            <td>{{date('m-d-Y', strtotime($value->created_at))}}</td>
                            <td>${{$value->total}}</td>
                            <td>
                                @if ($value->status == 'Processing')
                                    <div class="order-process-status">{{$value->status}}</div>
                                @else
                                    <div class="order-complete-status">{{$value->status}}</div>
                                @endif
                            </td>
                            <td class="text-center"><a href="{{route('user.order.history.details',$value->order_id)}}"><i class="fas fa-eye"></i></a></td>
                        </tr> 
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">You have not placed any orders.</td>
                    </tr>
                @endif

            </tbody>
        </table>
        
    </div>
</div>

@endsection