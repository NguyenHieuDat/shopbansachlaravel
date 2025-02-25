<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Coupon;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function add_cart_ajax(Request $request) {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
    
        // Lấy giỏ hàng hiện tại từ session
        $cart = session()->get('cart', []);
    
        // Nếu sách đã có trong giỏ hàng, cập nhật số lượng
        if (isset($cart[$data['cart_book_id']])) {
            $cart[$data['cart_book_id']]['book_qty'] += $data['cart_book_qty'];
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng
            $cart[$data['cart_book_id']] = [
                'session_id' => $session_id,
                'book_name'  => $data['cart_book_name'],
                'book_id'    => $data['cart_book_id'],
                'book_image' => $data['cart_book_image'],
                'book_qty'   => $data['cart_book_qty'],
                'book_price' => $data['cart_book_price'],
            ];
        }
        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);
        session()->save();
    
        return response()->json([
            'success' => 'Thêm vào giỏ hàng thành công!',
            'cart' => $cart
        ]);
    }

    public function show_cart_ajax(Request $request){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $meta_desc = "Giỏ hàng của bạn";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        Session::forget('coupon');
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);

    }

    public function update_cart_ajax(Request $request){
        $rowid = $request->input('rowid');
        $qty = $request->input('qty');
        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);

        // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng
        if(isset($cart[$rowid])){
            $cart[$rowid]['book_qty'] = $qty;
            // Tính lại subtotal cho sản phẩm
            $bookPrice = $cart[$rowid]['book_price'];
            $newSubtotal = $bookPrice * $qty;
            // Lưu lại giỏ hàng
            Session::put('cart', $cart);
            // Nếu bạn cần tính tổng giỏ hàng
            $total = 0;
            foreach($cart as $item){
                $total += $item['book_price'] * $item['book_qty'];
            }

             // Tính tổng tiền sau giảm giá nếu có mã giảm giá
             $total_coupon = 0;
             if (Session::has('coupon')) {
                 foreach (Session::get('coupon') as $coupon) {
                     if ($coupon['coupon_condition'] == 1) { // Giảm theo %
                         $total_coupon = ($total * $coupon['coupon_price']) / 100;
                     } else { // Giảm theo số tiền
                         $total_coupon = $coupon['coupon_price'];
                     }
                 }
             }
        // Tổng tiền sau giảm giá
        $totalFinal = $total - $total_coupon;
            return response()->json([
                'success'      => true,
                'new_subtotal' => number_format($newSubtotal, 0, ',', '.').'đ',
                'total'        => number_format($total, 0, ',', '.').'đ',
                'total_final'  => number_format($totalFinal, 0, ',', '.') . 'đ'
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function remove_cart_ajax(Request $request){
        $rowid = $request->input('rowid');
        $cart = Session::get('cart', []);
        if (isset($cart[$rowid])) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($cart[$rowid]);
            // Cập nhật lại session giỏ hàng
            Session::put('cart', $cart);

            // Tính lại tổng giỏ hàng
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['book_price'] * $item['book_qty'];
            }
            return response()->json([
                'success' => true,
                'total'   => number_format($total, 0, ',', '.') . 'đ'
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
                $coupon_session = Session::get('coupon');
                
                $cart = Session::get('cart', []); // Lấy giỏ hàng từ session
                $total = 0;
                foreach($cart as $item){
                    $total += $item['book_price'] * $item['book_qty'];
                }
                $total_coupon = 0;
                $cou = [];
                if($coupon_session==true){
                    $available = 0;
                    if($available==0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_price' => $coupon->coupon_price,
                            'total_coupon' => $total_coupon
                        );
                        Session::put('coupon',$cou);
                    }
                }else{
                    $total_coupon = 0;
                if ($coupon->coupon_condition == 1) {
                    $total_coupon = ($total * $coupon->coupon_price) / 100;
                } elseif ($coupon->coupon_condition == 2) {
                    $total_coupon = $coupon->coupon_price;
                }
                Session::put('total_coupon', $total_coupon); // Lưu tổng giảm giá vào Session
                Session::save(); // Đảm bảo Session được lưu
                $total_after_discount = max(0, $total - $total_coupon);
                    $cou[] = array(
                        'coupon_code' => $coupon->coupon_code,
                        'coupon_condition' => $coupon->coupon_condition,
                        'coupon_price' => $coupon->coupon_price,
                        'total_coupon' => $total_coupon
                    );
                    Session::put('coupon',$cou);
                }
                return response()->json([
                    'status' => 'success',
                    'message' => 'Thêm mã giảm giá thành công!',
                    'coupon' => $cou,
                    'coupon_value' => $coupon->coupon_condition == 1 
                    ? $coupon->coupon_price . '%' // Nếu là giảm theo %, hiển thị %
                    : number_format($coupon->coupon_price, 0, ',', '.') . 'đ', // Nếu là số tiền, hiển thị đ
                    'total_coupon' => number_format($total_coupon, 0, ',', '.'),
                    'total_after_discount' => number_format($total_after_discount, 0, ',', '.'),
                    'total' => number_format($total, 0, ',', '.')
                ]);
            }
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Mã giảm giá không đúng!'
            ]);
        }

    }

}
