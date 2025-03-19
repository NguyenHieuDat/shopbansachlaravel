<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\City;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Feeship;
use Session;
use Illuminate\Support\Facades\Redirect;


class DeliveryController extends Controller
{
    public function delivery(Request $request){
        $city = City::orderby('matp','ASC')->get();
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    
    public function select_delivery(Request $request) {
        if (!$request->has(['action', 'maid'])) {
            return response()->json(['error' => 'Thiếu dữ liệu!'], 400);
        }
    
        $action = $request->action;
        $maid = $request->maid;
    
        if ($action == "city") {
            $select_province = Province::where('matp', $maid)->orderby('maqh', 'ASC')->get();
            $output = '<option>--Chọn quận/huyện--</option>';
            foreach ($select_province as $province) {
                $output .= '<option value="'.$province->maqh.'">'.$province->tenqh.'</option>';
            }
        } else {
            $select_ward = Ward::where('maqh', $maid)->orderby('xaid', 'ASC')->get();
            $output = '<option>--Chọn phường/xã--</option>';
            foreach ($select_ward as $wards) {
                $output .= '<option value="'.$wards->xaid.'">'.$wards->tenxp.'</option>';
            }
        }
        return response()->json(['output' => $output]);
    }

    public function insert_delivery(Request $request){

        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['ward'];
        $fee_ship->fee_price = $data['feeship'];
        $fee_ship->save();
    }

    public function select_feeship(){
        $feeship = Feeship::orderby('fee_id','desc')->get();
        $output = '';
        $output .= '<div class="table-responsive">
        <table class="table table-bordered">
        <thread>
        <tr>
            <th>Tên thành phố</th>
            <th>Tên quận/huyện</th>
            <th>Tên phường/xã</th>
            <th>Phí vận chuyển <br> (nhấn vào ô nhập liệu để chỉnh sửa)</th>
        </tr>
        </thread>
        <tbody>';
        foreach($feeship as $key => $feesh){
            $output .= '
            <tr>
                <td>'.$feesh->city->tentp.'</td>
                <td>'.$feesh->province->tenqh.'</td>
                <td>'.$feesh->ward->tenxp.'</td>
                <td contenteditable data-feeship_id="'.$feesh->fee_id.'" class="feeship_edit">'.number_format($feesh->fee_price,0,',','.').' đ</td>
            </tr>';
        }
        $output .= '</tbody>
        </table>
        </div>';
        echo $output;
    }

    public function update_delivery(Request $request){
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_ship->fee_price = $data['fee_value'];
        $fee_ship->save();
    }
}
