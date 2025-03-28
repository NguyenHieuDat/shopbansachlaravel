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
use App\Rules\Captcha;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
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

    //Ham user

    public function login_checkout(Request $request){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
        if (!Session::has('previous_url')) {
            Session::put('previous_url', url()->previous());
        }
        $meta_desc = "Trang đăng nhập hoặc đăng ký tài khoản người dùng. Bạn cần đăng nhập hoặc đăng ký tài khoản để thực hiện thanh toán";
        $meta_keywords = "dang nhap,đăng nhập,dang ky,đăng ký,tai khoan,tài khoản,tai khoan khach hang,tài khoản khách hàng,fahasa";
        $meta_title = "Đăng nhập/Đăng ký tài khoản khách hàng";
        $url_canonical = $request->url();

        return view('pages.checkout.login_checkout', compact(
            'category', 'author', 'publisher', 'meta_desc', 'meta_keywords', 
            'meta_title', 'url_canonical'
        ));
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

        $meta_desc = "Giao diện thanh toán với thông tin vận chuyển";
        $meta_keywords = "thanh toan,thanh toán,van chuyen,vận chuyển,nhập thông tin,fahasa";
        $meta_title = "Thanh toán và vận chuyển";
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

        $meta_desc = "Bước thanh toán cuối cùng. Bạn sẽ chọn phương thức thanh toán bạn thấy tốt nhất.";
        $meta_keywords = "thanh toan cuoi,thanh toán cuối,phuong thuc,phương thức,phuong thuc thanh toan,phương thức thanh toán";
        $meta_title = "Phương thức thanh toán";
        $url_canonical = $request->url();
        return view('pages.checkout.payment', compact(
            'category', 'author', 'publisher', 'meta_desc', 'meta_keywords', 
            'meta_title', 'url_canonical', 'feeship'
        ));
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
        $validator = \Validator::make($request->all(), [
            'email_account' => 'required|email',
            'password_account' => 'required',
            'g-recaptcha-response' => ['required', new Captcha()],
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = $request->input('email_account');
        $password = md5($request->input('password_account'));
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();

        if($result){
            Session::put('customer_id',$result->customer_id);
            Session::put('customer_name', $result->customer_name);

            $shipping = DB::table('tbl_shipping')->where('customer_id', $result->customer_id)->first();
            if ($shipping) {
                Session::put('shipping_id', $shipping->shipping_id);
            }

            $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
            $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
            $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();
            $all_book = DB::table('tbl_book')->where('book_status','1')->orderby('book_id','desc')->limit(8)->get();
            $previous_url = Session::get('previous_url', '/');
            Session::forget('previous_url');
            return response()->json([
                'success' => true,
                'redirect_url' => $previous_url,
                'category' => $cate_product,
                'author' => $author,
                'publisher' => $publisher,
                'all_book' => $all_book
            ]);
            } else {
            return response()->json([
                'success' => false,
                'error' => 'Sai email hoặc mật khẩu. Vui lòng thử lại!'
            ]);
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
        $total_bf = $request->input('total_bf');
        $coupon = Session::get('coupon');
        $total_coupon = Session::get('total_coupon', 0);
        $feeship = Session::get('fees', 0);

        if ($coupon) {
            $coupon_code = $coupon[0]['coupon_code'];
            $coupon_price = $total_coupon > 0 ? $total_coupon : 0;
        } else {
            $coupon_code = 'Không có';
            $coupon_price = 0;
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $shipping_fee = $feeship > 0 ? $feeship : 'Không có';

        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = Session::get('shipping_id');
        $order->payment_id = $payment->payment_id;
        $order->total_bf = $total_bf;
        $order->coupon_code = $coupon_code;
        $order->coupon_price = $coupon_price;
        $order->feeship_price = $shipping_fee;
        $order->order_total = $total_final;
        $order->order_status = 1;
        $order->created_at = now();
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
            $order_detail->created_at = now();
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
        Session::forget('coupon');
        Session::forget('fees');
        return response()->json([
            'success' => true,
            'payment_id' => $payment->payment_id
        ]);
    }

    public function check_storage(Request $request){
        $cart = Session::get('cart', []);
        $errorMessages = [];

        if (!$cart || count($cart) == 0) {
            return response()->json([
                'status' => 'error',
                'messages' => ['Giỏ hàng của bạn đang trống!']
            ]);
        }

        foreach ($cart as $key => $cartItem) {
            $book = DB::table('tbl_book')->where('book_id', $cartItem['book_id'])->first();
            
            if ($book) {
                if ($cartItem['book_qty'] > $book->book_quantity) {
                    $errorMessages[] = [
                        'book_name' => $cartItem['book_name'],
                        'book_qty' => $book->book_quantity
                    ];
                }
            }
        }

        if (!empty($errorMessages)) {
            return response()->json([
                'status' => 'error',
                'messages' => $errorMessages
            ]);
        }

        // Nếu không có lỗi
        return response()->json([
            'status' => 'success'
        ]);
    }

}
