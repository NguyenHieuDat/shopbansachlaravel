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
      <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
          <select class="input-sm form-control w-sm inline v-middle">
            <option value="0">Bulk action</option>
            <option value="1">Delete selected</option>
            <option value="2">Bulk edit</option>
            <option value="3">Export</option>
          </select>
          <button class="btn btn-sm btn-default">Apply</button>                
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
              <th>Tên mã giảm giá</th>
              <th>Mã giảm giá</th>
              <th>Số lượng</th>
              <th>Điều kiện giảm</th>
              <th>Số % hoặc tiền giảm</th>
              <th>Quản lý</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($coupon as $key => $coup)
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
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
              <td>
                <a href="{{URL::to('/delete_coupon/'.$coup->coupon_id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa mã này chứ?')" class="active style-delete" ui-toggle-class=""><i class="fa fa-trash-o text-danger text"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          
          <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
          </div>
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