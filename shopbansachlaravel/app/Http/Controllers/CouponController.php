<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Coupon;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CouponController extends Controller
{
    public function add_coupon(){
        return view('admin.coupon.add_coupon');
    }

    public function save_coupon(Request $request){
        $data = $request->all();
        $coupon = new Coupon;

        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_price = $data['coupon_price'];

        $coupon->save();
        Session::put('message','Thêm mã giảm giá thành công!');
        return Redirect::to('add_coupon');
    }

    public function all_coupon(){
        $coupon = Coupon::orderby('coupon_id','desc')->get();
        return view('admin.coupon.all_coupon')->with(compact('coupon'));
    }

    public function delete_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message','Xóa mã giảm giá thành công!');
        return Redirect::to('all_coupon');
    }
}
