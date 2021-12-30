<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class CustomerController extends Controller
{
    public function index(){
        return view('pages.home_login');
    }

    //Customer list
    public function list_customer(){
        $dataCustomer = Customer::all();
        return view('admin.list_customer')->with('customers',$dataCustomer);
    }

    //Customer delete
    public function delete_customer(Request $request){
        $customerId = $request->user_id;
        $dataCustomer = Customer::find($customerId);
        $dataCustomer->delete();
        return redirect()->route('custlist')->with('msg', 'Delete a customer succesfully!');
    }

    //Customer register
    public function register(Request $request){
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required',
            'user_password' => 'required|min:6',
            'user_confirm_password' => 'required'
        ]);

        //Get all request values
        $data = $request->all();
        
        $userCount = Customer::where('email',$data['user_email'])->count();
        if($userCount>0){
            return redirect()->back()->with('msg','The account is already created!');
        }elseif($data['user_password'] != $data['user_confirm_password']){
            return redirect()->back()->with('msg','Password is not matched!');
        }else{
            $customer = new Customer();
            $customer->user_name = $data['user_name'];
            $customer->email = $data['user_email'];
            $customer->password = bcrypt($data['user_password']);
            $customer->save();

            $credentials = [
                'email'=> $data['user_email'],
                'password'=>$data['user_password']
            ];

            if(Auth::guard('customer')->attempt($credentials)){
                return redirect()->route('menu')->with('msg','Successfully registered');
            }

        }

    }

    //Customer login
    public function login(Request $request){
        $request->validate([
            'userEmail' => 'required',
            'userPassword' => 'required',
        ]);

        $email = $request->userEmail;
        $pass = $request->userPassword;
        $credentials = [
            'email' => $email,
            'password'=>$pass
        ];
        if(Auth::guard('customer')->attempt($credentials)){
            return redirect()->route('menu');
        }else{
            return redirect()->back()->with('login_msg','Invalid email or password');
        }
    }

    //Customer logout
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('customer');
    }

}
