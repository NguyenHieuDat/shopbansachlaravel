@extends('welcome')
@section('content')
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Kết quả tìm kiếm</span></h2>
        <div class="row px-xl-5">
            @foreach ($search_book as $key => $sbook)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <form>
                        @csrf
                        <input type="hidden" class="cart_book_id_{{$sbook->book_id}}" value="{{$sbook->book_id}}">
                        <input type="hidden" class="cart_book_name_{{$sbook->book_id}}" value="{{$sbook->book_name}}">
                        <input type="hidden" class="cart_book_image_{{$sbook->book_id}}" value="{{$sbook->book_image}}">
                        <input type="hidden" class="cart_book_price_{{$sbook->book_id}}" value="{{$sbook->book_price}}">
                        <input type="hidden" class="cart_book_qty_{{$sbook->book_id}}" value="1">

                    <div class="product-img position-relative overflow-hidden">
                        <img class="img w-100" src="{{URL::to('/public/upload/book/'.$sbook->book_image)}}" alt="">
                        <div class="product-action">
                            <a class="btn btn-outline-danger btn-square add-to-cart" name="add-to-cart" data-id_book="{{$sbook->book_id}}"><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-danger btn-square"><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-danger btn-square"><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-danger btn-square"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate">{{$sbook->book_name}}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{number_format($sbook->book_price).' '.'đ'}}</h5><h6 class="text-muted ml-2"><del>{{number_format($sbook->book_price).' '.'VND'}}</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small>(99)</small>
                        </div>
                    </div>
                    <div style="text-align: center">
                        <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$sbook->book_id)}}">Xem Chi Tiết</a>
                    </div>
                    </form>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-1.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-2.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-3.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-4.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-5.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-6.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-7.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="public/frontend/img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection