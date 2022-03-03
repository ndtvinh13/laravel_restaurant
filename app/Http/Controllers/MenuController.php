<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;


class MenuController extends Controller
{
    public function index(){
        $dataCategory = Category::select('category_name','category_id')->orderby('category_id','desc')->get();
        $dataProduct = Product::select()->orderby('category_id','desc')->paginate(9);

        // return view('pages.menu',['products'=>$dataProduct],['categories'=>$dataCategory]);
        return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);
    }

    //Category on menu page
    public function category_menu($category_id){
        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        $dataProduct = Product::select()->orderby('category_id','desc')->get();

        $dataCatProd = Product::join('tbl_category_product', 'tbl_product.category_id', '=','tbl_category_product.category_id')->where('tbl_product.category_id',$category_id)->paginate(9);

        $categoryName = Category::select()->where('tbl_category_product.category_id',$category_id)->get();

        // If more than 3 arguments -> use this with()
        return view('pages.menu_category')->with('products',$dataProduct)->with('categories',$dataCategory)->with('dataCatProds',$dataCatProd)->with('categoryNames',$categoryName);
    }

    public function product_detail($product_id){
        $dataCategory = Category::select()->orderby('category_id','desc')->get();
        $dataProduct = Product::select()->orderby('category_id','desc')->get();

        $dataDetail = Product::join('tbl_category_product', 'tbl_product.category_id', '=','tbl_category_product.category_id')->where('tbl_product.product_id',$product_id)->get();

        foreach($dataDetail as $item){
            $categoryId = $item->category_id;
        }

        // Get all products with the same category id
        $dataRelated = Product::join('tbl_category_product', 'tbl_product.category_id', '=','tbl_category_product.category_id')->where('tbl_category_product.category_id',$categoryId)->whereNotIn('product_id',[$product_id])->get()->chunk(3);

        // Get all product comments with the same product id
        $dataComment = Comment::where('product_id',$product_id )->where('status',0)->paginate(5);
        $commentCount = Comment::where('product_id',$product_id )->where('status',0)->get()->count();

        return view('pages.home_detail')->with('products',$dataProduct)->with('categories',$dataCategory)->with('dataDetails',$dataDetail)->with(compact('dataRelated','dataComment','commentCount'));
    }

    //Search product using ajax
    public function search_product(Request $request){
        $query = $request->get('term');
        $dataProduct = Product::where('product_name','LIKE','%'.$query.'%')->get();

        $data=[];
        foreach ( $dataProduct as $item){
            $data[] = [
                'value'=> $item->product_name,
                'id' => $item->product_id
            ];
        }if(count($data)){
            return $data;
        }else{
            return ['value'=>'No Item Found!','id'=>''];
        }
    }

    public function search_product_ajax(Request $request){
        if($request->ajax()){
            $query = $request->get('query');
            $data = Product::where('product_name','like','%'.$query.'%')->orderby('product_id','desc')->get();
            $dataCount = $data->count();
            $output = '';
            if($dataCount > 0){
                $output .= '
                <div class="filer-box">
                    <ul class="menu-search">';

                    foreach($data as $item){
                        $output .= '
                        <li class="search-item-product"><img src="'.url('/public/uploads/products/'.$item->product_image).'" width="30" height="25" /><span>'.$item->product_name.'</span></li>
                        ';
                    }

                $output .= '
                    </ul>
                </div>
                ';
            } else {
                $output .= '
                <div class="filer-box">
                    <ul class="menu-search">
                        <li>Product not found!</li>
                    </ul>
                </div>';
            }

            $result = [];
            $result['data'] = $output;

            echo json_encode($result);
        }
    }

    //Search result 
    public function search_result(Request $request){
        $item = $request->search_item;
        //Use first() instead of get() -> to get the first value of the collection
        $dataProduct = Product::where('product_name','LIKE','%'.$item.'%')->first();
        $productName = Product::select('product_name')->where('product_name','LIKE','%'.$item.'%')->value('product_name');
        if(isset($item)){
            if($item == $productName){
                toast('Nice choice!','success')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
                return redirect()->route('product.detail',['product_id'=>$dataProduct->product_id]);
            }else{
                toast('No item found!','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
                return redirect()->route('menu');
            }

        }else{
            return redirect()->route('menu');
        }
    }
    
    //Sort products
    public function sort_product(Request $request){
        if($request->get('sort')=='price_des'){
            $dataProduct = Product::orderby('product_price','desc')->paginate(9);
            $dataCategory = Category::select('category_name','category_id')->orderby('category_id','desc')->get();
            return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);

        }elseif($request->get('sort')=='price_asc'){
            $dataProduct = Product::orderby('product_price','asc')->paginate(9);
            $dataCategory = Category::select('category_name','category_id')->orderby('category_id','desc')->get();
            return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);

        }elseif($request->get('sort')=='popularity'){
            $dataProduct = Product::where('product_type',1)->paginate(9);
            $dataCategory = Category::select('category_name','category_id')->orderby('category_id','desc')->get();
            return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);
        }
    }
}
