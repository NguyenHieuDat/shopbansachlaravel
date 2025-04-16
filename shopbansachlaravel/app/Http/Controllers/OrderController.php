<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Feeship;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Customer;
use App\Models\Shipping;
use App\Models\Coupon;
use App\Models\Book;
use Session;
use DB;
use Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //Hàm admin

    public function check_login(){
        $admin_id = Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }
        else{
            return Redirect::to('admin')->send();
        }
    }

    public function all_order(){
        $this->check_login();
        $all_order = Order::orderby('created_at','desc')->get();
        return view('admin.order.all_order')->with(compact('all_order'));
    }

    public function view_order_detail($orders_id){
        $this->check_login();
        $order = Order::where('order_id',$orders_id)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $payment_id = $ord->payment_id;
            $book_coupon = $ord->coupon_code;
            $order_feeship = $ord->feeship_price;
            $order_status = $ord->order_status;
            $order_date = $ord->created_at;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $payment = Payment::where('payment_id',$payment_id)->first();
        $order_details = OrderDetail::with('book')->where('order_id',$orders_id)->get();
        $coupon = Coupon::where('coupon_code',$book_coupon)->first();
        
        if ($coupon) {
            $coupon_condition = $coupon->coupon_condition;
            $coupon_code = $coupon->coupon_code;
            $coupon_price = $coupon->coupon_price;
        } else {
            $coupon_condition = null;
            $coupon_code = 'Không có';
            $coupon_price = 0;
        }
        $feeship = Feeship::where('fee_price',$order_feeship)->first();

        return view('admin.order.view_order_detail', compact('order_details','customer','shipping','payment',
        'coupon_condition','coupon_code','coupon_price','feeship','order_status','orders_id','order_date','order'));
    }

    // public function print_order($orders_id){
    //     $order = Order::where('order_id', $orders_id)->get();
    //     foreach ($order as $key => $ord) {
    //         $customer_id = $ord->customer_id;
    //         $shipping_id = $ord->shipping_id;
    //         $payment_id = $ord->payment_id;
    //         $book_coupon = $ord->coupon_code;
    //         $order_feeship = $ord->feeship_price;
    //         $order_status = $ord->order_status;
    //     }
    //     $customer = Customer::where('customer_id', $customer_id)->first();
    //     $shipping = Shipping::where('shipping_id', $shipping_id)->first();
    //     $payment = Payment::where('payment_id', $payment_id)->first();
    //     $order_details = OrderDetail::with('book')->where('order_id', $orders_id)->get();
    //     $coupon = Coupon::where('coupon_code', $book_coupon)->first();
    
    //     if ($coupon) {
    //         $coupon_condition = $coupon->coupon_condition;
    //         $coupon_code = $coupon->coupon_code;
    //         $coupon_price = $coupon->coupon_price;
    //     } else {
    //         $coupon_condition = null;
    //         $coupon_code = 'Không có';
    //         $coupon_price = 0;
    //     }
    //     $feeship = Feeship::where('fee_price', $order_feeship)->first();
    
    //     $view = view('admin.order.view_order_detail', compact(
    //         'order_details', 'customer', 'shipping', 'payment',
    //         'coupon_condition', 'coupon_code', 'coupon_price',
    //         'feeship', 'order_status', 'orders_id'
    //     ))->render();
    
    //     // Tạo đối tượng DOMDocument và nạp HTML
    //     $dom = new \DOMDocument();
    //     @$dom->loadHTML(mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8'));
    
    //     // Tìm phần tử có id là "print-area"
    //     $printArea = $dom->getElementById('print-area');
    
    //     // Lấy HTML bên trong print-area
    //     $htmlContent = $dom->saveHTML($printArea);
    
    //     // Xuất ra PDF
    //     $pdf = Pdf::loadHTML($htmlContent);
    //     $pdf->setPaper('A4', 'portrait');
        
    //     return $pdf->download('chi_tiet_don_hang_'.$orders_id.'.pdf');
    // }
    
    public function print_order($orders_id){
        $order = Order::where('order_id', $orders_id)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $payment_id = $ord->payment_id;
            $book_coupon = $ord->coupon_code;
            $order_feeship = $ord->feeship_price;
            $order_status = $ord->order_status;
            $order_date = $ord->created_at;
        }
        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $payment = Payment::where('payment_id', $payment_id)->first();
        $order_details = OrderDetail::with('book')->where('order_id', $orders_id)->get();
        $coupon = Coupon::where('coupon_code', $book_coupon)->first();
        $feeship = Feeship::where('fee_price', $order_feeship)->first();
    
        $coupon_condition = $coupon ? $coupon->coupon_condition : null;
        $coupon_code = $coupon ? $coupon->coupon_code : 'Không có';
        $coupon_price = $coupon ? $coupon->coupon_price : 0;
    
        $htmlContent = view('admin.order.print_order', compact(
            'order_details', 'customer', 'shipping', 'payment',
            'coupon_condition', 'coupon_code', 'coupon_price',
            'feeship', 'order_status', 'orders_id', 'order_date'
        ))->render();
    
        $pdf = Pdf::loadHTML($htmlContent);
        $pdf->setPaper('A4', 'portrait');
    
        return $pdf->download('chi_tiet_don_hang_' . $orders_id . '.pdf');
    }
    
    public function update_order_quantity(Request $request){
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order_status_before = $order->order_status;
        $order->order_status = $data['order_status'];
        $order->save();

        foreach($data['order_book_id'] as $key => $book_id){
            $book = Book::find($book_id);
            $qty = $data['quantity'][$key];
            
            if ($order_status_before == 1 && $order->order_status == 2) {
                // Từ Đang xử lý (1) -> Đã xử lý (2): Trừ số lượng mua khỏi kho
                $book->book_quantity -= $qty;
                $book->book_sold += $qty;
            } 
            elseif ($order_status_before == 2 && ($order->order_status == 1 || $order->order_status == 3)) {
                // Từ Đã xử lý (2) -> Hủy đơn (3) hoặc Đang xử lý (1): Cộng lại số lượng vào kho
                $book->book_quantity += $qty;
                $book->book_sold -= $qty;
            }
            elseif ($order_status_before == 3 && $order->order_status == 2) {
                // Từ Hủy đơn (3) -> Đã xử lý (2)
                $book->book_quantity -= $qty;
                $book->book_sold += $qty;
            }
            $book->save();
        }
    }

    public function update_qty(Request $request){
        $data = $request->all();
        $order_details = OrderDetail::where('book_id',$data['order_book_id'])
        ->where('order_id',$data['order_sale_id'])->first();
        $order_details->book_sale_quantity = $data['order_qty'];
        $order_details->save();
    }

    //Hàm user

    public function customer_order(Request $request,$customer_id){
        $category = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $author = DB::table('tbl_author')->orderby('author_id','desc')->get();
        $publisher = DB::table('tbl_publisher')->orderby('publisher_id','desc')->get();

        $orders = Order::with('orderdetail.book')->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->get();

        $meta_desc = "Đơn hàng của bạn";
        $meta_keywords = "don hang,đơn hàng";
        $meta_title = "Đơn hàng của bạn";
        $url_canonical = $request->url();
            
        return view('pages.orders.customer_order', compact('orders','meta_desc','meta_title','meta_keywords','url_canonical',
        'category','author','publisher'));
    }

    public function cancel_order($order_id){
        $order = Order::find($order_id);
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Đơn hàng không tồn tại']);
        }
        if ($order->order_status != 2 && $order->order_status != 3) {
            $order->order_status = 3;
            $order->save();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }
}
