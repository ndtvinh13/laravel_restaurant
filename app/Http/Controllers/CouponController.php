<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class CouponController extends Controller
{
    public function add_coupon(){
        return view('admin.add_coupon');
    }

    // Insert Coupon
    public function insert_coupon(Request $request){
        $request->validate([
            'coupon_name' => 'required',
            'coupon_code' => 'required|min:6',
            'coupon_qty' => 'required',
            'coupon_function' => 'required',
            'coupon_discount' => 'required',
            'coupon_start' => 'required',
            'coupon_end' => 'required',

        ]);

        $data = $request->all();

        $today = Carbon::now('America/Los_Angeles')->format('m/d/Y');
        $couponCount = Coupon::where('coupon_code','like','%'.$data['coupon_code'].'%')->count();
        if($couponCount > 0){
            return redirect()->back()->with('warning','The coupon exists!');
        }else{
            
            $coupon = new Coupon();
            $coupon->coupon_name = $data['coupon_name'];
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->coupon_qty = $data['coupon_qty'];
            $coupon->coupon_function = $data['coupon_function'];
            $coupon->coupon_discount = $data['coupon_discount'];
            $coupon->start = $data['coupon_start'];
            $coupon->end = $data['coupon_end'];
            if($today >= $data['coupon_start'] && $today <= $data['coupon_end']){
                $coupon->status = 1;
            }else{
                $coupon->status = 0;
            }
            $coupon->save();
    
            return redirect()->back()->with('msg','Successfully insert a coupon');
        }
    }

    // List adll coupons
    public function list_coupon(){
        $data = Coupon::orderby('coupon_id','desc')->get();
        $today = Carbon::now('America/Los_Angeles')->format('m/d/Y');
        
        foreach ($data as $item){
            if($today >= $item->start && $today <= $item->end && $item->coupon_qty > 0){
                $item->status = 1;
                $item->save();
            }else{
                $item->status = 0;
                $item->save();
            }
        }
        return view('admin.list_coupon')->with(compact('data','today'));
    }

    // Delete coupon
    public function delete_coupon($couponId){
        $data = Coupon::where('coupon_id',$couponId)->first();
        $data->delete();
        return redirect()->back()->with('msg','Successfully Delete an Item!');
    }
}
