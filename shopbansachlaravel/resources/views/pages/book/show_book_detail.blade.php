@extends('welcome')
@section('content')

<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
        <style>
            /* li.active{
                border: 2px solid red;
            } */
            .lSSlideOuter .lSPager.lSGallery li img {
                width: 100%;
                height: 100px;
                object-fit: cover; /* Ảnh sẽ được crop để phủ kín ô li */
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
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(99 Reviews)</small>
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
                        <input type="hidden" class="cart_book_qty_{{$detail->book_id}}" value="1"> <!-- Mặc định số lượng là 1 -->
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
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">* đánh giá cho {{$detail->book_name}}</h4>
                                <div class="media mb-4">
                                    <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-primary">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </div>
                                <form>
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
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
                    
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img w-100" src="{{URL::to('public/upload/book/'.$lq->book_image)}}" alt="">
                        
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="">{{$lq->book_name}}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{number_format($lq->book_price).' '.'đ'}}</h5><h6 class="text-muted ml-2"><del>{{number_format($lq->book_price).' '.'đ'}}</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small class="fa fa-star text-danger mr-1"></small>
                            <small>(99)</small>
                        </div>
                        <a class="btn btn-detail-book" href="{{URL::to('/chi_tiet_sach/'.$lq->book_id)}}">Xem Chi Tiết</a>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->

@endsection