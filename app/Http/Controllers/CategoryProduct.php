<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Category;


class CategoryProduct extends Controller
{   
    //Add product category
    public function add_category_product(){
        return view('admin.add_category_product');
    }

    
    public function list_category_product(){
        $data = Category::all();
        //                                         This part using key-value method to pass data to view
        return view('admin.list_category_product', ['category_products'=>$data]);
    }


    public function save_category_product(Request $request){
        // $data = array();
        // $data['category_name'] = $request->category_name;


        // $result=DB::table('tbl_category_product')->insert($data);
        // Session::flash('msg','Sucessfully add category!!');
        // return Redirect::to('/add-category-product');

        //===========================Another method=========================
        $request->validate([
            'category_name'=>'required'
        ]);
        $data= new Category();
        $data->category_name = $request->category_name;
        $data->save();
        return Redirect::to('/add-category-product')->with('msg','Sucessfully add category!!');

    }

    //Edit Category
    public function edit_category_product ($category_product_id){
        $data = Category::find($category_product_id);
        return view('admin.edit_category_product',['category_products'=>$data]);
    }

    //Update Category
    public function update_category_product (Request $request,$category_product_id){
        // $data = array();
        // $data['category_name'] = $request->category_name;

        // $result=DB::table('tbl_category_product')->where('category_id', $category_product_id)->update($data);
        // Session::flash('msg','Sucessfully Update category!!');
        // return Redirect::to('/list-category-product'); 

            //===========================Another method=========================
            $data=Category::find($request->category_product_id);
            $data->category_name=$request->category_name;
            $data->update();
            return Redirect::to('/list-category-product')->with('msg','Sucessfully Update category!!');
    }

    //Delete Category
    public function delete_category_product ($category_product_id){
        // $result=DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        // Session::flash('msg','Sucessfully Delete category!!');
        // return Redirect::to('/list-category-product');

            //===========================Another method=========================
            $data = Category::find($category_product_id);
            $data->delete();
            return Redirect::to('/list-category-product')->with('msg','Sucessfully Update category!!');
    }

}
