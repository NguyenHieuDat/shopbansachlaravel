@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm phí vận chuyển
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
                    <form role="form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Chọn thành phố</label>
                            <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                <option value="0">--Chọn thành phố--</option>
                                @foreach ($city as $key => $cities)
                                    <option value="{{$cities->matp}}">{{$cities->tentp}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Chọn quận/huyện</label>
                            <select name="province" id="province" class="form-control input-sm m-bot15 choose province">
                                <option value="0">--Chọn quận/huyện--</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Chọn phường/xã</label>
                            <select name="ward" id="ward" class="form-control input-sm m-bot15 ward">
                                <option value="0">--Chọn phường/xã--</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nhập số tiền</label>
                            <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1">
                        </div>
                        <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                    </form>
                </div>
                <div id="load_delivery">

                </div>
            </div>
        </section>
    </div>
</div>
@endsection