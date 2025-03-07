@extends('welcome')
@section('content')
<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div>
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin vận chuyển</span></h5>
            <div class="bg-light p-30 mb-5">
                <form role="form" action="{{URL::to('/save_checkout_customer')}}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Họ và tên</label>
                        <input class="form-control" type="text" name="shipping_name" value="{{ old('shipping_name', Session::get('shipping_name')) }}" placeholder="Nhập họ và tên" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa chỉ E-mail</label>
                        <input class="form-control" type="text" name="shipping_email" value="{{ old('shipping_email', Session::get('shipping_email')) }}" placeholder="Nhập địa chỉ Email" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Số điện thoại</label>
                        <input class="form-control" type="text" name="shipping_phone" value="{{ old('shipping_phone', Session::get('shipping_phone')) }}" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa chỉ thường trú</label>
                        <input class="form-control" type="text" name="shipping_address" value="{{ old('shipping_address', Session::get('shipping_address')) }}" placeholder="Nhập địa chỉ thường trú" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Chọn thành phố</label>
                            <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                <option value="0">--Chọn thành phố--</option>
                                @foreach ($city as $key => $cities)
                                    <option value="{{$cities->matp}}">{{$cities->tentp}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Chọn quận/huyện</label>
                            <select name="province" id="province" class="form-control input-sm m-bot15 choose province">
                                <option value="0">--Chọn quận/huyện--</option>
                            </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Chọn phường/xã</label>
                        <select name="ward" id="ward" class="form-control input-sm m-bot15 ward">
                            <option value="0">--Chọn phường/xã--</option> 
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" name="shipping_note" rows="6" style="resize: none;" placeholder="Nhập ghi chú đơn hàng"></textarea>
                    </div>
                </div>
                <input type="submit" name="send_order" value="Xác nhận thông tin" class="btn btn-block btn-danger font-weight-bold py-3 calculate_delivery">
            </form>
            </div>
            </div>
            <div>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin giỏ hàng</span></h5>
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sản Phẩm</th>
                            <th>Giá Tiền</th>
                            <th>Số Lượng</th>
                            <th>Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                         $total = 0;
                        @endphp
                        @if(Session::has('cart') && count(Session::get('cart')) > 0)
                        @foreach (Session::get('cart') as $key => $cart)
                        @php
                         $subtotal = $cart['book_price']*$cart['book_qty'];
                         $total += $subtotal;
                        @endphp
                        <tr data-rowid="{{ $key }}">
                            <td class="align-middle">
                                <img src="{{asset('public/upload/book/'.$cart['book_image'])}}" alt="" style="width: 50px;">
                                {{$cart['book_name']}}
                            </td>
                            <td class="align-middle">{{number_format($cart['book_price'],0,',','.')}}đ</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 60px;"> 
                                <input type="text" class="form-control form-control-sm bg-white border-0 text-center quantity-input" 
                                    value="{{$cart['book_qty']}}" readonly>
                                </div>
                            </td>
                            <td class="align-middle subtotal">{{number_format($subtotal,0,',','.')}}đ</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin thanh toán</span></h5>
            <div>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Thành Tiền:</h6>
                            <h6 id="total">{{number_format($total,0,',','.')}}đ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6>Mã giảm:</h6>
                            <h6 id="coupon_value" class="font-weight-medium coupon_amount">
                                @if(Session::get('coupon'))
                            @foreach (Session::get('coupon') as $key => $cou)
                                @if($cou['coupon_condition'] == 1)
                                {{$cou['coupon_price']}}% {{-- Hiển thị đúng phần trăm --}}
                            @elseif($cou['coupon_condition'] == 2)
                                {{ number_format($cou['coupon_price'], 0, ',', '.') }}đ
                            @endif
                            @endforeach
                            @else
                                <em>Không có mã</em>
                            @endif  
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Thành Tiền Sau Khuyến Mãi:</h6>
                            <h6 class="font-weight-medium total_after_discount">
                                @php
                                $total_coupon = Session::get('total_coupon', 0); // Lấy từ Session, mặc định là 0 nếu không tồn tại
                                @endphp
                                @if(Session::get('coupon'))
                                    {{number_format($total - $total_coupon, 0, ',', '.')}}đ
                                @else
                                    <em>Chưa áp dụng</em>
                                @endif
                            </h6>
                        </div>
                        
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2 total_include">
                            <h5>Tổng Tiền:</h5>
                            <h4>@php
                                 $total_coupon = Session::get('coupon') ? Session::get('total_coupon', 0) : 0; 
                                 
                                 $total_final = ($total - $total_coupon);
                            @endphp
                            {{ number_format($total_final, 0, ',', '.') }}đ</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->
@endsection