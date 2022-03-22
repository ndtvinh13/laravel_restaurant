<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "This payment is tested purpose"
        ]);
   
        Session::flash('success', 'Payment successful!');
           
        return back();
        
    }

    // public function stripePost()
    // {   
    //     // Enter Your Stripe Secret
    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        		
	// 	$amount = 100;
	// 	$amount *= 100;
    //     $amount = (int) $amount;
        
    //     $payment_intent = \Stripe\PaymentIntent::create([
	// 		'description' => 'Stripe Test Payment',
	// 		'amount' => $amount,
	// 		'currency' => 'INR',
	// 		'description' => 'Payment From Codehunger',
	// 		'payment_method_types' => ['card'],
	// 	]);
	// 	$intent = $payment_intent->client_secret;

	// 	return back()->with(compact('intent'));

    // }
}
