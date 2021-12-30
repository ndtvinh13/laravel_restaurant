<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

use function Psy\sh;

class CheckoutController extends Controller
{
    public function index(){
        if(Auth::guard('customer')->check()){
            return view('pages.home_checkout');
        }
            return redirect()->route('customer');
    }

    public function save_checkout(Request $request){
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'note' => 'nullable'

        ]);
        //Array to get all requested values
        $data = $request->all();
        
        //Update shipping address when there is one that exists
        $dataShipping = Shipping::where('user_id', $data['user_id'])->first();
        if($shippingCount = Shipping::where('user_id', $data['user_id'])->count() > 0){
            $dataShipping->email = $data['email'];
            $dataShipping->name = $data['name'];
            // $dataShipping->user_id = $data['user_id'];
            $dataShipping->address = $data['address'];
            $dataShipping->phone = $data['phone'];
            $dataShipping->note = $data['note'];
            $dataShipping->update();

            return redirect()->route('payment')->with('msg','Shipping order is successfully created!');
        }

        $shipping = new Shipping();
        $shipping->email = $data['email'];
        $shipping->name = $data['name'];
        $shipping->user_id = $data['user_id'];
        $shipping->address = $data['address'];
        $shipping->phone = $data['phone'];
        $shipping->note = $data['note'];
        $shipping->save();

        return redirect()->route('payment')->with('msg','Shipping order is successfully created!');
    }

    //Payment
    public function payment(){
        return view('pages.home_payment');
    }

    //Place order
    public function place_order(){
        return "adsadsadsad";
    }
}
