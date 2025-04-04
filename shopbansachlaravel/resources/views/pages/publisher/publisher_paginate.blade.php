@foreach ($publisher_by_id as $key => $book_pub)
<div class="col-lg-3 col-md-4 col-sm-6 pb-1">
    <div class="product-item bg-light mb-4">
        <form>
            @csrf
            <input type="hidden" class="cart_book_id_{{$book_pub->book_id}}" value="{{$book_pub->book_id}}">
            <input type="hidden" class="cart_book_name_{{$book_pub->book_id}}" value="{{$book_pub->book_name}}">
            <input type="hidden" class="cart_book_image_{{$book_pub->book_id}}" value="{{$book_pub->book_image}}">
            <input type="hidden" class="cart_book_price_{{$book_pub->book_id}}" value="{{$book_pub->book_price}}">
            <input type="hidden" class="cart_book_qty_{{$book_pub->book_id}}" value="1">

        <div class="product-img position-relative overflow-hidden">
            <img class="img-fluid w-100" src="{{URL::to('/public/upload/book/'.$book_pub->book_image)}}" alt="">
            <div class="product-action">
                <a class="btn btn-outline-danger btn-square add-to-cart" name="add-to-cart" data-id_book="{{$book_pub->book_id}}"><i class="fa fa-shopping-cart"></i></a>
                <a class="btn btn-outline-danger btn-square" href=""><i class="far fa-heart"></i></a>
                <a class="btn btn-outline-danger btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                <a class="btn btn-outline-danger btn-square" href=""><i class="fa fa-search"></i></a>
            </div>
        </div>
        <div class="text-center py-4">
            <a class="h6 text-decoration-none text-truncate book-name" style="max-width: 150px; margin: 0 auto;">{{$book_pub->book_name}}</a>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <h5 style="color: #dc3545">{{number_format($book_pub->book_price).' '.'đ'}}</h5>
            </div>
            <div class="d-flex align-items-center justify-content-center mb-1">
                @php
                    $fullStars = floor($book_pub->avgRating);
                    $halfStar = ($book_pub->avgRating - $fullStars) >= 0.5 ? 1 : 0;
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
                <small>({{ $book_pub->totalreview }})</small>
            </div>
            <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$book_pub->book_id.'?source=publisher')}}">Xem Chi Tiết</a>
        </div>
        </form>
    </div>
</div>
@endforeach