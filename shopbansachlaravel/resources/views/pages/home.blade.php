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
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Danh mục sách</span></h2>
    <div class="row px-xl-5 pb-3">
        @foreach($categories as $cate_show)
        <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <a class="text-decoration-none" href="{{ URL::to('/danh_muc_sach/'.$cate_show->category_id) }}">
                <div class="cat-item d-flex align-items-center mb-4">
                    <div class="overflow-hidden" style="width: 100px; height: 100px;">
                        <img class="img-fluid" src="{{ asset('public/upload/category/'.$cate_show->category_image) }}" alt="{{ $cate_show->category_name }}">
                    </div>
                    <div class="flex-fill pl-3">
                        <h6>{{ $cate_show->category_name }}</h6>
                        <small class="text-body">{{ $cate_show->total_quantity ?? 0 }} Sản phẩm</small>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
<!-- Categories End -->

<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản Phẩm Mới Nhất</span></h2>
    <div class="row px-xl-5" id="product-list">
        @include('pages.book.book_paginate', ['all_book' => $all_book])
    </div>
    <div class="pagination-container" id="pagination-container">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{ $all_book->links('vendor.pagination.custom') }}
            </ul>
        </nav>
    </div>
</div>
<!-- Products End -->


{{-- <!-- Vendor Start -->
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
<!-- Vendor End --> --}}
@endsection