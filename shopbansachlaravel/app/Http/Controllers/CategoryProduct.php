<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CategoryProduct extends Controller
{
    //Ham Admin 

    public function check_login(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_category_product(){
        $this->check_login();
        return view('admin.category_product.add_category_product');
    }

    public function all_category_product(){
        $this->check_login();
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.category_product.all_category_product')->with('all_category_product',$all_category_product);
        return view('admin_layout')->with('admin.category_product.all_category_product',$manager_category_product);
    }

    public function save_category_product(Request $request){
        $this->check_login();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_description'] = $request->category_product_description;
        $data['category_keywords'] = $request->category_product_keywords;

        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục sách thành công!');
        return Redirect::to('add_category_product');
    }

    public function edit_category_product($category_product_id){
        $this->check_login();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product = view('admin.category_product.edit_category_product')->with('edit_category_product',$edit_category_product);
        return view('admin_layout')->with('admin.category_product.edit_category_product',$manager_category_product);
    }

    public function update_category_product(Request $request,$category_product_id){
        $this->check_login();

        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_description'] = $request->category_product_description;
        $data['category_keywords'] = $request->category_product_keywords;

        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Sửa danh mục sách thành công!');
        return Redirect::to('all_category_product');
    }

    public function delete_category_product($category_product_id){
        $this->check_login();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sách thành công!');
        return Redirect::to('all_category_product');
    }

    //Ham User

    public function category_home(Request $request,$category_id){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $category_by_id = DB::table('tbl_book')->where('book_status','1')->join('tbl_category_product','tbl_book.category_id','=','tbl_category_product.category_id')
        ->where('tbl_book.category_id',$category_id)->get();

        $category_name_show = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->limit(1)->get();
        
        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "";
        $url_canonical = $request->url();
        if (!$category_by_id->isEmpty()) {
            foreach($category_by_id as $key => $seo_value){
                $meta_desc = $seo_value->category_description ?? '';
                $meta_keywords = $seo_value->category_keywords ?? '';
                $meta_title = $seo_value->category_name ?? '';
                break;
            }
        }
        return view('pages.category.show_category')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('category_by_id',$category_by_id)->with('category_name_show',$category_name_show)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
