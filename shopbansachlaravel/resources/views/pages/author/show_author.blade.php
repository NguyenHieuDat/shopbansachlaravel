@extends('welcome')
@section('content')
    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        @foreach ($author_name_show as $key => $aut_name)
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">{{$aut_name->author_name}}</span></h2>
        @endforeach

        <div class="row px-xl-5" id="product-list">
            @include('pages.author.author_paginate', ['author_name_show' => $author_name_show])
        </div>
        <div class="pagination-container" id="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    {{ $author_name_show->links('vendor.pagination.custom') }}
                </ul>
            </nav>
        </div>
    </div>
    <!-- Products End -->



@endsection