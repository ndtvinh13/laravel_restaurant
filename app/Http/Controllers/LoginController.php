<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use App\Rules\captcha;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    function index()
    {
        return view('admin_login');
    }

    function login(Request $request)
    {
        $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),
        ]);

        $user = $request->admin_email;
        $pass = $request->admin_password;
        $credentials = [
            'email' => $user,
            'password' => $pass
        ];
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            Session::flash('msg','Invalid username or password');
            return redirect()->route('loginPage');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('loginPage');
    }
}
