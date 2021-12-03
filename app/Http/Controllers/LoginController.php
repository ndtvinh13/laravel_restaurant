<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
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
