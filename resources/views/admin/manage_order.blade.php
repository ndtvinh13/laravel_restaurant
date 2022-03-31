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
                            <th scope="col">Code</th>
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
                                <td>{{$item->code}}</td>
                                <td>{{$item->payment_id}}</td>
                                <td>{{$item->total}}</td>
                                <td>

                                    @if ($item->status == "Processing")
                                        <input type="button" value="Processing" order_status="Received" class="order-status-btn order-status-process" order_id="{{$item->order_id}}">
                                    @else 
                                        <input type="button" value="Received" order_status="Processing" class="order-status-btn order-status-receive" order_id="{{$item->order_id}}">
                                    @endif

                                </td>
                                <td class="col-2">
                                    <a href="{{route('order.view',$item->order_id)}}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                    <a  href="{{route('order.delete',$item->order_id)}}" class="btn btn-danger submit-form"><i class="fas fa-eraser"></i></a>
                                </td>
                            </tr>
                        @endforeach
    
                        </tbody>
                    </table>
            </div>
            {{-- Divs --}}
        
            <script>
                $(document).ready(function () {
                    $(document).on ("click", ".order-status-btn", function () {
                        let status = $(this).attr('order_status');
                        let orderId = $(this).attr('order_id');
                        console.log(status, orderId);
                        let current = $(this);
                        Swal.fire({
                            toast: true,
                            title: "Order status is updated!",
                            icon: "success",
                            position: "top-end",
                            padding: '1rem',
                            width: '400px',
                            timer: 1500,
                            showConfirmButton: false,
                            timerProgressBar: true,
                        });
                        $.ajax({
                            type: "get",
                            url: "{{route('order.status')}}",
                            data: {status: status, orderId: orderId},
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