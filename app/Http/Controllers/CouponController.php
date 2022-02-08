<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function add_coupon(){
        return view('admin.add_coupon');
    }

    // Insert Coupon
    public function insert_coupon(Request $request){
        $data = $request->all();
        $coupon = new Coupon();
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_qty = $data['coupon_qty'];
        $coupon->coupon_function = $data['coupon_function'];
        $coupon->coupon_discount = $data['coupon_discount'];
        $coupon->save();

        return redirect()->back()->with('msg','Successfully insert a coupon');
    }

    // List adll coupons
    public function list_coupon(){
        $data = Coupon::orderby('coupon_id','desc')->get();
        return view('admin.list_coupon')->with(compact('data'));
    }

    // Delete coupon
    public function delete_coupon($couponId){
        $data = Coupon::where('coupon_id',$couponId)->first();
        $data->delete();
        return redirect()->back()->with('msg','Successfully Delete an Item!');
    }
}
