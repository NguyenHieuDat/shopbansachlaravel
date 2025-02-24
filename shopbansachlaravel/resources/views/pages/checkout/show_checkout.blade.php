@extends('welcome')
@section('content')
<!-- Checkout Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Thông Tin Thanh Toán</span></h5>
            <div class="bg-light p-30 mb-5">
                <form action="{{URL::to('/save_checkout_customer')}}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Họ và tên</label>
                        <input class="form-control" type="text" name="shipping_name" placeholder="Doe">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa chỉ E-mail</label>
                        <input class="form-control" type="text" name="shipping_email" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Số điện thoại</label>
                        <input class="form-control" type="text" name="shipping_phone" placeholder="+123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa chỉ thường trú</label>
                        <input class="form-control" type="text" name="shipping_address" placeholder="123 Street">
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" name="shipping_note" rows="6" style="resize: none;" placeholder="Ghi chú đơn hàng"></textarea>
                    </div>
                </div>
            </form>
            </div>
        </div>
        <div class="col-lg-4">
            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
            <div class="bg-light p-30 mb-5">
                <div class="border-bottom">
                    <h6 class="mb-3">Products</h6>
                    <div class="d-flex justify-content-between">
                        <p>Product Name 1</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Product Name 2</p>
                        <p>$150</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Product Name 3</p>
                        <p>$150</p>
                    </div>
                </div>
                <div class="border-bottom pt-3 pb-2">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Subtotal</h6>
                        <h6>$150</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>
                <div class="pt-2">
                    <div class="d-flex justify-content-between mt-2">
                        <h5>Total</h5>
                        <h5>$160</h5>
                    </div>
                </div>
            </div>
            <div class="mb-5">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                <div class="bg-light p-30">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="banktransfer">
                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                        </div>
                    </div>
                    <input type="submit" name="send_order" value="Thanh Toán" class="btn btn-block btn-danger font-weight-bold py-3" >
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->
@endsection