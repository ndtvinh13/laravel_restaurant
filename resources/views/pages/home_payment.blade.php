@extends('layout')
@section('content')

<div class="checkout-wrapper">
    @php
        $userName = Auth::guard('customer')->user()->user_name;  
        $userId = Auth::guard('customer')->user()->user_id;
        $shippingId = Session::get('shipping_id');
        $cou = Session::get('coupon');
        $content=Cart::content();
        $cartCount=Cart::content()->count();
    @endphp

    {{-- Session test delete --}}
    @php
        Session::forget('success_card');
    @endphp
    
    {{-- Title --}}
    <h3 class="title-checkout">{{$userName}}, You're almost there!</h3>
    {{-- Directions --}}
    <div class="container-fluid shopping-option">
        <a class="btn" href="{{route('menu')}}"><i class="fas fa-chevron-circle-left"></i> Continue shopping</a>
        <a class="btn" href="{{url()->previous()}}">Back to Checkout <i class="fas fa-chevron-circle-right"></i></a>
    </div>
    <hr>
    @if(Session::has('msg'))
        <div class="alert alert-success"><i class="far fa-check-circle"></i>{{ Session::get('msg') }}
        </div>
    @endif
    {{-- Progress bar --}}
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 50%"></div>
    </div>
    {{-- Order form --}}
    <form action="{{route('order')}}" method="POST">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    {{-- Shipping info --}}
                    <div class="cust-title">Payment Method</div>
                    <div class="container checkout-input">
                        {{-- @if ($errors->any())
                            <div class="alert alert-warning"><i class="far fa-times-circle"></i> Please choose your method below!</div>
                        @endif --}}

                        {{-- Payment table --}}
                        <table class="table table-borderless">
                            <tbody>
                                @if (Session::get('success_paypal') == true)
                                    <tr>
                                        <th scope="row"><input id="pmDebit" type="radio" name="payment" value="debit" disabled></th>
                                        <td><label class="payment-type" for="pmDebit">Debit</label></td>
                                        <td>
                                            <i class="fab fa-cc-visa fa-2x"></i>
                                            <i class="fab fa-cc-mastercard fa-2x"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><input id="pmCredit" type="radio" name="payment" value="credit" disabled></th>
                                        <td><label class="payment-type" for="pmCredit">Credit</label></td>
                                        <td>
                                            <i class="fab fa-cc-visa fa-2x"></i>
                                            <i class="fab fa-cc-mastercard fa-2x"></i>
                                            <i class="fab fa-apple-pay fa-2x"></i>
                                            <i class="fab fa-cc-discover fa-2x"></i>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <th scope="row"><input id="pmDebit" type="radio" name="payment" value="debit" @if (Session::get('success_card'))
                                            disabled
                                        @endif></th>
                                        <td><label class="payment-type" for="pmDebit">Debit</label></td>
                                        <td>
                                            <i class="fab fa-cc-visa fa-2x"></i>
                                            <i class="fab fa-cc-mastercard fa-2x"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><input id="pmCredit" type="radio" name="payment" value="credit" @if (Session::get('success_card'))
                                            checked
                                        @endif></th>
                                        <td><label class="payment-type" for="pmCredit">Credit</label></td>
                                        <td>
                                            <i class="fab fa-cc-visa fa-2x"></i>
                                            <i class="fab fa-cc-mastercard fa-2x"></i>
                                            <i class="fab fa-apple-pay fa-2x"></i>
                                            <i class="fab fa-cc-discover fa-2x"></i>
                                        </td>
                                    </tr>

                                @endif
                                <tr>
                                    <th scope="row"><input id="pmPaypal" type="radio" name="payment" value="paypal" @if (Session::get('success_paypal') == true)
                                        checked
                                    @elseif(Session::get('success_card') == true)
                                        disabled
                                    @endif></th>
                                    <td><label class="payment-type" for="pmPaypal">Paypal</label></td>
                                    <td><i class="fab fa-paypal fa-2x"></i></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="paypal-btn-wrapper"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" value="{{$shippingId}}" name="shipping_id">
                        <input type="hidden" value="{{$userId}}" name="user_id">
                        <div class="container-fluid checkout-text p-0">
                            @if (Session::get('success_paypal') == true)
                                <div class="container-fluid btn-checkout-div p-0">
                                    <button class="btn btn-checkout-sub-paypal" type="submit">Make Payment</button>
                                </div>
                            @else
                                <div class="container-fluid btn-checkout-div p-0">
                                    <button class="btn btn-checkout-sub" type="submit">Make Payment</button>
                                </div>                                
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Review table --}}
                <div class="col-md-5">
                    <div class="cust-title">Review & Payment</div>
                    <div class="container-fluid review-div">
                        <div class="review-text">
                            <h5>Order Summary ({{$cartCount}})</h5>
                            <div><a href="{{route('cart.show')}}" class="review-edit">Edit <i class="fas fa-shopping-cart fa-sm"></i></a></div>
                        </div>
                        {{-- Loop to displayc product --}}
                        @foreach($content as $each_content)
                            <div class="review-text">
                                <div class="d-flex">
                                    <img src="{{asset('/public/uploads/products/'.$each_content->options->image)}}" width=80 height=50/>
                                    <div class="review-info">
                                        <div>{{$each_content->options->category}}</div>
                                        <div>Qty: {{$each_content->qty}}</div>
                                    </div>    
                                </div>
                                <div>${{Cart::subtotal()}}</div>
                            </div>
                            <hr>
                        @endforeach
                        <div class="review-text">
                            <div>Subtotal</div>
                            <div>${{Cart::subtotal()}}</div>
                        </div>
                        <div class="review-text">
                            <div>Sales Tax</div>
                            <div>${{Cart::tax()}}</div>
                        </div>
                        <div class="review-text">
                            <h6>Discount:</h6>
                            <h6 class="coupon-discount">
                              @if ($cou = Session::get('coupon'))
                                @if ($cou['function']==0)
                                  <div class="d-flex">- <h6 discount_val="percent">{{$cou['discount']}}</h6>%<div>
                                @else
                                  {{-- - ${{$cou['discount']}} --}}
                                  <div class="d-flex">- $<h6 discount_val="amount">{{$cou['discount']}}</h6><div>
                                @endif 
                              @else
                                <div class="d-flex">- $<h6>0</h6><div> 
                              @endif
                            </h6>
                        </div>
                        <hr>
                        <div class="review-text">
                            <h5 class="review-text">Total:</h5>
                            <h5 class="review-text total-ajax">
                              @if ($cou = Session::get('coupon'))
                                @if ($cou['function'] == 1)
                                    @if (Cart::total() < $cou['discount'])
                                        ${{$cart_total = number_format(0, 2)}}
                                    @else
                                        ${{$cart_total = Cart::total() - $cou['discount']}}
                                        <input type="hidden" value="{{$cart_total}}" name="cart_total" />
                                    @endif
                                @else
                                  ${{$cart_total = number_format(Cart::total()*( 1 - $cou['discount']/100), 2)}}
                                  <input type="hidden" value="{{$cart_total}}" name="cart_total" />  
                                @endif
                              @else
                                ${{$cart_total = Cart::total()}}
                                <input type="hidden" value="{{$cart_total}}" name="cart_total" />
                              @endif
                            </h5>
                            @if ($cou == true)
                                <input type="hidden" value="{{$cou['code']}}" name="coupon_code">
                            @endif
                        
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>   
    </form>
    <form role="form" action="{{ route('stripe.post') }}" method="post" class="require-validation card-payment-wrapper container col-md-6 col-12 temp-remove"
    data-cc-on-file="false"
    data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
    id="payment-form">
        @csrf

        <div class='form-row row'>
            <div class='col-xs-12 form-group required'>
                <label class='control-label'>Name on Card</label> <input
                    class='form-control' size='4' type='text'>
            </div>
        </div>

        <div class='form-row row'>
            <div class='col-xs-12 form-group required'>
                <label class='control-label'>Card Number</label> <input
                    autocomplete='off' class='form-control card-number' size='20'
                    type='text'>
            </div>
        </div>

        <div class='form-row row'>
            <div class='col-xs-12 col-md-4 form-group cvc required'>
                <label class='control-label'>CVC</label> <input autocomplete='off'
                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                    type='number' onKeyPress="if(this.value.length==3) return false;">
            </div>
            <div class='col-xs-12 col-md-4 form-group expiration required'>
                <label class='control-label'>Expiration Month</label> <input
                    class='form-control card-expiry-month' placeholder='MM' size='2'
                    type='number' onKeyPress="if(this.value.length==2) return false;">
            </div>
            <div class='col-xs-12 col-md-4 form-group expiration required'>
                <label class='control-label'>Expiration Year</label> <input
                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                    type='number' onKeyPress="if(this.value.length==4) return false;">
            </div>
        </div>

        <div class='form-row row'>
            <div class='col-md-12 error form-group hide'>
                <div class='alert-danger alert'>Please correct the errors and try
                    again.</div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-block btn-card-checkout" type="submit">Pay <i class="fas fa-credit-card"></i> (${{$cart_total + 5}})</button>
            </div>
        </div>
        @php
            $total_card = $cart_total + 5;
            Session::put('total_card', $total_card);
        @endphp
    </form>
    {{-- Session put total amount --}}
    @php
        $total_paypal = $cart_total;
        \Session::put('total_paypal',$total_paypal);
    @endphp

    {{$total_paypal}}
    @if (Session::get('success_card'))
        yes.... success_card
    @else
        nooo!!! no succress_card
    @endif
    @if (Session::get('coupon') == true)
        yes
    @else
        no
    @endif
    <hr>

</div>

<script>
    $(document).ready(function () {
        $("input[type='radio']").change(function (e) { 
            e.preventDefault();
            
            if($('#pmPaypal').is(':checked')){
                var str = '<a class="paypal-btn" href="{{ route("processTransaction") }}"><i class="fab fa-paypal"></i> <span>Pay</span><span>Pal</span></a>';
                $('.paypal-btn-wrapper').show().html(str);
                $('.btn-checkout-sub').prop('disabled',true);
                console.log('checked!');  
            }
            else{
                $('.btn-checkout-sub').prop('disabled',false);
                $('.paypal-btn-wrapper').hide();
            }

            if($('#pmCredit').is(':checked')){
                    // $('#payment-form').removeClass('temp-remove');
                    $('#payment-form').fadeIn('slow', function(){
                        $('#payment-form').removeClass('temp-remove');
                    });
                    $('.btn-checkout-sub').prop('disabled',true);
                    console.log('checked!');  
            }else{
                    // $('#payment-form').addClass('temp-remove');
                    $('#payment-form').fadeOut('slow', function(){
                        $('#payment-form').addClass('temp-remove');
                    });
            }
        });

    });
</script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  
<script type="text/javascript">
$(function() {
    var $form         = $(".require-validation");
    $('.require-validation').on('submit', function(e) {
    var $form         = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea','input[type=number]'].join(', '),
        $inputs       = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid         = true;
        $errorMessage.addClass('hide');
 
        $('.has-error').removeClass('has-error');
    $inputs.each(function(i, el) {
        var $input = $(el);
        if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
        }
    });
  
    if (!$form.data('cc-on-file')) {
        e.preventDefault();
        Stripe.setPublishableKey($form.data('stripe-publishable-key'));
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);
    }
  
  });
  
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
  
});
</script>

@endsection