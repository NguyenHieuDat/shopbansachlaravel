@extends('welcome')
@section('content')
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach ($author_name_show as $key => $aut_name)
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">{{$aut_name->author_name}}</span></h2>
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
            @include('pages.author.author_paginate', ['author_by_id' => $author_by_id])
        </div>
        <div class="pagination-container" id="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{ $author_by_id->appends(['sort_by' => request()->get('sort_by')])->links('vendor.pagination.custom') }}
                </ul>
            </nav>
        </div>
    </div>
    <!-- Products End -->
@endsection