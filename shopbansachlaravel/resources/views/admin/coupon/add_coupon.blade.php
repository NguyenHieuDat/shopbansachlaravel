@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mã giảm giá
            </header>
            <div class="panel-body">
                <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-success'>{$message}</span>";
                    Session::put('message',null);
                }
                ?>
                <div class="position-center">
                    <form role="form" action="{{URL::to('/save_coupon')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Tên mã giảm giá</label>
                            <input type="text" name="coupon_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mã giảm giá</label>
                            <input type="text" name="coupon_code" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="text" name="coupon_time" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tính năng</label>
                            <select name="coupon_condition" class="form-control input-sm m-bot15">
                                <option value="0">--Chọn--</option>
                                <option value="1">Giảm theo %</option>
                                <option value="2">Giảm theo số tiền</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Số % hoặc tiền giảm</label>
                            <input type="text" name="coupon_price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Ngày bắt đầu</label>
                            <input type="text" name="coupon_start" id="coupon_date_start" class="form-control">
                        </div><div class="form-group">
                            <label>Ngày kết thúc</label>
                            <input type="text" name="coupon_end" id="coupon_date_end" class="form-control">
                        </div>
                        <button type="submit" name="add_coupon" class="btn btn-info">Thêm mã giảm giá</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection