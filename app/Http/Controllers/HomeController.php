<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class HomeController extends Controller
{
    public function index(Request $request){
        // Seo meta
        $meta_desc = "A burger restaurant that provides quality food for everyone. Our full BurgerZ's menu features everything from breakfast menu items, burgers, and more!";
        $meta_keywords = "burgers and drinks";
        $meta_title = "BurgerZ Restaurant";
        $url_canonical = $request->getRequestUri();

        // Coupon popup
        $coupon = Coupon::select('coupon_code')->where('status', 1)->value('coupon_code');
        // $output = 'Discover the discount'.$coupon.'';

        // alert()->image('Dont miss out...',html($output),'https://media.gettyimages.com/photos/white-gift-box-with-red-ribbon-bow-on-blue-background-with-confetti-picture-id1190392505?b=1&k=20&m=1190392505&s=170667a&w=0&h=pQzA1o13vWagLtYFzq3JsXvehYurlhHgQ4nXEL0tP84=','500px','200px','0');

        return view('pages.home')->with(compact('meta_desc','meta_keywords','meta_title', 'url_canonical','coupon'));
        // Instead of using multiple with, use compact()
    }

    // 404 error
    public function error_404(){
        return view('errors.404');
    }

    // 500 error
    public function error_500(){
        return view('errors.500');
    }
}
