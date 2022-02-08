<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request){
        // Seo meta
        $meta_desc = "A burger restaurant that provides quality food for everyone. Our full BurgerZ's menu features everything from breakfast menu items, burgers, and more!";
        $meta_keywords = "burgers and drinks";
        $meta_title = "BurgerZ Restaurant";
        $url_canonical = $request->getRequestUri();

        return view('pages.home')->with(compact('meta_desc','meta_keywords','meta_title', 'url_canonical'));
        // Instead of using multiple with, use compact()
    }

}
