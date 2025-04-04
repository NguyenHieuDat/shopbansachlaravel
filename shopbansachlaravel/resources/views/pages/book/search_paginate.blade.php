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
            <a class="h6 text-decoration-none text-truncate book-name" style="max-width: 150px; margin: 0 auto;">{{$sbook->book_name}}</a>
            <div class="d-flex align-items-center justify-content-center mt-2">
                <h5 style="color: #dc3545">{{number_format($sbook->book_price).' '.'đ'}}</h5>
            </div>
            <div class="d-flex align-items-center justify-content-center mb-1">
                @php
                    $fullStars = floor($sbook->avgRating);
                    $halfStar = ($sbook->avgRating - $fullStars) >= 0.5 ? 1 : 0;
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
                <small>({{ $sbook->totalreview }})</small>
            </div>
        </div>
        <div style="text-align: center">
            <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$sbook->book_id)}}">Xem Chi Tiết</a>
        </div>
        </form>
    </div>
</div>
@endforeach