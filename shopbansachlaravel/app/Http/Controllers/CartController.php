<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Coupon;
use Session;
use Illuminate\Support\Facades\Redirect;


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

        $meta_desc = "Thêm các đầu sách mà bạn yêu thích vào giỏ hàng ngay nhé!";
        $meta_keywords = "gio hang,giỏ hàng,thong tin gio hang,thông tin giỏ hàng,fahasa";
        $meta_title = "Giỏ hàng của bạn";
        $url_canonical = $request->url();
        Session::forget('coupon');
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('author',$author)
        ->with('publisher',$publisher)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)
        ->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);

    }

    public function update_cart_ajax(Request $request){
        $rowid = $request->input('rowid');
        $qty = $request->input('qty');

        $cart = Session::get('cart', []);

        if(isset($cart[$rowid])){
            $cart[$rowid]['book_qty'] = $qty;
            $bookPrice = $cart[$rowid]['book_price'];
            $newSubtotal = $bookPrice * $qty;

            Session::put('cart', $cart);

            $total = 0;
            foreach($cart as $item){
                $total += $item['book_price'] * $item['book_qty'];
            }

            $total_coupon = 0;
            if(Session::has('coupon')){
                foreach(Session::get('coupon') as $coupon){
                    if($coupon['coupon_condition'] == 1){
                        $total_coupon = ($total * $coupon['coupon_price']) / 100;
                    }else{
                        $total_coupon = $coupon['coupon_price'];
                    }
                }
            }
            $total_after_discount = max(0, $total - $total_coupon);
            $total_final = number_format($total_after_discount, 0, ',', '.') . 'đ';

            return response()->json([
                'success'      => true,
                'new_subtotal' => number_format($newSubtotal, 0, ',', '.').'đ',
                'total'        => number_format($total, 0, ',', '.').'đ',
                'total_after_discount' => number_format($total_after_discount, 0, ',', '.') . 'đ',
                'total_final'  => $total_final
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function remove_cart_ajax(Request $request){
        $rowid = $request->input('rowid');
        $cart = Session::get('cart', []);
        if (isset($cart[$rowid])){

            unset($cart[$rowid]);
            Session::put('cart', $cart);

            $total = 0;
            foreach($cart as $item){
                $total += $item['book_price'] * $item['book_qty'];
            }
            $total_coupon = 0;
            if(Session::has('coupon')){
                foreach(Session::get('coupon') as $coupon){
                    if($coupon['coupon_condition'] == 1){
                        $total_coupon = ($total * $coupon['coupon_price']) / 100;
                    }else{
                        $total_coupon = $coupon['coupon_price'];
                    }
                }
            }
            $total_after_discount = max(0, $total - $total_coupon);
            $total_final = number_format($total_after_discount, 0, ',', '.') . 'đ';

            return response()->json([
                'success' => true,
                'total'   => number_format($total, 0, ',', '.') . 'đ',
                'total_after_discount' => number_format($total_after_discount, 0, ',', '.') . 'đ',
                'total_final'  => $total_final,
                'cart_empty'      => count($cart) === 0
            ]);
        }
        return response()->json(['success' => false]);
    }

    public function check_coupon(Request $request) {
        $data = $request->all();
        $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->first();
    
        $cart = Session::get('cart', []);

        if(isset($data['book_id']) && isset($data['new_qty'])) {
            foreach($cart as &$item) {
                if($item['book_id'] == $data['book_id']) {
                    $item['book_qty'] = $data['new_qty'];
                }
            }
        }
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['book_price'] * $item['book_qty'];
        }
    
        if ($coupon) {
            $total_coupon = 0;
    
            $cou = [];
    
            // if ($coupon_session) {
            //     // Kiểm tra mã giảm giá đã được áp dụng chưa
            //     $available = 0;
            //     if ($available == 0) {

            //         $cou[] = [
            //             'coupon_code' => $coupon->coupon_code,
            //             'coupon_condition' => $coupon->coupon_condition,
            //             'coupon_price' => $coupon->coupon_price,
            //             'total_coupon' => $total_coupon
            //         ];
            //         Session::put('coupon', $cou);
            //     }
            // } else {
                if ($coupon->coupon_condition == 1) {
                    $total_coupon = ($total * $coupon->coupon_price) / 100;
                } elseif ($coupon->coupon_condition == 2) {
                    $total_coupon = $coupon->coupon_price;
                }
    
                $total_after_discount = max(0, $total - $total_coupon);
    
                $cou[] = [
                    'coupon_code' => $coupon->coupon_code,
                    'coupon_condition' => $coupon->coupon_condition,
                    'coupon_price' => $coupon->coupon_price,
                    'total_coupon' => $total_coupon
                ];
                Session::put('coupon', $cou);
                Session::put('total_coupon', $total_coupon);
                Session::put('total_after_discount', $total_after_discount);
                Session::put('cart', $cart);
            // }
    
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm mã giảm giá thành công!',
                'coupon' => $cou,
                'coupon_value' => $coupon->coupon_condition == 1 
                    ? $coupon->coupon_price . '%'
                    : number_format($coupon->coupon_price, 0, ',', '.') . 'đ',
                'total_coupon' => number_format($total_coupon, 0, ',', '.'),
                'total_after_discount' => number_format(max(0, $total - $total_coupon), 0, ',', '.'),
                'total' => number_format($total, 0, ',', '.')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Mã giảm giá không đúng hoặc đã hết hạn!',
                'total' => number_format($total, 0, ',', '.')
            ]);
        }
    }
    

}
