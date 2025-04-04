@extends('welcome')
@section('content')
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach ($category_name_show as $key => $cate_name)
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">{{$cate_name->category_name}}</span></h2>
        @endforeach

        <div class="row px-xl-5" id="product-list">
            @include('pages.category.category_paginate', ['category_name_show' => $category_name_show])
        </div>
        <div class="pagination-container" id="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{ $category_name_show->links('vendor.pagination.custom') }}
                </ul>
            </nav>
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