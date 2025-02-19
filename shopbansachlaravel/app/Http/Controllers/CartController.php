<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();

class CartController extends Controller
{
    public function add_cart_ajax(Request $request){
    $data = $request->all();
    $session_id = substr(md5(microtime()), rand(0,26), 5);
    
    // Lấy giỏ hàng từ session, nếu chưa có thì khởi tạo mảng rỗng
    $cart = Session::get('cart', []);
    
    $found = false;
    
    // Duyệt qua các mục có trong giỏ hàng
    foreach ($cart as $key => $item) {
        // Nếu tìm thấy sách có book_id trùng
        if ($item['book_id'] == $data['cart_book_id']) {
            // Cộng thêm số lượng mới vào số lượng cũ
            $cart[$key]['book_qty'] += $data['cart_book_qty'];
            $found = true;
            break;
        }
    }
    // Nếu không tìm thấy, thêm sách mới vào giỏ hàng
    if (!$found) {
        $cart[] = [
            'session_id' => $session_id,
            'book_name'  => $data['cart_book_name'],
            'book_id'    => $data['cart_book_id'],
            'book_image' => $data['cart_book_image'],
            'book_qty'   => $data['cart_book_qty'],
            'book_price' => $data['cart_book_price'],
        ];
    }
    // Lưu giỏ hàng vào session
    Session::put('cart', $cart);
    Session::save();
}

    public function show_cart_ajax(Request $request){
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $meta_desc = "Giỏ hàng của bạn";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
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
            return response()->json([
                'success'      => true,
                'new_subtotal' => number_format($newSubtotal, 0, ',', '.').'đ',
                'total'        => number_format($total, 0, ',', '.').'đ'
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


}
