<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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

        return view('pages.home_detail')->with('products',$dataProduct)->with('categories',$dataCategory)->with('dataDetails',$dataDetail)->with(compact('dataRelated'));
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

    //Search result 
    public function search_result(Request $request){
        $item=$request->search_item;
        //Use first() instead of get() -> to get the first value of the collection
        $dataProduct=Product::where('product_name','LIKE','%'.$item.'%')->first();
        
        if(isset($item)){
            return redirect()->route('product.detail',['product_id'=>$dataProduct->product_id]);

        }else{
            return redirect()->route('menu');
        }
    }
    
    //Sort products
    public function sort_product(Request $request){
        if($request->get('sort')=='price_des'){
            $dataProduct=Product::orderby('product_price','desc')->paginate(9);
            $dataCategory=Category::select('category_name','category_id')->orderby('category_id','desc')->get();
            return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);

        }elseif($request->get('sort')=='price_asc'){
            $dataProduct=Product::orderby('product_price','asc')->paginate(9);
            $dataCategory=Category::select('category_name','category_id')->orderby('category_id','desc')->get();
            return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);

        }elseif($request->get('sort')=='popularity'){
            $dataProduct=Product::where('product_type',1)->paginate(9);
            $dataCategory=Category::select('category_name','category_id')->orderby('category_id','desc')->get();
            return view('pages.menu')->with('products',$dataProduct)->with('categories',$dataCategory);
        }
    }
}
