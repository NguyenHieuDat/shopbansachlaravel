<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Rating;

class CategoryProduct extends Controller
{
    //Ham Admin 

    public function check_login(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_category_product(){
        $this->check_login();
        $category_product = Category::where('category_parent',0)->orderBy('category_id','DESC')->get();
        return view('admin.category_product.add_category_product', compact('category_product'));
    }

    public function all_category_product(){
        $this->check_login();
        $all_category_product = DB::table('tbl_category_product')->orderBy('category_parent','DESC')->paginate(10);
        $category_product = Category::where('category_parent',0)->orderBy('category_id','DESC')->get();
        return view('admin.category_product.all_category_product', compact('all_category_product','category_product'));
    }

    public function save_category_product(Request $request){
        $this->check_login();
        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_parent'] = $request->category_parent;
        $data['category_description'] = $request->category_product_description;
        $data['category_keywords'] = $request->category_product_keywords;
        $image = $request->file('category_image');
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();
            $image->move('public/upload/category',$imageName);
            $data['category_image'] = $imageName;
        }
        DB::table('tbl_category_product')->insert($data);
        Session::put('message','Thêm danh mục sách thành công!');
        return Redirect::to('add_category_product');
    }

    public function edit_category_product($category_product_id){
        $this->check_login();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $category_product_id)->first();
        $all_category_product = DB::table('tbl_category_product')->get();

        return view('admin.category_product.edit_category_product', compact('edit_category_product', 'all_category_product'));
    }

    public function update_category_product(Request $request,$category_product_id){
        $this->check_login();

        $data = array();
        $data['category_name'] = $request->category_product_name;
        $data['category_parent'] = $request->category_parent ? $request->category_parent : 0;
        $data['category_description'] = $request->category_product_description;
        $data['category_keywords'] = $request->category_product_keywords;

        $category = DB::table('tbl_category_product')->where('category_id', $category_product_id)->first();
        $old_image = $category->category_image;
        $image = $request->file('category_image');
        if ($request->hasFile('category_image')) {
            $image = $request->file('category_image');
            $getimageName = $image->getClientOriginalName();
            $nameimage = current(explode('.',$getimageName));
            $imageName = time() . '_' . $nameimage . '.' . $image->getClientOriginalExtension();
            $old_image_path = 'public/upload/category/' . $old_image;
            if (file_exists($old_image_path) && !empty($old_image)){
                unlink($old_image_path);
            }
            $image->move('public/upload/category',$imageName);
            $data['category_image'] = $imageName;
        }

        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Sửa danh mục sách thành công!');
        return Redirect::to('all_category_product');
    }

    public function delete_category_product($category_product_id){
        $this->check_login();
        $category = DB::table('tbl_category_product')->where('category_id',$category_product_id)->first();
        if ($category) {
            $image_path = 'public/upload/category/' .($category->category_image);

            if (file_exists($image_path)) {
            unlink($image_path);
            }
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
        Session::put('message','Xóa danh mục sách thành công!');
        return Redirect::to('all_category_product');
        }
    }

    //Ham User

    public function category_home(Request $request,$category_id){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $category_by_id = DB::table('tbl_book')->where('book_status','1')->join('tbl_category_product','tbl_book.category_id','=','tbl_category_product.category_id')
        ->where('tbl_book.category_id',$category_id);
        $sort_by = $request->get('sort_by');
        $page = $request->input('page', 1);
        if ($sort_by == 'tang') {
            $category_by_id->orderBy('book_price', 'asc');
        } elseif ($sort_by == 'giam') {
            $category_by_id->orderBy('book_price', 'desc');
        } elseif ($sort_by == 'a_z') {
            $category_by_id->orderBy('book_name', 'asc');
        } elseif ($sort_by == 'z_a') {
            $category_by_id->orderBy('book_name', 'desc');
        }
        $category_by_id = $category_by_id->paginate(15)->appends(request()->query());

        $category_name_show = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_id)->get();
        
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
        foreach ($category_by_id as $book) {
            $rating = Rating::where('book_id', $book->book_id)->avg('rating');
            $book->avgRating = $rating !== null ? round($rating, 1) : 0;
            $book->totalreview = Rating::where('book_id', $book->book_id)->count();
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view('pages.category.category_paginate', compact('category_name_show', 'cate_product', 'author', 'publisher', 'category_by_id'))->render(),
                'pagination' => (string) $category_by_id->links('vendor.pagination.custom')
            ]);
        }
        return view('pages.category.show_category')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('category_by_id',$category_by_id)->with('category_name_show',$category_name_show)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
