@extends('welcome')
@section('content')
<!-- Carousel Start -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($banner as $key => $ban)
                    <div class="carousel-item position-relative {{$key == 0 ? 'active' : ''}}" style="height: 300px;">
                        <img alt="{{$ban->banner_description}}" class="position-absolute w-100 h-100" src="public/upload/banner/{{$ban->banner_image}}" style="object-fit: cover;">
                    </div>
                    @endforeach
                    <a class="carousel-control-prev custom-carousel-control" href="#header-carousel" role="button" data-slide="prev">
                        <i class="fa-solid fa-circle-chevron-left"></i>
                    </a>
                    <a class="carousel-control-next custom-carousel-control" href="#header-carousel" role="button" data-slide="next">
                        <i class="fa-solid fa-circle-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 135px;">
                <img class="img-fluid" src="{{asset('public/frontend/img/sub-banner-1.jpg')}}" alt="">
                
            </div>
            <div class="product-offer mb-30" style="height: 135px;">
                <img class="img-fluid" src="{{asset('public/frontend/img/sub-banner-2.jpg')}}" alt="">
                
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->

<!-- Categories Start -->
<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                        <img class="img-fluid" src="public/frontend/img/cat-1.jpg" alt="">
                    </div>
                    <div class="flex-fill pl-3">
                        <h6>Category Name</h6>
                        <small class="text-body">100 Products</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Categories End -->

<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản Phẩm Mới Nhất</span></h2>
    <div class="row px-xl-5">
        @foreach ($all_book as $key => $book)
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <div class="product-item bg-light mb-4">
                <form>
                    @csrf
                    <input type="hidden" class="cart_book_id_{{$book->book_id}}" value="{{$book->book_id}}">
                    <input type="hidden" class="cart_book_name_{{$book->book_id}}" value="{{$book->book_name}}">
                    <input type="hidden" class="cart_book_image_{{$book->book_id}}" value="{{$book->book_image}}">
                    <input type="hidden" class="cart_book_price_{{$book->book_id}}" value="{{$book->book_price}}">
                    <input type="hidden" class="cart_book_qty_{{$book->book_id}}" value="1">

                <div class="product-img position-relative overflow-hidden">
                    <img class="img w-100" src="{{URL::to('/public/upload/book/'.$book->book_image)}}" alt="">
                    <div class="product-action">
                        <a class="btn btn-outline-danger btn-square add-to-cart" name="add-to-cart" data-id_book="{{$book->book_id}}"><i class="fa fa-shopping-cart"></i></a>
                        <a class="btn btn-outline-danger btn-square"><i class="far fa-heart"></i></a>
                        <a class="btn btn-outline-danger btn-square"><i class="fa fa-sync-alt"></i></a>
                        <a class="btn btn-outline-danger btn-square"><i class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="text-center py-4">
                    <a class="h6 text-decoration-none text-truncate">{{$book->book_name}}</a>
                    <div class="d-flex align-items-center justify-content-center mt-2">
                        <h5>{{number_format($book->book_price).' '.'đ'}}</h5><h6 class="text-muted ml-2"><del>{{number_format($book->book_price).' '.'VND'}}</del></h6>
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
                    <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$book->book_id)}}">Xem Chi Tiết</a>
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