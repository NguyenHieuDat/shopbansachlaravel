@extends('admin_layout')
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin vận chuyển
      </div>
        <?php
            $message = Session::get('message');
            if($message){
                echo "<span class='text-success'>{$message}</span>";
                Session::put('message',null);
            }
          ?>
    <div class="row w3-res-tb">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên khách hàng</th>
              <th>Địa chỉ email</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ thường trú</th>
              <th>Địa chỉ thành phố</th>
              <th>Ghi chú</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$shipping_info->shipping_name}}</td>
              <td>{{$shipping_info->shipping_email}}</td>
              <td>{{$shipping_info->shipping_phone}}</td>
              <td>{{$shipping_info->shipping_address}}</td>
              <td>{{$shipping_info->shipping_city}}</td>
              <td>{{$shipping_info->shipping_note}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
<br><br>
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Chi tiết đơn đặt hàng
      </div>
        <?php
            $message = Session::get('message');
            if($message){
                echo "<span class='text-success'>{$message}</span>";
                Session::put('message',null);
            }
          ?>
      <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
          <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
              <button class="btn btn-sm btn-default" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th style="width:20px;">
                <label class="i-checks m-b-none">
                  <input type="checkbox"><i></i>
                </label>
              </th>
              <th>Tên sách đã đặt</th>
              <th>Giá tiền</th>
              <th>Số lượng mỗi quyển</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order_details as $key => $order_dt)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$order_dt->book_name}}</td>
              <td>{{$order_dt->book_price}}</td>
              <td>{{$order_dt->book_sale_quantity}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
              <li><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">4</a></li>
              <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection