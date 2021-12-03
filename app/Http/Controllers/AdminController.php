<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Session\Session;
use App\Http\Requests;
// session_start();
use App\Models\Category;
use App\Models\Product;

class AdminController extends Controller
{



    public function index()
    {
        // return view('admin_login');
        echo 'Ban da dang nhap thanh cong';
    }

    // public function login(){
    //     return view('admin_login');
    //     // echo 'Ban da dang nhap thanh cong';
    // }

    public function show_dashboard()
    {
        $dataProduct = Product::all();
        $dataProductCount = count($dataProduct);
        $dataCategory = Category::all();
        $dataCategoryCount = count($dataCategory);
        return view('admin.dashboard', ['products' => $dataProductCount], ['categories' => $dataCategoryCount]);
        
    }


    public function product()
    {
        return view('admin.product');
    }


    // public function dashboard(Request $request){
    //     $admin_email = $request->admin_email; //must match with the name in the form
    //     $admin_password = md5($request->admin_password);

    //     $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
    //     if (isset($result)){
    //         Session::put('admin_name',$result->admin_name);
    //         Session::put('admin_id',$result->admin_id);
    //         return Redirect::to('/dashboard');
    //     } else {
    //         //for error message -> use Session::flash instead of Session::put
    //         Session::flash('msg','Invalid username or password');
    //         return Redirect::to('/admin-login');
    //     }
    // }

    public function logout()
    {
        // null -> means to set admin_name and admin_id to null
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin-login');
    }
}
