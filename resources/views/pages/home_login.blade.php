@extends('layout')
@section('content')

        <div class="cust-header">Welcome, Customers!</div>
        <hr class="cust-break">


        <div class="container-fluid all-forms-wrapper">
            <div class="row">
                <div class="col-md-5 form-wrapper">
                    <div class="cust-title">Register</div>
                    <form action="{{route('customer.register')}}" method="POST">
                        @csrf
                        <div class="container">
                            {{-- Error message --}}
                            @if(Session::has('msg'))
                                <div class="alert alert-danger cust-alert">
                                    {{ Session::get('msg') }}
                                </div>
                            @endif

                            @if($errors->first('user_name') || $errors->first('user_email') || $errors->first('user_confirm_password'))
                                <div class="alert alert-warning">All field MUST be required</div>
                            @endif

                            <div class="mb-3">
                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" name="user_name">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email address" name="user_email">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="user_password">
                                @if ($errors->first('user_password'))
                                    @error('user_password')
                                        <div class="alert-warning">{{$message}}</div>
                                    @enderror
                                @endif
                                
                            </div>
                            
                            <div class="mb-3">
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password" name="user_confirm_password">
                            {{-- @error('user_confirm_password')
                                <div class="alert-warning">{{$message}}</div>
                            @enderror --}}
                            </div>
                            <div class="cust-btn-div">
                                <button type="submit" class="btn cust-btn" name="submit_register">Sign up</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-2  mid-title form-wrapper">
                    <div class="cust-title">OR</div>
                </div>
                <div class="col-md-5 form-wrapper">
                    <div class="cust-title">Already registered?</div>
                    
                    <form action="{{route('customer.login')}}" method="POST">
                        @csrf
                        <div class="container">
                            {{-- Error message --}}
                            @if(Session::has('login_msg'))
                                <div class="alert alert-danger cust-alert">
                                    {{ Session::get('login_msg') }}
                                </div>
                            @endif

                            @if($errors->first('userEmail') || $errors->first('userPassword'))
                                <div class="alert alert-warning">All field MUST be required</div>
                            @endif

                            <div class="mb-3">
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email address" name="userEmail">
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="userPassword">
                            </div>
                            <div class="cust-btn-div">
                                <button type="submit" class="btn cust-btn" name="submit_login">Sign in</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection