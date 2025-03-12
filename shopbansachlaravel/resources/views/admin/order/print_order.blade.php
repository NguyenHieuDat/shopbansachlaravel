<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
    <title>Chi tiết đơn đặt hàng</title>
</head>
<body>
<div id="print-area">
    <div class="text-center">
        <h2>Chi tiết đơn đặt hàng</h2>
    </div>
    <h4>Thông tin vận chuyển</h4>
    <p><strong>Tên khách hàng:</strong> {{ $shipping->shipping_name }}</p>
    <p><strong>Địa chỉ email:</strong> {{ $shipping->shipping_email }}</p>
    <p><strong>Số điện thoại:</strong> {{ $shipping->shipping_phone }}</p>
    <p><strong>Địa chỉ:</strong> {{ $shipping->shipping_address }}</p>
    <p><strong>Thành phố:</strong> {{ $shipping->shipping_city }}</p>
    <p><strong>Ghi chú:</strong> {{ $shipping->shipping_note }}</p>
    <p><strong>Phương thức thanh toán:</strong> {{ $payment->payment_id == 1 ? 'Chuyển khoản' : 'Tiền mặt' }}</p>
    <p><strong>Trạng thái đơn hàng:</strong> {{ $order_status == 1 ? 'Đang chờ xử lý' : 'Đã hoàn thành' }}</p>
    <p><strong>Thời gian thực hiện đơn hàng:</strong> {{ $order_date }}</p>

    <h4>Chi tiết đơn hàng</h4>
    <table>
        <thead>
            <tr>
                <th>Tên sách</th>
                <th>Giá tiền</th>
                <th>Số lượng mua</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($order_details as $order_dt)
                @php
                    $subtotal = $order_dt->book_price * $order_dt->book_sale_quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $order_dt->book_name }}</td>
                    <td>{{ number_format($order_dt->book_price, 0, ',', '.') }} đ</td>
                    <td>{{ $order_dt->book_sale_quantity }}</td>
                    <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Tính toán tổng tiền</h4>
    <p><strong>Tổng tiền gốc:</strong> {{ number_format($total, 0, ',', '.') }} đ</p>
    <p><strong>Mã giảm giá:</strong> {{ $coupon_code }}</p>
    <p><strong>Giảm:</strong> 
        @if($coupon_condition == 1)
            {{ $coupon_price }} %
        @elseif($coupon_condition == 2)
            {{ number_format($coupon_price, 0, ',', '.') }} đ
        @else
            Không áp dụng
        @endif
    </p>
    @php
        if ($coupon_condition == 1) {
            $total_coupon = $total - (($total * $coupon_price) / 100);
        } elseif ($coupon_condition == 2) {
            $total_coupon = $total - $coupon_price;
        } else {
            $total_coupon = $total;
        }
    @endphp
    <p><strong>Tiền sau giảm giá:</strong> {{ number_format($total_coupon, 0, ',', '.') }} đ</p>
    <p><strong>Phí vận chuyển:</strong> {{ number_format($feeship ? $feeship->fee_price : 0, 0, ',', '.') }} đ</p>

    @php
        $total_final = $total_coupon + ($feeship ? $feeship->fee_price : 0);
    @endphp
    <div class="text-right">
        <h3><strong>Tổng tiền cuối cùng:</strong> {{ number_format(max(0, $total_final), 0, ',', '.') }} đ</h3>
    </div>
</div>
</body>
</html>
