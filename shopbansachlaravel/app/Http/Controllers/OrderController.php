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
use Session;
use Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Redirect;
session_start();

class OrderController extends Controller
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
        'coupon_condition','coupon_code','coupon_price','feeship','order_status','orders_id','order_date'));
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
    
        
}
