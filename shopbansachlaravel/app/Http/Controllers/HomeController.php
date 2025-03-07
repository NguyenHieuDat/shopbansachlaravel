<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $all_book = DB::table('tbl_book')->where('book_status','1')->orderby('book_id','desc')->limit(8)->get();
        return view('pages.home')->with('category',$cate_product)->with('author',$author)->with('publisher',$publisher)->with('all_book',$all_book);
    }

    public function tim_kiem(Request $request){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $keywords = $request->keywords_submit;
        $search_book = DB::table('tbl_book')->where('book_status','1')->where('book_name','like','%'.$keywords.'%')->get();
        return view('pages.book.search_book')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('search_book',$search_book);
    }

    public function view_account(){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        if (!Session::has('previous_url')) {
            Session::put('previous_url', url()->previous());
        }
        $customer_id = Session::get('customer_id');
        $customer = DB::table('tbl_customer')->where('customer_id', $customer_id)->first();
        $shipping = DB::table('tbl_shipping')->where('customer_id', $customer_id)->first();
        return view('pages.account.show_account')->with('category',$category)->with('author',$author)
        ->with('publisher',$publisher)->with('customer',$customer)->with('shipping',$shipping);
    }

    public function update_user_account(Request $request){
        $customer_id = Session::get('customer_id');
        DB::table('tbl_customer')
        ->where('customer_id', $customer_id)
        ->update([
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
        ]);

        return redirect()->back()->with('message', 'Thông tin tài khoản đã được cập nhật!');
    }

    public function update_user_shipping(Request $request){
        $customer_id = Session::get('customer_id');
        $shipping_name = $request->input('shipping_name');
        $shipping_email = $request->input('shipping_email');
        $shipping_phone = $request->input('shipping_phone');
        $shipping_address = $request->input('shipping_address');

        DB::table('tbl_shipping')
            ->where('customer_id', $customer_id)
            ->update([
                'shipping_name' => $shipping_name,
                'shipping_email' => $shipping_email,
                'shipping_phone' => $shipping_phone,
                'shipping_address' => $shipping_address
            ]);
        return redirect()->back()->with('message', 'Cập nhật thông tin vận chuyển thành công!');
    }
}
