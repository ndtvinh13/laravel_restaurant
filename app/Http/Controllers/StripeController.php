<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripeController extends Controller
{
    public function stripePost(Request $request)
    {
        // creating stipe customer
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        // $stripe->customers->create([
        //     'name' => 'vinh',
        //     'description' => 'My First Test Customer (created for API docs)',
        //   ]);
        $total = Session::get('total_card');

        if($total == 0){
            return redirect()->back()->with('info','Total needs to be at least $1 before proceeding to checkout!');
        }

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $total * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from BurgerZ"
        ]);
        
        Session::put('success_card',true);
        Session::flash('success', 'Payment successful!');
           
        return back();
        
    }

}
