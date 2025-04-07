@extends('welcome')
@section('content')
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach ($publisher_name_show as $key => $pub_name)
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">{{$pub_name->publisher_name}}</span></h2>
        @endforeach
        <div class="d-flex justify-content-end align-items-center mb-3 px-xl-5">
            <label class="mr-2 mb-0" for="amount">Sắp xếp theo: </label>
            <form>
                @csrf
                <select name="sort" id="sort" class="form-control">
                    <option value="none">--Lọc theo--</option>
                    <option value="tang">Giá tăng dần</option>
                    <option value="giam">Giá giảm dần</option>
                    <option value="a_z">Từ A đến Z</option>
                    <option value="z_a">Từ Z đến A</option>
                </select>
            </form>
        </div>
        <div class="row px-xl-5" id="product-list">
            @include('pages.publisher.publisher_paginate', ['publisher_by_id' => $publisher_by_id])
        </div>
        <div class="pagination-container" id="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{ $publisher_by_id->appends(['sort_by' => request()->get('sort_by')])->links('vendor.pagination.custom') }}
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