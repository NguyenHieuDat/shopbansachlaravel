@extends('welcome')
@section('content')
<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30">
                <a class="breadcrumb-item text-dark" href="{{url('/')}}">Trang chủ</a><span class="breadcrumb-separator">/</span>
                @if(request()->get('source') == 'author')
                    <a class="breadcrumb-item text-dark" href="{{ url('/danh_muc_tac_gia/'.$author_id) }}">{{ $author_name }}</a><span class="breadcrumb-separator">/</span>
                @elseif(request()->get('source') == 'publisher')
                    <a class="breadcrumb-item text-dark" href="{{ url('/danh_muc_nha_xb/'.$publisher_id) }}">{{ $publisher_name }}</a><span class="breadcrumb-separator">/</span>
                @else
                    <a class="breadcrumb-item text-dark" href="{{ url('/danh_muc_sach/'.$category_id) }}">{{ $product_cate }}</a><span class="breadcrumb-separator">/</span>
                @endif
                <span class="breadcrumb-item active">{{$meta_title}}</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
        <style>
            /* li.active{
                border: 2px solid red;
            } */
            .lSSlideOuter .lSPager.lSGallery li img {
                width: 100%;
                height: 100px;
                object-fit: cover;
            }
            .book-container {
                display: grid;
                grid-template-columns: 1fr 2fr;
                gap: 20px;
                max-width: 500px;
            }
            .book-container .title {
                font-weight: bold;
        }
        </style>
    <div>   
            @foreach ($book_detail as $key => $detail)
            
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <ul id="imageGallery">
                @foreach ($gallery as $key => $gall)
                <li data-thumb="{{asset('public/upload/gallery/'.$gall->gallery_image)}}" data-src="{{asset('public/upload/gallery/'.$gall->gallery_image)}}">
                  <img style="width: 100%; height: 600px; object-fit: contain;" alt="{{$gall->gallery_name}}" src="{{asset('public/upload/gallery/'.$gall->gallery_image)}}">
                </li>
                @endforeach
              </ul>
        </div>
        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3>{{$detail->book_name}}</h3>
                <div class="d-flex mb-3">
                    <div class="text-danger mr-2">
                        @php
                            $fullStars = floor($avgRating);
                            $halfStar = ($avgRating - $fullStars) >= 0.5 ? 1 : 0;
                            $emptyStars = 5 - ($fullStars + $halfStar);
                        @endphp
                        @for ($i = 0; $i < $fullStars; $i++)
                            <small class="fas fa-star"></small>
                        @endfor
                        @if ($halfStar)
                            <small class="fas fa-star-half-alt"></small>
                        @endif
                        @for ($i = 0; $i < $emptyStars; $i++)
                            <small class="far fa-star"></small>
                        @endfor
                    </div>
                    <small class="pt-1">({{number_format($avgRating, 1)}} / 5 từ {{$totalreview}} đánh giá)</small>
                </div>
                
                <h3 class="font-weight-semi-bold mb-4 book-price" data-price="{{$detail->book_price}}">Giá tiền: {{number_format($detail->book_price).' '.'đ'}}</h3>
                <div class="book-container">
                    <div class="title">Mã sách:</div><div>{{$detail->book_id}}</div>
                    <div class="title">Danh mục sách:</div><div>{{$detail->category_name}}</div>
                    <div class="title">Tác giả:</div><div>{{$detail->author_name}}</div>
                    <div class="title">Nhà xuất bản:</div><div>{{$detail->publisher_name}}</div>
                    <div class="title">Năm xuất bản:</div><div>{{$detail->book_year}}</div>
                    <div class="title">Ngôn ngữ:</div><div>{{$detail->book_language}}</div>
                    <div class="title">Số trang:</div><div>{{$detail->book_page}}</div>
                    <div class="title">Tình trạng:</div><div>Còn hàng</div>

                </div>
                <br>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <form>
                        @csrf
                        <input type="hidden" class="cart_book_id_{{$detail->book_id}}" value="{{$detail->book_id}}">
                        <input type="hidden" class="cart_book_name_{{$detail->book_id}}" value="{{$detail->book_name}}">
                        <input type="hidden" class="cart_book_image_{{$detail->book_id}}" value="{{$detail->book_image}}">
                        <input type="hidden" class="cart_book_price_{{$detail->book_id}}" value="{{$detail->book_price}}">
                        <input type="hidden" class="cart_book_qty_{{$detail->book_id}}" value="1">
                    <button type="button" name="add-to-cart" data-id_book="{{$detail->book_id}}" class="btn btn-danger px-3 add-to-cart"><i class="fa fa-shopping-cart mr-1"></i> Thêm vào giỏ hàng</button>
                    </form>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Chia sẻ: </strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Mô tả sản phẩm</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Đánh giá (0)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Mô tả sản phẩm:</h4>
                        <p>{!! $detail->book_description !!}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <form method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" class="comment_book_id" name="comment_book_id" value="{{$detail->book_id}}">
                                    <h4 class="mb-4">Đánh giá cho: {{$detail->book_name}}</h4>
                                    <div id="show_comment">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Để lại đánh giá và bình luận</h4>
                                    <small>Các ô được đánh dấu * là bắt buộc.</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Đánh giá của bạn: </p>
                                        <div class="text-danger rating-stars">
                                            <i class="far fa-star star" data-value="1"></i>
                                            <i class="far fa-star star" data-value="2"></i>
                                            <i class="far fa-star star" data-value="3"></i>
                                            <i class="far fa-star star" data-value="4"></i>
                                            <i class="far fa-star star" data-value="5"></i>
                                        </div>
                                        <input type="hidden" id="rating" class="rating_value" value="0">
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Bình luận của bạn: *</label>
                                            <textarea id="message" cols="30" rows="5" name="comment" class="form-control comment_content" placeholder="Nhập bình luận"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Họ và tên: *</label>
                                            <input type="text" class="form-control comment_name" id="name" placeholder="Nhập tên của bạn" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="button" value="Gửi bình luận" class="btn btn-danger px-3 send_comment">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Những tựa sách liên quan</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($related as $key => $lq)
                <div class="product-item bg-light">
                    <form>
                        @csrf
                            <input type="hidden" class="cart_book_id_{{$lq->book_id}}" value="{{$lq->book_id}}">
                            <input type="hidden" class="cart_book_name_{{$lq->book_id}}" value="{{$lq->book_name}}">
                            <input type="hidden" class="cart_book_image_{{$lq->book_id}}" value="{{$lq->book_image}}">
                            <input type="hidden" class="cart_book_price_{{$lq->book_id}}" value="{{$lq->book_price}}">
                            <input type="hidden" class="cart_book_qty_{{$lq->book_id}}" value="1">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img w-100" src="{{URL::to('public/upload/book/'.$lq->book_image)}}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-danger btn-square add-to-cart" name="add-to-cart" data-id_book="{{$lq->book_id}}"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-danger btn-square button-wishlist" id="{{$lq->book_id}}" onclick="add_wishlist(this.id);"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-danger btn-square"><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-danger btn-square"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate book-name" title="{{$lq->book_name}}" data-bs-toggle="tooltip" 
                            style="max-width: 100%; margin: 0 auto; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$lq->book_name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5 style="color: #dc3545">{{number_format($lq->book_price).' '.'đ'}}</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                @php
                                    $fullStars = floor($lq->avgRating);
                                    $halfStar = ($lq->avgRating - $fullStars) >= 0.5 ? 1 : 0;
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
                                <small>({{ $lq->totalreview }})</small>
                            </div>
                            <input type="hidden" class="cart_book_rating_{{$lq->book_id}}" value="{{$lq->avgRating}}">
                            <input type="hidden" class="cart_book_review_{{$lq->book_id}}" value="{{$lq->totalreview}}">
                            <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$lq->book_id)}}">Xem Chi Tiết</a>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->

@endsection