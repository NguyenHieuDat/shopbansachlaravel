@extends('welcome')
@section('content')
<style>
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
</style>
<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin giỏ hàng</span></h5>
            <div>
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
                        @else
                        <tr>
                            <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống! Đi đến 
                                <a class="text-danger" href="{{URL::to('/cua_hang')}}">Cửa Hàng</a>?
                            </td>
                        </tr>
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
                            <h6 id="total" data-total="{{ $total }}">{{ number_format($total, 0, ',', '.') }}đ</h6>
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
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Phí Vận Chuyển:</h6>
                            <h6 class="font-weight-medium feeship_display">
                                @php
                                 $feeship = Session::get('fees', 0);   
                                @endphp
                                @if($feeship > 0)
                                    {{ number_format($feeship, 0, ',', '.') }}đ
                                @else
                                    <em>Chưa tính phí</em>
                                @endif
                            </h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2 total_include">
                            <h5>Tổng Tiền:</h5>
                            <h4 class="total_final_display">
                            @php
                                $total_coupon = Session::get('coupon') ? Session::get('total_coupon', 0) : 0; 
                                $feeship = Session::get('fees', 0);
                                $total_final = ($total - $total_coupon) + $feeship;
                            @endphp
                            {{ number_format($total_final, 0, ',', '.') }}đ</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Hình thức thanh toán</span></h5>
                <form method="POST" id="orderForm">
                    @csrf
                <input type="hidden" name="total_bf" value="{{ $total }}">
                <div class="bg-light p-30 payment_options">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment_option" id="banktransfer" value="1">
                            <label class="custom-control-label" for="banktransfer">Chuyển khoản</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment_option" id="directcheck" value="2">
                            <label class="custom-control-label" for="directcheck">Tiền mặt</label>
                        </div>
                    </div>
                    {{-- <div class="form-group mb-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment_option" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div> --}}
                    <button type="submit" name="send_order_place" class="btn btn-block btn-danger font-weight-bold py-3">Đặt hàng</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->
@endsection