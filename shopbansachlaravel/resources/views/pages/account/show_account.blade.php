@extends('welcome')
@section('content')
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-12">
            <?php
                $message = Session::get('message');
                if($message){
                    echo "<span class='text-success'>{$message}</span>";
                    Session::put('message',null);
                }
            ?>
            <div>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin tài khoản</span></h5>
                <div class="bg-light p-30 mb-5">
                    <form role="form" action="{{URL::to('/update_user_account')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Tên tài khoản</label>
                                <input class="form-control" type="text" name="customer_name" value="{{$customer->customer_name}}" placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ E-mail</label>
                                <input class="form-control" type="text" name="customer_email" value="{{$customer->customer_email}}" placeholder="Nhập địa chỉ Email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" type="text" name="customer_phone" value="{{$customer->customer_phone}}" placeholder="Nhập số điện thoại" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label></label><br>
                                <span>
                                    <a style="color: #dc3545;" href="{{url('/doi_mat_khau')}}">Đổi mật khẩu</a>
                                </span>
                            </div>
                            <input type="submit" value="Lưu thông tin" class="btn btn-block btn-danger font-weight-bold py-3">
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin vận chuyển</span></h5>
                <div class="bg-light p-30 mb-5">
                    <form role="form" action="{{URL::to('/update_user_shipping')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Họ và tên</label>
                                <input class="form-control" type="text" name="shipping_name" value="{{$shipping->shipping_name ?? ''}}" placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ E-mail</label>
                                <input class="form-control" type="text" name="shipping_email" value="{{$shipping->shipping_email ?? ''}}" placeholder="Nhập địa chỉ Email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Số điện thoại</label>
                                <input class="form-control" type="text" name="shipping_phone" value="{{$shipping->shipping_phone ?? ''}}" placeholder="Nhập số điện thoại" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ thường trú</label>
                                <input class="form-control" type="text" name="shipping_address" value="{{$shipping->shipping_address ?? ''}}" placeholder="Nhập địa chỉ thường trú" required>
                            </div>
                        </div>
                        <input type="submit" value="Lưu thông tin" class="btn btn-block btn-danger font-weight-bold py-3">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection