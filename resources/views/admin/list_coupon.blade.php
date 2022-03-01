@extends('admin_layout')
@section('admin_content')

        <!-- page content goes here -->
        <!-- Coupon List page -->
        <div class="container-fluid page-ti-co p-0 col-11 col-sm-8 col-md-8">
            <!-- <div class="wrapper-container"> -->
            <div class="page-title">Coupon List</div>
            <div class="page-content">

                @if(Session::has('msg'))
                <div class="alert alert-success">
                    {{ Session::get('msg') }}
                </div>
                @endif

                <table class="table table-sm table-hover table-responsive-md tbl-prodlist">
                    <thead>
                        <tr class="bg-warning tbl-header p-0">
                            <th scope="col">Name</th>
                            <th scope="col">Start</th>
                            <th scope="col">End</th>
                            <th scope="col">Code</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Function</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action*</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{$item->coupon_name}}</td>
                                <td>{{$item->start}}</td>
                                <td>{{$item->end}}</td>
                                <td>{{$item->coupon_code}}</td>
                                <td>{{$item->coupon_qty}}</td>
                                <td>
                                    @if ($item->coupon_function == 0 )
                                        By %
                                    @else
                                        By Amount
                                    @endif
                                </td>
                                <td>
                                    @if ($item->coupon_function == 0)
                                        - {{$item->coupon_discount}}%
                                    @else
                                        - ${{$item->coupon_discount}}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == 1)
                                        <div class="coupon-status-active">Active</div>
                                    @else
                                        <div class="coupon-status-inactive">Inactive</div>
                                    @endif
                                </td>
                                <td>
                                    <!-- Edit and Delete buttons -->
                                    <a onclick="return confirm('Do you want to delete?')" href="{{route('coupon.delete',$item->coupon_id)}}" class="text-danger"><i class="fas fa-eraser"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            <!-- </div> -->
            </div>
          </div>
        </div>
      </div>

@endsection