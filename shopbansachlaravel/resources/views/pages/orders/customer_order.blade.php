@extends('welcome')
@section('content')
<div class="container pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4">
        <span class="bg-secondary pr-3">Đơn Hàng Của Bạn</span>
    </h2>
    <hr>
    @php
        $i = $orders->count();
    @endphp
    @foreach($orders as $order)
    <div class="order-info">
        <p>Đơn <strong> #{{ $i-- }}</strong>: </p>
        <div class="order-details">
            <p>Tổng tiền: <strong>{{ number_format($order->order_total) }} đ</strong></p>
            <p>Mã giảm giá: <strong>{{ $order->coupon_code }}</strong></p>
            <p>Phí vận chuyển: <strong>{{ number_format($order->feeship_price) }} đ</strong></p>
            <p>Ngày đặt: <strong>{{ $order->created_at }}</strong></p>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderdetail as $orderDetail)
                    <tr>
                        <td><img src="{{ asset('public/upload/book/'.$orderDetail->book->book_image) }}" width="50"></td>
                        <td>{{ $orderDetail->book->book_name }}</td>
                        <td>{{ number_format($orderDetail->book->book_price) }} đ</td>
                        <td>{{ $orderDetail->book_sale_quantity }}</td>
                        
                        <td>
                            @if($order->order_status == 1)
                                <span class="badge badge-warning">Đang giao hàng</span>
                            @elseif($order->order_status == 2)
                                <span class="badge badge-success">Đã giao</span>
                            @else
                                <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            
        </tbody>
    </table>
    <hr class="custom-hr">
    @endforeach
</div>
@endsection
