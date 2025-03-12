@extends('admin_layout')
@section('admin_content')
<style>
  body {
      font-family: 'DejaVu Sans', sans-serif;
  }
</style>
<div id="print-area">
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Chi tiết đơn đặt hàng
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="width: 50%; vertical-align: top;">
                                <h4>Thông tin vận chuyển</h4><br>
                                <p><strong>Tên khách hàng:</strong> {{$shipping->shipping_name}}</p>
                                <p><strong>Địa chỉ email:</strong> {{$shipping->shipping_email}}</p>
                                <p><strong>Số điện thoại:</strong> {{$shipping->shipping_phone}}</p>
                                <p><strong>Địa chỉ thường trú:</strong> {{$shipping->shipping_address}}</p>
                                <p><strong>Thành phố:</strong> {{$shipping->shipping_city}}</p>
                                <p><strong>Ghi chú:</strong> {{$shipping->shipping_note}}</p>
                                <br>
                                <h4>Phương thức thanh toán:
                                
                                    @if ($payment->payment_id == 1)
                                        Chuyển khoản
                                    @else
                                        Tiền mặt
                                    @endif
                                  </h4>
                                <br>
                                <h4>Trạng thái đơn hàng:
                                  @if($order_status == 1)
                                      Đang chờ xử lý
                                  @elseif($order_status == 2)
                                      Đã hoàn thành
                                  @endif
                                </h4>
                                <br>
                                <h4>Thời gian thực hiện đơn hàng: {{$order_date}}</h4>
                            </td>

                            <td style="width: 50%; vertical-align: top;">
                                <h4>Chi tiết đơn hàng</h4><br>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tên sách</th>
                                            <th>Giá tiền</th>
                                            <th>Số lượng mua</th>
                                            <th>Số lượng kho</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($order_details as $key => $order_dt)
                                            @php
                                                $subtotal = $order_dt->book_price * $order_dt->book_sale_quantity;
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{$order_dt->book_name}}</td>
                                                <td>{{number_format($order_dt->book_price, 0, ',', '.')}} đ</td>
                                                <td>{{$order_dt->book_sale_quantity}}</td>
                                                <td></td>
                                                <td>{{number_format($subtotal, 0, ',', '.')}}đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="text-left">
                                  <p><strong>Tổng tiền gốc: </strong>{{number_format($total, 0, ',', '.')}} đ</p>
                                  <p><strong>Mã giảm giá: </strong>{{$coupon_code}}</p>
                                  <p><strong>Giảm: </strong>
                                    @if($coupon_condition == 1)
                                      {{$coupon_price}} %
                                    @elseif($coupon_condition == 2)
                                      {{ number_format($coupon_price, 0, ',', '.') }} đ
                                    @else
                                      Không áp dụng
                                    @endif
                                  </p>
                                  <p><strong>Tiền sau giảm giá: </strong>
                                  @php
                                    if($coupon_condition == 1) {
                                        $total_coupon = $total - (($total * $coupon_price) / 100);
                                    } elseif($coupon_condition == 2) {
                                        $total_coupon = $total - $coupon_price;
                                    } else {
                                        $total_coupon = $total; // Không có mã giảm giá, tổng tiền giữ nguyên
                                    }
                                  @endphp
                                  {{ number_format($total_coupon, 0, ',', '.') }} đ
                                  </p>
                                  <p><strong>Phí vận chuyển: </strong>
                                    @php
                                        $shipping_fee = $feeship ? (int) $feeship->fee_price : 0;
                                    @endphp
                                    {{ number_format($shipping_fee, 0, ',', '.') }} đ
                                  </p>
                                </div>
                                <div class="text-right">
                                  <h3>Tổng tiền: 
                                    @php
                                        $total_final = $total_coupon + $shipping_fee;
                                    @endphp
                                      {{ number_format(max(0, $total_final, 0, ',', '.')) }} đ
                                  </h3>
                                </div>  
                            </td>
                        </tr>
                        @if (!isset($is_print))
                        <tr>
                          <td colspan="2" class="text-left">
                            <a href="{{url('/print_order/'.$orders_id)}}" class="btn btn-primary mt-3">In đơn hàng</a>
                          </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
