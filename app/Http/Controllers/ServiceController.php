<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ServiceController extends Controller
{
    public function index(){
        return view('pages.home_contact');
    }

    public function send_email(Request $request){
        // Request validation
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'info' => 'required',
            
        ]);

        // Get data request
        $data = $request->all();

        // Send email
        Mail::send('pages.contactMail', array(
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'info' => $data['info'],
        ),function($message) use ($data){
            $message->from($data['email'], $data['name']); 
            $message->to('burgerz.elaravel@gmail.com', 'BurgerZ')->subject($data['subject']); 
        });

        return redirect()->back()->with('success', 'Thank you for your feedback!');

    }
}
