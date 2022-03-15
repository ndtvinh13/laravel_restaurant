@extends('layout')
@section('content')

<div class="container">
    {{-- Title --}}
    <h3 class="title-checkout"><i class="fas fa-unlock-alt"></i> Reset Password</h3>

    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}"><i class="fas fa-chevron-circle-left"></i> Back to Menu</a>
    </div>

    <hr>

    <form action="{{route('user.reset.password.customer')}}" method="POST" class="container d-flex justify-content-center flex-column reset-password-wrapper">
        @csrf
        <div><i class="fas fa-envelope"></i> Please enter your email address</div>
        <input type="email" name="email">
        <div><i class="fas fa-lock-open"></i> Please enter your old password</div>
        <input type="password" name="old_password">
        <div><i class="fas fa-lock"></i> Create a new password</div>
        <input type="password" name="password">
        <div><i class="fas fa-lock"></i> Reenter your new password</div>
        <input type="password" name="confirm_password">
        <input type="hidden" name="user_id" value="{{Auth::guard('customer')->user()->user_id}}">
        <button type="submit" class="btn btn-reset-password">Reset Password</button>
    </form>

</div>
@endsection