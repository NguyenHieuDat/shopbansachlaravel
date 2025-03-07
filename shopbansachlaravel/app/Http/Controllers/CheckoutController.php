<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\City;
use App\Models\Province;
use App\Models\Ward;
use App\Models\Feeship;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderDetail;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    //Ham admin
    public function check_login(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function all_order(){
        $this->check_login();
        $all_order = DB::table('tbl_order')->join('tbl_customer','tbl_customer.customer_id','=','tbl_order.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderby('tbl_order.order_id','desc')->get();
        $manager_order = view('admin.order.all_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.order.all_order',$manager_order);
    }

    public function view_order_detail($orders_id){
        return view('admin.order.view_order_detail');
    }

    //Ham user

    public function login_checkout(){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        if (!Session::has('previous_url')) {
            Session::put('previous_url', url()->previous());
        }
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

    public function checkout(Request $request){
        $customer_id = Session::get('customer_id'); 
        
        // Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng đến trang login
        if (!$customer_id) {
            return Redirect::to('/login_checkout');
        }
        // Lấy thông tin vận chuyển nếu có
        $shipping = DB::table('tbl_shipping')->where('customer_id', $customer_id)->first();
        
        if ($shipping) {
            Session::put('shipping_id', $shipping->shipping_id);
            Session::put('shipping_name', $shipping->shipping_name);
            Session::put('shipping_email', $shipping->shipping_email);
            Session::put('shipping_phone', $shipping->shipping_phone);
            Session::put('shipping_address', $shipping->shipping_address);
            Session::put('shipping_note', $shipping->shipping_note);
        }

        $city = City::orderBy('matp', 'ASC')->get();
        $province = Province::orderBy('maqh', 'ASC')->get();
        $ward = Ward::orderBy('xaid', 'ASC')->get();

        $category = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $author = DB::table('tbl_author')->orderBy('author_id', 'desc')->get();
        $publisher = DB::table('tbl_publisher')->orderBy('publisher_id', 'desc')->get();

        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();

        return view('pages.checkout.show_checkout', compact(
            'category', 'author', 'publisher', 'meta_desc', 'meta_keywords', 
            'meta_title', 'url_canonical', 'shipping', 'city', 'province', 'ward'
        ));
    }

    public function payment(Request $request){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        $feeship = Session::get('feeship', 0);

        $meta_desc = "Đăng nhập thanh toán";
        $meta_keywords = "Đăng nhập thanh toán";
        $meta_title = "Đăng nhập thanh toán";
        $url_canonical = $request->url();
        return view('pages.checkout.payment')->with('category',$category)
        ->with('author',$author)->with('publisher',$publisher)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('feeship',$feeship);
    }

    public function save_checkout_customer(Request $request){
        $customer_id = Session::get('customer_id');
        $shipping_id = Session::get('shipping_id');

        $current_shipping = DB::table('tbl_shipping')
        ->where('shipping_id', $shipping_id)
        ->first();
        Session::put('city', $request->city);
        Session::put('province', $request->province);
        Session::put('ward', $request->ward);

        $city = City::where('matp', $request->city)->first();
        $province = Province::where('maqh', $request->province)->first();
        $ward = Ward::where('xaid', $request->ward)->first();

        $city_name = $city->tentp ?? 'Không tìm thấy thành phố';
        $province_name = $province->tenqh ?? 'Không tìm thấy quận';
        $ward_name = $ward->tenxp ?? 'Không tìm thấy xã/phường';

        $city_address = $request->shipping_city. '' .$ward_name . ', ' . $province_name . ', ' . $city_name;

        if ($current_shipping) {
            DB::table('tbl_shipping')
                ->where('shipping_id', $shipping_id)
                ->update([
                    'shipping_name' => $request->shipping_name,
                    'shipping_email' => $request->shipping_email,
                    'shipping_phone' => $request->shipping_phone,
                    'shipping_address' => $request->shipping_address,
                    'shipping_city' => $city_address,
                    'shipping_note' => $request->shipping_note
                ]);
        } else {
            $shipping_id = DB::table('tbl_shipping')->insertGetId([
                'customer_id' => $customer_id,
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $city_address,
                'shipping_note' => $request->shipping_note
            ]);
        }

        Session::put('shipping_id', $shipping_id);
        Session::put('shipping_city', $city_address);

        // Tính phí vận chuyển
        $feeship = Feeship::where('fee_matp', $request->city)
            ->where('fee_maqh', $request->province)
            ->where('fee_xaid', $request->ward)
            ->value('fee_price') ?? 0;

        Session::put('feeship', $feeship);
        return Redirect::to('/payment');
    }

    public function logout_checkout(){
        Session::flush();
        return Redirect::to('/login_checkout');
    }

    public function save_previous_url(Request $request)
    {
        // Lưu previous_url vào session
        Session::put('previous_url', $request->previous_url);
        return response()->json(['success' => true]);
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result){
            Session::put('customer_id',$result->customer_id);
            Session::put('customer_name', $result->customer_name);

            // Check if the customer already has shipping information
            $shipping = DB::table('tbl_shipping')->where('customer_id', $result->customer_id)->first();

            // If shipping info exists, save the shipping_id to the session
            if ($shipping) {
                Session::put('shipping_id', $shipping->shipping_id);
            }

            $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
            $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
            $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
            $all_book = DB::table('tbl_book')->where('book_status','1')->orderby('book_id','desc')->limit(8)->get();
            $previous_url = Session::get('previous_url', '/');
            Session::forget('previous_url');
            return redirect($previous_url)->with('category',$cate_product)->with('author',$author)->with('publisher',$publisher)->with('all_book',$all_book);
        }else{
            return Redirect::to('/login_checkout')->with('error', 'Sai email hoặc mật khẩu. Vui lòng thử lại!');
        }
    }

    public function checkout_delivery(Request $request){
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

    public function calculate_feeship(Request $request){
        $data = $request->all();
        $feeship_price = 0;

        if(isset($data['matp']) && isset($data['maqh']) && isset($data['xaid'])){
        $feeship = Feeship::where('fee_matp', $data['matp'])
                          ->where('fee_maqh', $data['maqh'])
                          ->where('fee_xaid', $data['xaid'])
                          ->first();
        if($feeship){
            $feeship_price = $feeship->fee_price;
            Session::put('fees', $feeship_price);
            Session::save();
            }
        }
        return response()->json(['feeship' => $feeship_price]);
    }

    public function order_place(Request $request){
        $payment_option = $request->input('payment_option');
        $payment = Payment::where('payment_id', $payment_option)->first();
        $total_final = $request->input('total_final');

        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = Session::get('shipping_id');
        $order->payment_id = $payment->payment_id;
        $order->order_total = $total_final;
        $order->order_status = 'Đang chờ xử lý';
        $order->save();
        $order_id = $order->order_id; // Lấy ID của đơn hàng vừa tạo
        
        $cart = Session::get('cart', []);
        foreach($cart as $key => $cart_order){
            $order_detail = new OrderDetail();
            $order_detail['order_id'] = $order_id;
            $order_detail['book_id'] = $cart_order['book_id'];
            $order_detail['book_name'] = $cart_order['book_name'];
            $order_detail['book_price'] = $cart_order['book_price'];
            $order_detail['book_sale_quantity'] = $cart_order['book_qty'];
            $order_detail->save();
        }
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Phương thức thanh toán không hợp lệ!'
            ]);
        }
        if ($payment->payment_status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Hiện tại phương thức thanh toán này không sử dụng được, vui lòng chọn phương thức khác!'
            ]);
        }
        Session::forget('cart');
        return response()->json([
            'success' => true,
            'payment_id' => $payment->payment_id
        ]);
    }

}
