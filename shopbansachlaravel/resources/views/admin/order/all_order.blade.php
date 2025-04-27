@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Danh sách đơn đặt hàng
      </div>
        <?php
            $message = Session::get('message');
            if($message){
                echo "<span class='text-success'>{$message}</span>";
                Session::put('message',null);
            }
          ?>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="dbTable">
          <thead>
            <tr>
              <th>Thứ tự đơn hàng</th>
              <th>Tổng tiền trước</th>
              <th>Mã giảm giá</th>
              <th>Tiền giảm</th>
              <th>Phí vận chuyển</th>
              <th>Tổng tiền</th>
              <th>Tình trạng giao hàng</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @php
                $i = 0;
            @endphp
            @foreach ($all_order as $key => $order)
            <tr>
              {{-- <td>{{$order->customer_name}}</td> --}}
              <td>
                @php
                    $i++;
                @endphp
                {{$i}}
              </td>
              <td>{{number_format($order->total_bf, 0, ',', '.')}} đ</td>
              <td>{{$order->coupon_code}}</td>
              <td>{{number_format($order->coupon_price, 0, ',', '.')}} đ</td>
              <td>{{number_format($order->feeship_price, 0, ',', '.')}} đ</td>
              <td>{{number_format($order->order_total, 0, ',', '.')}} đ</td>
              <td>
                @if($order->order_status == 1)
                  Đang chờ xử lý
                @elseif($order->order_status == 2)
                  Đã hoàn thành
                @elseif($order->order_status == 3)
                  Đã hủy
                @endif
              </td>
              <td>
                <a href="{{URL::to('/view_order_detail/'.$order->order_id)}}" class="active style-edit" ui-toggle-class=""><i class="fa fa-eye text-success text-active"></i></a>
                <a href="{{URL::to('/delete_order/'.$order->order_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa đơn hàng này chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection