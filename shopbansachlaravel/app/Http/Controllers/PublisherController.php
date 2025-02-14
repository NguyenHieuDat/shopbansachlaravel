<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class PublisherController extends Controller
{
    public function check_login(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function add_publisher(){
        $this->check_login();
        return view('admin.add_publisher');
    }

    public function all_publisher(){
        $this->check_login();
        $all_publisher = DB::table('tbl_publisher')->get();
        $manager_publisher = view('admin.all_publisher')->with('all_publisher',$all_publisher);
        return view('admin_layout')->with('admin.all_publisher',$manager_publisher);
    }

    public function save_publisher(Request $request){
        $this->check_login();
        $data = array();
        $data['publisher_name'] = $request->publisher_name;
        $data['publisher_description'] = $request->publisher_description;

        DB::table('tbl_publisher')->insert($data);
        Session::put('message','Thêm nhà xuất bản thành công!');
        return Redirect::to('add_publisher');
    }

    public function edit_publisher($publish_id){
        $this->check_login();
        $edit_publisher = DB::table('tbl_publisher')->where('publisher_id',$publish_id)->get();
        $manager_publisher = view('admin.edit_publisher')->with('edit_publisher',$edit_publisher);
        return view('admin_layout')->with('admin.edit_publisher',$manager_publisher);
    }

    public function update_publisher(Request $request,$publish_id){
        $this->check_login();
        $data = array();
        $data['publisher_name'] = $request->publisher_name;
        $data['publisher_description'] = $request->publisher_description;

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
}
