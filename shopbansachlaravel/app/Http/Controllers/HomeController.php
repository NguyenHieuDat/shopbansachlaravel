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
}
