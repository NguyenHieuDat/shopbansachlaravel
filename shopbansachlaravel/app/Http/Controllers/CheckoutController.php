<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function login_checkout(){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$category)->with('author',$author)->with('publisher',$publisher);
    }

    public function add_customer(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        $customer_id = DB::table('tbl_customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');
    }

    public function checkout(){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        return view('pages.checkout.show_checkout')->with('category',$category)->with('author',$author)->with('publisher',$publisher);
    }

    public function save_checkout_customer(Request $request){
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;


        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);
        Session::put('shipping_id',$shipping_id);
        return Redirect::to('/checkout');
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login_checkout');
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result){
            Session::put('customer_id',$result->customer_id);

            $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
            $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
            $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
            $all_book = DB::table('tbl_book')->where('book_status','1')->orderby('book_id','desc')->limit(8)->get();
            return view('pages.home')->with('category',$cate_product)->with('author',$author)->with('publisher',$publisher)->with('all_book',$all_book);
        }else{
            return Redirect::to('/login_checkout');
        }
    }
}
