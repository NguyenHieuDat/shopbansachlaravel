<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Coupon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

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
        $coupon->coupon_start = $data['coupon_start'];
        $coupon->coupon_end = $data['coupon_end'];
        $coupon->save();

        Session::put('message','Thêm mã giảm giá thành công!');
        return Redirect::to('add_coupon');
    }

    public function all_coupon(){
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $coupon = Coupon::orderby('coupon_id','desc')->get();

        foreach($coupon as $cou){
            if($cou->coupon_end < $now){
                // Nếu đã hết hạn và vẫn đang hoạt động, thì cập nhật thành không hoạt động
                if($cou->coupon_status != 0){
                    $cou->coupon_status = 0;
                    $cou->save();
                }
            }
        }
        return view('admin.coupon.all_coupon')->with(compact('coupon','now'));
    }

    public function delete_coupon($coupon_id){
        $coupon = Coupon::find($coupon_id);
        $coupon->delete();
        Session::put('message','Xóa mã giảm giá thành công!');
        return Redirect::to('all_coupon');
    }
}
