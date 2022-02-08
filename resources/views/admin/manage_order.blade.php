@extends('admin_layout')
@section('admin_content')
    
    <!-- page content goes here -->
            <!-- Manage order -->
            <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
                <div class="page-title">Manage Order</div>
                <div class="page-content">
                    <table class="table table-sm table-hover table-responsive tbl-order">
                        <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Customer Name</th>
                            <th scope="col">Shipping#</th>
                            <th scope="col">Payment#</th>
                            <th scope="col">Total</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="col-2">Action*</th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @if(Session::has('msg'))
                            <div class="alert alert-success">
                                {{ Session::get('msg') }}
                            </div>
                        @endif
                        <!-- Loop to display created order-->
                        @foreach($orderData as $item)
                            <tr class="tbl-content">
                                <td>{{$item->user_name}}</td>
                                <td>{{$item->shipping_id}}</td>
                                <td>{{$item->payment_id}}</td>
                                <td>{{$item->total}}</td>
                                <td>{{$item->status}}</td>
                                <td class="col-2">
                                    <a href="{{route('order.view',$item->order_id)}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <a onclick="return confirm('Do you want to delete?')" href="{{route('order.delete',$item->order_id)}}" class="btn btn-danger"><i class="fas fa-eraser"></i></a>
                                </td>
                            </tr>
                        @endforeach
    
                        </tbody>
                    </table>
            </div>
            {{-- Divs --}}


@endsection