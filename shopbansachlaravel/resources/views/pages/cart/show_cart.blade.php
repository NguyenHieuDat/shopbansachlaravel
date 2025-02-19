@extends('welcome')
@section('content')

<!-- Cart Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-light table-borderless table-hover text-center mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Sản Phẩm</th>
                        <th>Giá Tiền</th>
                        <th>Số Lượng</th>
                        <th>Thành Tiền</th>
                        <th>Bỏ</th>
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
                            <div class="input-group quantity mx-auto" style="width: 120px;">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-danger btn-minus" style="margin-right: 3px;">
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm bg-white border-0 text-center quantity-input" 
                                value="{{$cart['book_qty']}}" data-initial="{{ $cart['book_qty'] }}">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-sm btn-danger btn-plus" style="margin-left: 3px;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle subtotal">{{number_format($subtotal,0,',','.')}}đ</td>
                        <td class="align-middle"><button class="btn btn-sm btn-danger cart-remove"><i class="fa fa-times"></i></button></td>
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
        <div class="col-lg-4">
            <form class="mb-30" action="">
                <div class="input-group">
                    <input type="text" class="form-control border-0 p-4" placeholder="Nhập mã giảm giá">
                    <div class="input-group-append">
                        <button class="btn btn-danger">Nhập Mã Giảm Giá</button>
                    </div>
                </div>
            </form>
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông tin giỏ hàng</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Thành Tiền</h6>
                        <h6 id="total">{{number_format($total,0,',','.')}}đ</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Thuế</h6>
                        <h6 class="font-weight-medium">$15</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Phí Giao Hàng</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Tổng Tiền</h5>
                        <h5>$160</h5>
                    </div>
                    <button class="btn btn-block btn-danger font-weight-bold my-3 py-3">Thanh Toán</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection