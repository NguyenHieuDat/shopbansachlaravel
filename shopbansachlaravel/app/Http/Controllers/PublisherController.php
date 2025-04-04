<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;

class PublisherController extends Controller
{
    //Ham admin

    public function check_login(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_publisher(){
        $this->check_login();
        return view('admin.publisher.add_publisher');
    }

    public function all_publisher(){
        $this->check_login();
        $all_publisher = DB::table('tbl_publisher')->get();
        $manager_publisher = view('admin.publisher.all_publisher')->with('all_publisher',$all_publisher);
        return view('admin_layout')->with('admin.publisher.all_publisher',$manager_publisher);
    }

    public function save_publisher(Request $request){
        $this->check_login();

        $data = array();
        $data['publisher_name'] = $request->publisher_name;
        $data['publisher_description'] = $request->publisher_description;
        $data['publisher_keywords'] = $request->publisher_keywords;

        DB::table('tbl_publisher')->insert($data);
        Session::put('message','Thêm nhà xuất bản thành công!');
        return Redirect::to('add_publisher');
    }

    public function edit_publisher($publish_id){
        $this->check_login();
        $edit_publisher = DB::table('tbl_publisher')->where('publisher_id',$publish_id)->get();
        $manager_publisher = view('admin.publisher.edit_publisher')->with('edit_publisher',$edit_publisher);
        return view('admin_layout')->with('admin.publisher.edit_publisher',$manager_publisher);
    }

    public function update_publisher(Request $request,$publish_id){
        $this->check_login();

        $data = array();
        $data['publisher_name'] = $request->publisher_name;
        $data['publisher_description'] = $request->publisher_description;
        $data['publisher_keywords'] = $request->publisher_keywords;

        DB::table('tbl_publisher')->where('publisher_id',$publish_id)->update($data);
        Session::put('message','Sửa nhà xuất bản thành công!');
        return Redirect::to('all_publisher');
    }

    public function delete_publisher($publish_id){
        $this->check_login();
        DB::table('tbl_publisher')->where('publisher_id',$publish_id)->delete();
        Session::put('message','Xóa nhà xuất bản thành công!');
        return Redirect::to('all_publisher');
    }

    //Ham user

    public function publisher_home(Request $request,$publisher_id){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $publisher_by_id = DB::table('tbl_book')->where('book_status','1')->join('tbl_publisher','tbl_book.publisher_id','=','tbl_publisher.publisher_id')
        ->where('tbl_book.publisher_id',$publisher_id)->get();

        $publisher_name_show = DB::table('tbl_publisher')->where('tbl_publisher.publisher_id',$publisher_id)->paginate(10);

        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "";
        $url_canonical = $request->url();
        if (!$publisher_by_id->isEmpty()) {
            foreach($publisher_by_id as $key => $seo_value){
                $meta_desc = $seo_value->publisher_description ?? '';
                $meta_keywords = $seo_value->publisher_keywords ?? '';
                $meta_title = $seo_value->publisher_name ?? '';
                break;
            }
        }
        foreach ($publisher_by_id as $book) {
            $rating = Rating::where('book_id', $book->book_id)->avg('rating');
            $book->avgRating = $rating !== null ? round($rating, 1) : 0;
            $book->totalreview = Rating::where('book_id', $book->book_id)->count();
        }

        if ($request->ajax()) {
            return response()->json([
                'view' => view('pages.publisher.publisher_paginate', compact('publisher_name_show', 'cate_product', 'author', 'publisher', 'publisher_by_id'))->render(),
                'pagination' => (string) $publisher_name_show->links('vendor.pagination.custom')
            ]);
        }
        return view('pages.publisher.show_publisher')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('publisher_by_id',$publisher_by_id)->with('publisher_name_show',$publisher_name_show)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
