<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
// use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class ProductController extends Controller
{
    public function add_product(){

        $dataCategories = Category::all();
        //                              This part using key-value method to pass data to view
        return view('admin.add_product',['category_products'=>$dataCategories]);
        
    }

    public function save_product(Request $request){

        $request->validate([
            'product_name'=>'required',
            'category_id'=> 'required',
            'product_desc'=> 'required',
            'product_price'=> 'required',
            'product_type'=> 'required',
            'product_image' => 'required'
        ]);

        $data = new Product();
        if ($request->hasFile('product_image')){
            $file = $request->file('product_image');
            $ext = $file -> getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(base_path().'/public/uploads/products/',$filename);
            $data->product_image = $filename;

        }

        $data->product_name = $request->product_name;
        $data->category_id = $request->category_id;
        $data->product_desc= $request->product_desc;
        $data->product_price = $request->product_price;
        $data->product_type = $request->product_type;
        $data->save();
        return Redirect::to('/add-product')->with('success','Sucessfully Add a Product!!');
    }

    public function list_product(){
        // $data = Product::all();
        $dataCategory=Category::select()->orderby('category_id','desc')->get();
        $dataProduct=Product::select()->orderby('category_id','desc')->get();
        $dataCatProd=Product::join('tbl_category_product', 'tbl_product.category_id', '=','tbl_category_product.category_id')->get();
        return view('admin.list_product')->with('products',$dataCatProd);
    }


    public function edit_product($product_id){
        $data = Product::find($product_id);
        $dataCategories = Category::all();
        return view('admin.edit_product',['products'=>$data],['category_products'=>$dataCategories]);
        // $data=Product::all();
        // return $data;
    }


    public function update_product(Request $request, $product_id){
        $request->validate([
            'product_name'=>'required',
            'category_id'=> 'required',
            'product_desc'=> 'required',
            'product_price'=> 'required',
            'product_type'=> 'required'
        ]);

        $data = Product::find($product_id);
        if ($request->hasFile('product_image')){
            $path=base_path().'/public/uploads/products/'.$data->product_image;
            //To check if the file exists or not
            if(File::exists($path)){
               File::delete($path); 
            }

            $file = $request->file('product_image');
            $ext = $file -> getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move(base_path().'/public/uploads/products/',$filename);
            $data->product_image = $filename;

        }

        $data->product_name = $request->product_name;
        $data->category_id = $request->category_id;
        $data->product_desc= $request->product_desc;
        $data->product_price = $request->product_price;
        $data->product_type = $request->product_type;
        $data->update();
        return Redirect::to('/list-product')->with('success','Sucessfully Update a Product!!');
    }


    public function delete_product($product_id){
        $data=Product::find($product_id);
        //Delete the product will delete its image
        $path=base_path().'/public/uploads/products/'.$data->product_image;
        //To check if the file exists or not
        if(File::exists($path)){
            File::delete($path); 
        }
        $data->delete();
        return Redirect::to('/list-product')->with('msg','Sucessfully Delete a Product!!');
    }

}
