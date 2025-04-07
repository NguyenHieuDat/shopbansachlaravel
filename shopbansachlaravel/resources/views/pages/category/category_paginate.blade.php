@foreach ($category_by_id as $key => $book_cate)
<div class="col-lg-3 col-md-4 col-sm-6 pb-1">
    <div class="product-item bg-light mb-4">
        <form>
            @csrf
            <input type="hidden" class="cart_book_id_{{$book_cate->book_id}}" value="{{$book_cate->book_id}}">
            <input type="hidden" class="cart_book_name_{{$book_cate->book_id}}" value="{{$book_cate->book_name}}">
            <input type="hidden" class="cart_book_image_{{$book_cate->book_id}}" value="{{$book_cate->book_image}}">
            <input type="hidden" class="cart_book_price_{{$book_cate->book_id}}" value="{{$book_cate->book_price}}">
            <input type="hidden" class="cart_book_qty_{{$book_cate->book_id}}" value="1">
        <div class="product-img position-relative overflow-hidden">
            <img class="img-fluid w-100" src="{{URL::to('/public/upload/book/'.$book_cate->book_image)}}" alt="">
            <div class="product-action">
                <a class="btn btn-outline-danger btn-square add-to-cart" name="add-to-cart" data-id_book="{{$book_cate->book_id}}"><i class="fa fa-shopping-cart"></i></a>
                <a class="btn btn-outline-danger btn-square" href=""><i class="far fa-heart"></i></a>
                <a class="btn btn-outline-danger btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                <a class="btn btn-outline-danger btn-square" href=""><i class="fa fa-search"></i></a>
            </div>
        </div>
        <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate book-name" title="{{$book_cate->book_name}}" data-bs-toggle="tooltip" 
                style="max-width: 100%; margin: 0 auto; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$book_cate->book_name}}</a>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <h5 style="color: #dc3545">{{number_format($book_cate->book_price).' '.'đ'}}</h5>
            </div>
            <div class="d-flex align-items-center justify-content-center mb-1">
                @php
                    $fullStars = floor($book_cate->avgRating);
                    $halfStar = ($book_cate->avgRating - $fullStars) >= 0.5 ? 1 : 0;
                    $emptyStars = 5 - ($fullStars + $halfStar);
                @endphp
                @for ($i = 0; $i < $fullStars; $i++)
                    <small class="fa fa-star text-danger mr-1"></small>
                @endfor
                @if ($halfStar)
                    <small class="fa fa-star-half-alt text-danger mr-1"></small>
                @endif
                @for ($i = 0; $i < $emptyStars; $i++)
                    <small class="fa fa-star text-muted mr-1"></small>
                @endfor
                <small>({{ $book_cate->totalreview }})</small>
            </div>
            <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$book_cate->book_id.'?source=category')}}">Xem Chi Tiết</a>
        </div>
        </form>
    </div>
</div>
@endforeach