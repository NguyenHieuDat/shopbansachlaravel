@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê mã giảm giá
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
              <th>Tên mã giảm giá</th>
              <th>Mã giảm giá</th>
              <th>Số lượng</th>
              <th>Điều kiện giảm</th>
              <th>Số % hoặc tiền giảm</th>
              <th>Ngày bắt đầu</th>
              <th>Ngày kết thúc</th>
              <th>Trạng thái</th>
              <th>Hết hạn</th>
              <th>Quản lý</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($coupon as $key => $coup)
            <tr>
              <td>{{$coup->coupon_name}}</td>
              <td>{{$coup->coupon_code}}</td>
              <td>{{$coup->coupon_time}}</td>
              <td><span class="text-ellipsis">  <!-- 1 là %, 2 là số tiền -->
                <?php
                if($coup->coupon_condition==1){
                    ?>
                <a>Giảm theo %</a>
                <?php
                }else{
                    ?>
                <a>Giảm theo số tiền</a>
                <?php    
                }
                    ?>
                </span></td>

              <td><span class="text-ellipsis">
                <?php
                if($coup->coupon_condition==1){
                    ?>
                <a>{{$coup->coupon_price}} %</a>
                <?php
                }else{
                    ?>
                <a>{{number_format($coup->coupon_price,0,',','.')}} đ</a>
                <?php    
                }
                    ?>
                </span></td>
              <td>{{$coup->coupon_start}}</td>
              <td>{{$coup->coupon_end}}</td>
              <td><span class="text-ellipsis">
                <?php
                if($coup->coupon_status == 1){
                    ?>
                <a style="color: green;">Đang kích hoạt</a>
                <?php
                }else{
                    ?>
                <a style="color: red;">Không kích hoạt</a>
                <?php    
                }
                    ?>
                </span></td>
                <td>
                  @if($coup->coupon_end >= $now)
                    <a style="color: green;">Còn hạn</a>
                  @else
                    <a style="color: red;">Hết hạn</a>
                  @endif
                </td>
              <td>
                <a href="{{URL::to('/delete_coupon/'.$coup->coupon_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa mã này chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection