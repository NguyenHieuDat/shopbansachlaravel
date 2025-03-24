@extends('admin_layout')
@section('admin_content')
<div class="row">
<div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm user
            </header>
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">'.$message.'</span>';
                    Session::put('message',null);
                }
                ?>
            <div class="panel-body">

                <div class="position-center">
                    <form role="form" action="{{URL::to('/store_users')}}" method="post">
                        @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên người dùng</label>
                        <input type="text" name="admin_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Địa chỉ Email</label>
                        <input type="text" name="admin_email" class="form-control">
                    </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">Số điện thoại</label>
                        <input type="text" name="admin_phone" class="form-control">
                    </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">Mật khẩu</label>
                        <input type="text" name="admin_password" class="form-control">
                    </div>
                    <button type="submit" name="add_category_product" class="btn btn-info">Thêm người dùng</button>
                    </form>
                </div>

            </div>
        </section>

</div>
@endsection