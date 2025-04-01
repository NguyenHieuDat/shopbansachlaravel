<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$meta_title}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{$meta_keywords}}" name="keywords">
    <meta content="{{$meta_desc}}" name="description">
    <meta content="INDEX,FOLLOW" name="robots">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{asset('public/frontend/img/favicon.ico')}}" rel="icon">
    <!-- SEO link -->
    <link href="{{$url_canonical}}" rel="canonical">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('public/frontend/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('public/frontend/css/style.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{asset('public/frontend/css/lightslider.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('public/frontend/css/sweetalert.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="{{url('/')}}" class="text-decoration-none">
                    <img src="{{asset('public/frontend/img/fahasa-logo.jpeg')}}" alt="Logo" style="height: 50px; max-width: 100%; object-fit: contain;">
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form id="searchForm" action="{{URL::to('/tim_kiem')}}" method="POST">
                    @csrf
                    <div class="input-group" style="position: relative;">
                        <input type="text" name="keywords_submit" id="searchInput" class="form-control" placeholder="Nhập Để Tìm Kiếm Sản Phẩm" autocomplete="off">
                        <div id="search_ajax" style="position: absolute; top: 100%; left: 0; width: 100%;"></div>
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-danger" id="searchIcon">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <div class="user-actions d-flex justify-content-end align-items-center">
                    <div class="cart" onclick="window.location.href='{{ url('/gio_hang') }}'">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Giỏ hàng</span>
                    </div>
                    <div class="account">
                        <i class="fas fa-user"></i>
                        <span>Tài khoản</span>
                        <div class="dropdown-account">
                            @php
                                $customer_id = Session::get('customer_id');
                            @endphp
                            @if($customer_id != null)
                                <button onclick="window.location.href='{{ url('/user_account') }}'">Xem tài khoản</button>
                                <button onclick="window.location.href='{{ url('/logout_checkout') }}'">Đăng xuất</button>
                            @else
                                <button onclick="window.location.href='{{ url('/login_checkout') }}'">Đăng nhập</button>
                                <button onclick="window.location.href='{{ url('/login_checkout') }}'">Đăng ký</button>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid bg-danger mb-30">
    <div class="row px-xl-5">
        <div class="col-lg-3 d-none d-lg-block">
            <a class="btn d-flex align-items-center justify-content-between bg-light w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Danh Mục</h6>
                <i class="fa fa-angle-down text-dark"></i>
            </a>
            <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                <div class="navbar-nav w-100">
                    @foreach ($category as $key => $cate)
                    @if($cate->category_parent == 0)
                    <div class="nav-item dropdown dropright">
                        <a href="{{ URL::to('/danh_muc_sach/'.$cate->category_id) }}" class="nav-link">{{ $cate->category_name }}<i class="fa fa-angle-right float-right mt-1"></i></a>
                
                        @php
                            // Truy vấn danh mục con từ DB
                            $sub_categories = DB::table('tbl_category_product')
                                                ->where('category_parent', $cate->category_id)
                                                ->get();
                        @endphp
                
                        @if($sub_categories->isNotEmpty())
                        <!-- Dropdown con (bên phải) -->
                        <div class="dropdown-menu sub-category-menu">
                            @foreach($sub_categories as $sub_cate)
                                <a href="{{ URL::to('/danh_muc_sach/'.$sub_cate->category_id) }}" class="dropdown-item">
                                    {{ $sub_cate->category_name }}
                                </a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endif
                    @endforeach

                    <!-- Tác giả -->
                    <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Tác giả<i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            @foreach ($author as $key => $aut)
                                <a href="{{ URL::to('/danh_muc_tac_gia/'.$aut->author_id) }}" class="dropdown-item">{{ $aut->author_name }}</a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Nhà xuất bản -->
                    <div class="nav-item dropdown dropright">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Nhà xuất bản<i class="fa fa-angle-right float-right mt-1"></i></a>
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                            @foreach ($publisher as $key => $pub)
                                <a href="{{ URL::to('/danh_muc_nha_xb/'.$pub->publisher_id) }}" class="dropdown-item">{{ $pub->publisher_name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Navbar chính -->
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-danger navbar-dark py-3 py-lg-0 px-0">
                <a href="" class="text-decoration-none d-block d-lg-none"></a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{ URL::to('/trang_chu') }}" class="nav-item nav-link text-light active">Trang Chủ</a>
                        <a href="shop.html" class="nav-item nav-link text-light">Cửa Hàng</a>
                        <a href="{{ URL::to('/gio_hang') }}" class="nav-item nav-link text-light">Giỏ Hàng</a>
                        @php
                            $customer_id = Session::get('customer_id');
                            $shipping_id = Session::get('shipping_id');
                        @endphp
                        @if($customer_id != null && $shipping_id == null)
                        <a href="{{ URL::to('/checkout') }}" class="nav-item nav-link text-light">Thanh Toán</a>
                        @elseif($customer_id != null && $shipping_id != null)
                        <a href="{{ URL::to('/payment') }}" class="nav-item nav-link text-light">Thanh Toán</a>
                        @else
                        <a href="{{ URL::to('/login_checkout') }}" class="nav-item nav-link text-light">Thanh Toán</a>
                        @endif
                        <a href="{{ URL::to('/lien_he') }}" class="nav-item nav-link text-light">Liên Hệ</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                        <a href="" class="btn px-0">
                            <i class="fas fa-heart text-light"></i>
                            <span class="badge text-light border border-light rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="{{ URL::to('/gio_hang') }}" class="btn px-0 ml-3">
                            <i class="fas fa-shopping-cart text-light"></i>
                            <span class="badge text-light border border-light rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- Navbar End -->


    <!-- Home -->
    <div>
        @yield('content')
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">No dolore ipsum accusam no lorem. Invidunt sed clita kasd clita et et dolor sed dolor. Rebum tempor no vero est magna amet no</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duo stet tempor ipsum sit amet magna ipsum tempor est</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Follow Us</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="btn btn-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">Domain</a>. All Rights Reserved. Designed
                    by
                    <a class="text-primary" href="https://htmlcodex.com">HTML Codex</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="public/frontend/img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    {{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('public/frontend/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('public/frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{asset('public/frontend/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{asset('public/frontend/mail/contact.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('public/frontend/js/main.js')}}"></script>

    <script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/prettify.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('#imageGallery').lightSlider({
            gallery:true,
            item:1,
            loop:true,
            thumbItem:5,
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '#imageGallery .lslide'
                });
            }   
        });  
    });

    $(document).ready(function() {
        $('.add-to-cart').click(function(e){
            e.preventDefault(); // Ngăn hành động mặc định
            var id = $(this).data('id_book');
            var cart_book_id = $('.cart_book_id_'+id).val();
            var cart_book_name = $('.cart_book_name_'+id).val();
            var cart_book_image = $('.cart_book_image_'+id).val();
            var cart_book_price = $('.cart_book_price_'+id).val();
            var cart_book_qty = $('.cart_book_qty_'+id).val();
            var _token = $('input[name="_token"]').val();

            // Hiển thị hộp thoại xác nhận với SweetAlert2
        Swal.fire({
            title: "Thêm vào giỏ hàng",
            text: "Bạn có muốn thêm vào giỏ hàng?",
            imageUrl: "{{ asset('public/frontend/img/cart-icon-gif.gif') }}", // Đường dẫn ảnh giỏ hàng
            imageWidth: 120, // Độ rộng ảnh (có thể chỉnh)
            imageHeight: 120, // Độ cao ảnh
            showCancelButton: true,
            confirmButtonText: "Đồng ý",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                // Nếu người dùng nhấn Đồng ý, gọi Ajax để thêm sản phẩm
                $.ajax({
                    url: "{{ url('/add_cart') }}",
                    method: "POST",
                    data: {
                        cart_book_id: cart_book_id,
                        cart_book_name: cart_book_name,
                        cart_book_image: cart_book_image,
                        cart_book_price: cart_book_price,
                        cart_book_qty: cart_book_qty,
                        _token: _token
                    },
                    success: function(data) {
                    // Sau khi thêm thành công, hiển thị thông báo
                    Swal.fire({
                        title: "Đã thêm vào giỏ hàng!",
                        text: "Sản phẩm đã được thêm thành công",
                        icon: "success",
                        confirmButtonText: "Đi đến giỏ hàng",
                        cancelButtonText: "OK",
                        showCancelButton: true, // Hiển thị nút Hủy
                        customClass: {
                            popup: 'swal-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Nếu người dùng nhấn "Đi đến giỏ hàng"
                            window.location.href = "{{ url('/gio_hang') }}";
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Không làm gì cả, SweetAlert sẽ tự đóng
                        }
                    });
                },
                    error: function(xhr, status, error) {
                        Swal.fire("Có lỗi xảy ra: " + error);
                    }
                });
            } 
            });
        });
    });

        $(document).ready(function() {
        // Sử dụng event delegation để gán sự kiện cho nút plus
        $(document).on('click', '.btn-plus', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var input = row.find('.quantity-input');
            // Lấy giá trị ban đầu được lưu trong data-initial
            var currentInitial = parseInt(input.data('initial'));
            console.log("Initial qty from data:", currentInitial);
            // Tính giá trị mới
            var newQty = currentInitial + 1;
            console.log("New qty:", newQty);
            // Cập nhật cả giá trị hiển thị và data-initial
            input.val(newQty);
            input.data('initial', newQty);
            // Gọi hàm updateCart nếu cần cập nhật vào server
            var rowid = row.data('rowid');
            updateCart(rowid, newQty, row);
        });

        $(document).on('click', '.btn-minus', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var input = row.find('.quantity-input');

            // Lấy giá trị từ data-initial
            var currentInitial = parseInt(input.data('initial'));
            console.log("Initial qty from data:", currentInitial);

            // Nếu giá trị đang là 1, không cho giảm thêm nữa
            if (currentInitial <= 1) {
                input.val(1);
                input.data('initial', 1);
                input.attr('data-initial', 1);
                console.log("Quantity is already at the minimum value (1).");
                return;
            }
            // Nếu lớn hơn 1, giảm đi 1
            var newQty = currentInitial - 1;
            console.log("New qty:", newQty);

            // Cập nhật lại input và data-initial
            input.val(newQty);
            input.data('initial', newQty);
            // Đảm bảo đồng bộ với thuộc tính DOM (nếu cần)
            input.attr('data-initial', newQty);

            var rowid = row.data('rowid');
            updateCart(rowid, newQty, row);
        });


        $(document).on('blur', '.quantity-input', function() {
            var row   = $(this).closest('tr');
            var input = $(this);
            var newQty = parseInt(input.val());
            // Kiểm tra số lượng hợp lệ (>= 1)
            if (isNaN(newQty) || newQty < 1) {
                newQty = 1; // Mặc định về 1 nếu giá trị không hợp lệ
            }
            // Giới hạn số lượng tối đa là 999
            if(newQty > 999) {
                newQty = 999;
                alert("Số lượng tối đa là 999!");
            }
            // Cập nhật lại giá trị hiển thị và data-initial
            input.val(newQty);
            input.data('initial', newQty);
            var rowid = row.data('rowid');
            updateCart(rowid, newQty, row);
        });

        function updateCart(rowid, qty, row) {
            $.ajax({
                url: "{{ url('/update_cart') }}", // Đường dẫn cập nhật giỏ hàng
                method: 'POST',
                data: {
                    rowid: rowid,
                    qty: qty,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Cập nhật subtotal và các thông tin khác nếu cần
                        row.find('.subtotal').text(response.new_subtotal);
                        $('#total').text(response.total);
                        $('.total_include h4').text(response.total_final);
                    } else {
                        alert('Cập nhật giỏ hàng thất bại!');
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng!');
                }
            });
        }
    });

            $(document).on('click', '.cart-remove', function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var rowid = row.data('rowid');

            Swal.fire({
            title: 'Bạn chắc chắn?',
            text: "Bạn chắc chắn muốn bỏ sản phẩm này khỏi giỏ hàng chứ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e63946',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Có, xóa nó!',
            cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/remove_cart') }}", // Đường dẫn xử lý xóa sản phẩm khỏi giỏ hàng ở controller
                        method: 'POST',
                        data: {
                            rowid: rowid,
                            _token: '{{ csrf_token() }}'
                        },
                    success: function(response) {
                        if (response.success) {
                            // Xóa dòng sản phẩm khỏi giao diện
                            row.remove();
                            // Cập nhật lại tổng giỏ hàng nếu cần
                            $('#total').text(response.total);
                            Swal.fire(
                                'Đã xóa!',
                                'Sản phẩm đã được xóa khỏi giỏ hàng.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Thất bại!',
                                'Xóa sản phẩm thất bại!',
                                'error'
                            );
                        }
                    },
                        error: function() {
                            Swal.fire(
                            'Có lỗi!',
                            'Có lỗi xảy ra khi xóa sản phẩm!',
                            'error'
                        );
                    }
                });
            }
        });
    });
    
    $(document).ready(function(){
        $('#coupon_code').keypress(function(e) {
            if (e.which === 13) { // 13 là mã phím Enter
                e.preventDefault(); // Ngăn reload trang
                $('.check_coupon').click(); // Gọi sự kiện click của nút check_coupon
            }
        });

        $('.check_coupon').click(function(e){
            e.preventDefault(); // Ngăn trang reload
            var coupon_code = $('#coupon_code').val().trim(); // Lấy giá trị mã giảm giá
            if(coupon_code === '') {
                showMessage('<div class="alert alert-warning">Vui lòng nhập mã giảm giá!</div>');
                return;
            }

            $.ajax({
                url: "{{ url('/check_coupon') }}", // Đường dẫn tới route xử lý
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    coupon: coupon_code
                },
                beforeSend: function() {
                    $('.check_coupon').prop('disabled', true).text('Đang kiểm tra...'); // Vô hiệu hóa nút khi đang gửi request
                },
                success: function(response) {
                    if(response.status === 'success') {
                        showMessage('<div class="alert alert-success">'+ response.message +'</div>');
                        // Cập nhật Mã giảm (hiển thị % hoặc số tiền)
                        $('#coupon_value').text(response.coupon_value);
                        // Cập nhật tổng tiền sau giảm giá
                        $('.total_after_discount').text(response.total_after_discount + 'đ');
                        // Cập nhật tổng tiền bao gồm giảm giá
                        $('.total_include h4').text(response.total_after_discount + 'đ');
                        
                    } else {
                        showMessage('<div class="alert alert-danger">'+ response.message +'</div>');
                        $("#discount_value").html("<em>Không có mã</em>");
                        $("#total_after_discount").html("<em>Chưa áp dụng</em>");
                        $('.total_include').html(`
                            <h5>Tổng Tiền:</h5>
                        <h5>${response.total}đ</h5>
                        `);
                    }
                },
                error: function() {
                    showMessage('<div class="alert alert-danger">Có lỗi xảy ra!</div>');
                    $("#discount_value").html("<em>Không có mã</em>");
                    $("#total_after_discount").html("<em>Chưa áp dụng</em>");
                    $('.total_include').html(`
                            <h5>Tổng Tiền:</h5>
                        <h5>${response.total}đ</h5>
                        `);
                },
                complete: function() {
                    $('.check_coupon').prop('disabled', false).text('Tính Mã Giảm Giá'); // Bật lại nút sau khi xử lý xong
                }
            });
        });
        function showMessage(message) {
            $('#coupon_message').stop(true, true).html(message).fadeIn(); // Hiển thị lại nếu bị ẩn
            setTimeout(function() {
                $('#coupon_message').fadeOut();
            }, 5000);
        }
    });
    
    document.addEventListener("DOMContentLoaded", function () {
        let searchForm = document.getElementById("searchForm");
        let searchInput = document.getElementById("searchInput");
        let searchIcon = document.getElementById("searchIcon");

        // Khi nhấn Enter trong input
        searchInput.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Chặn form submit mặc định
                if (searchInput.value.trim() !== "") {
                    searchForm.submit(); // Chỉ submit nếu có nội dung
                }
            }
        });
        // Khi click vào icon tìm kiếm
        searchIcon.addEventListener("click", function () {
            if (searchInput.value.trim() !== "") {
                searchForm.submit();
            }
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.choose').on('change', function() {
            var action = $(this).attr('id');
            var maid = $(this).val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: "{{url('/checkout_delivery')}}",
                type: 'POST',
                data: { action: action, maid: maid, _token: _token },
                dataType: 'json',
                success: function(response) {
                    var result = (action == 'city') ? 'province' : 'ward';
                    $('#' + result).html(response.output);
                },
                error: function(xhr) {
                    console.log("Lỗi Ajax:", xhr.responseText);
                }
            });
        });

        $('.calculate_delivery').click(function() {
            var matp = $('.city').val();
            var maqh = $('.province').val();
            var xaid = $('.ward').val();
            var _token = $('meta[name="csrf-token"]').attr('content');

            if (matp == '' || maqh == '' || xaid == '') {
                alert('Hãy chọn đầy đủ địa chỉ để tính phí vận chuyển');
            } else {
                $.ajax({
                    url: "{{url('/calculate_feeship')}}",
                    type: "POST",
                    data: { matp: matp, maqh: maqh, xaid: xaid, _token: _token },
                    dataType: 'json',
                    success: function(data) {
                        if (data.feeship !== undefined) {
                            var feeship = parseInt(data.feeship) || 0; // Chuyển về số, nếu lỗi thì = 0
                            // Hiển thị phí vận chuyển hoặc "Chưa tính"
                            if (feeship > 0) {
                                $('.feeship_display').text(feeship.toLocaleString('vi-VN') + 'đ');
                            } else {
                                $('.feeship_display').html('<em>Chưa tính phí</em>');
                            }
                            // Lấy tổng tiền sau giảm giá, nếu không có mã giảm giá thì lấy tổng tiền gốc
                            var total_after_discount = parseInt($('.total_after_discount').text().replace(/\D/g, '')) || 
                                                    parseInt($('#total').attr('data-total').replace(/\D/g, '')) || 0;

                            var total_final = total_after_discount + feeship; // Cộng phí vận chuyển vào tổng sau giảm giá
                            
                            // Cập nhật tổng tiền mới
                            $('.total_include h4').text(total_final.toLocaleString('vi-VN') + 'đ');
                        }
                },
                error: function(xhr) {
                    console.log("Lỗi AJAX:", xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<script>
    const customerId = "{{ Session::get('customer_id') }}";

    document.querySelector('.btn-checkstore').addEventListener('click', function(e) {
        e.preventDefault();

        fetch("{{ url('/check_storage') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'error') {
                const errorMessages = data.messages.map(item => {
                    return `<li style="list-style-type: none; margin-bottom: 8px; color: #d9534f;">
                                Sản phẩm <strong><em>${item.book_name}</em></strong> chỉ còn <strong><em>${item.book_qty}</em></strong> cuốn trong kho.
                            </li>`;
                }).join('');

                Swal.fire({
                    title: '<h3 style="color: #d33;">Lỗi!</h3>',
                    html: `<div style="text-align: left;"><ul style="margin: 0; padding: 0;">${errorMessages}</ul></div>`,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            } else {
                // Kiểm tra customer_id để chuyển hướng đúng trang
                if (customerId) {
                    window.location.href = '{{ URL::to("/checkout") }}';
                } else {
                    window.location.href = '{{ URL::to("/login_checkout") }}';
                }
            }
        })
        .catch(error => console.error('Lỗi:', error));
    });
</script>

<script>
    $(document).ready(function () {
        var previousUrl = document.referrer; // Lấy URL trước khi vào trang login
    
        if (previousUrl) {
            $.ajax({
                url: "{{ url('/save_previous_url') }}", // Route để lưu session
                type: "POST",
                data: {
                    previous_url: previousUrl,
                    _token: "{{ csrf_token() }}" // Bảo vệ CSRF token
                },
                success: function (response) {
                    console.log("Lưu URL trước thành công:", response);
                },
                error: function () {
                    console.log("Lỗi khi lưu URL trước.");
                }
            });
        }
    });

    $(document).ready(function() {
        $('input[type="radio"]').on('click', function() {
            if ($(this).hasClass('checked')) {
                $(this).prop('checked', false).removeClass('checked');
            } else {
                $('input[type="radio"]').removeClass('checked'); // Xóa trạng thái checked của các radio khác
                $(this).addClass('checked');
            }
        });
    });

    $(document).ready(function() {
        $('#orderForm').submit(function(event) {
            event.preventDefault();
            var total_final = parseInt($('.total_final_display').text().replace(/\D/g, '')) || 0;
            var payment_option = $('input[name="payment_option"]:checked').val();

            if (!payment_option) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Vui lòng chọn phương thức thanh toán!'
                });
                return;
            }
            var formData = $(this).serialize();
            formData += '&total_final=' + total_final;

            Swal.fire({
                title: 'Bạn có chắc chắn muốn thanh toán?',
                text: "Hãy kiểm tra kỹ trước khi xác nhận!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có, tôi muốn thanh toán',
                cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ URL::to('/order_place') }}",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                if (response.payment_id == 2) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Đặt hàng thành công!',
                                        text: 'Đơn hàng của bạn đang được giao',
                                        confirmButtonText: 'Về trang chủ'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "{{ url('/trang_chu') }}";
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Đặt hàng thành công!',
                                        text: 'Bạn đã chọn phương thức thanh toán ngân hàng.'
                                    });
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra, vui lòng thử lại!'
                            });
                            console.log(xhr.responseText);
                        }
                    });
                }
            });

        });
    });


</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $('#error-message').html('');

        $.ajax({
            url: "{{ url('/login_customer') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    window.location.href = response.redirect_url; // Chuyển hướng khi đăng nhập thành công
                } else {
                    $('#error-message').html(response.error);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = '';
                    for (const key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorMessage += errors[key][0] + '<br>';
                        }
                    }
                    $('#error-message').html(errorMessage);
                }
            }
        });
    });
</script>
{{-- <script>
    $(document).ready(function() {
        $('.dropdown').hover(function() {
            $(this).children('.dropdown-menu').stop(true, true).slideDown(200);
        }, function() {
            $(this).children('.dropdown-menu').stop(true, true).slideUp(200);
        });
    });

    $(document).ready(function() {
    // Đối với các mục trong menu chính (nav-link)
    $('.nav-item .nav-link').click(function(e) {
        var link = $(this);
        
        console.log('Nav link clicked'); // Kiểm tra xem sự kiện có chạy không
        
        // Thêm lớp nháy màu danger
        link.addClass('flash-effect');
        
        // Chờ khi hiệu ứng nháy hoàn thành (0.5s), rồi chuyển trang
        setTimeout(function() {
            window.location.href = link.attr('href'); // Chuyển sang trang khác
        }, 500); // 500ms trùng với thời gian nháy
    });

    // Đối với các mục trong dropdown (dropdown-item)
    $(document).on('click', '.dropdown-item', function(e) {
        var item = $(this);

        console.log('Dropdown item clicked'); // Kiểm tra xem sự kiện có chạy không

        // Thêm lớp nháy màu danger khi click vào mục dropdown
        item.addClass('flash-effect');

        // Sau khi hiệu ứng hoàn thành (0.5s), tiếp tục thực hiện hành động khác (chuyển trang hoặc xử lý)
        setTimeout(function() {
            // Chuyển trang khi nhấn vào mục dropdown
            window.location.href = item.attr('href');
        }, 500); // Thời gian đồng bộ với thời gian nháy
    });
});
</script> --}}
<script>
$(document).ready(function() {
    let searchInput = $('#searchInput');

    searchInput.keyup(function(){
        var query = $(this).val().trim();
        var _token = $('meta[name="csrf-token"]').attr('content');

        if(query.length >= 2) {
            $.ajax({
                url: "{{ route('autocomplete.search') }}",
                type: "POST",
                data: { 
                    query: query, 
                    _token: _token 
                },
                success: function(data) {
                    if (data.html) {
                        $('#search_ajax').html(data.html).fadeIn();
                    } else {
                        $('#search_ajax').html('<ul><li class="text-danger">Không tìm thấy kết quả</li></ul>').fadeIn();
                    }
                },
                error: function(xhr) {
                    console.error("Lỗi AJAX:", xhr.responseText);
                    $('#search_ajax').html('<ul><li class="text-danger">Lỗi tải dữ liệu</li></ul>').fadeIn();
                }
            });
        } else {
            $('#search_ajax').fadeOut();
        }
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest("#searchInput, #search_ajax").length) {
            $('#search_ajax').fadeOut();
        }
    });

    $(document).on('click', '.search-item', function(){
        let fullName = $(this).data('fullname');
        searchInput.val(fullName);
        $('#search_ajax').fadeOut();
        $('#searchForm').submit();
    });
});
    $(document).on("mouseenter", ".search-item", function() {
        $(this).css({"background-color": "#dc3545", "color": "white", "cursor": "pointer"});
});
    $(document).on("mouseleave", ".search-item", function() {
        $(this).css({"background-color": "", "color": ""});
});
</script>
<script>
    $(document).ready(function() {
        load_comment();
        function load_comment(){
            var book_id = $('.comment_book_id').val();
            var _token = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: "{{ url('/load_comment') }}",
                type: "POST",
                data: { 
                    book_id: book_id, 
                    _token: _token 
                },
                success: function(data) {
                    $('#show_comment').html(data);
                }
            });
        }
        
        let selectedRating = $("#rating").val() || 0; // Mặc định là 0 nếu chưa có rating

        function updateStars(rating) {
            $(".star").each(function() {
                $(this).toggleClass("fas", $(this).data("value") <= rating && rating > 0);
                $(this).toggleClass("far", $(this).data("value") > rating || rating == 0);
            });
        }

        // Cập nhật sao theo giá trị rating đã lưu
        updateStars(selectedRating);

        // Khi hover vào sao
        $(".star").on("mouseenter", function() {
            let rating = $(this).data("value");
            updateStars(rating);
        });

        // Khi rời chuột
        $(".star").on("mouseleave", function() {
            updateStars(selectedRating);
        });

        // Khi click để chọn hoặc bỏ chọn sao
        $(".star").on("click", function() {
            let clickedValue = $(this).data("value");

            if (clickedValue == selectedRating) {
                selectedRating = 0; // Nếu click vào sao đã chọn, reset về 0
            } else {
                selectedRating = clickedValue; // Cập nhật giá trị rating mới
            }

            $("#rating").val(selectedRating); // Gán vào input ẩn
            updateStars(selectedRating); // Cập nhật giao diện
        });
        
        $('.send_comment').click(function(){
            var book_id = $('.comment_book_id').val();
            var comment_name = $('.comment_name').val();
            var comment_content = $('.comment_content').val();
            var rating = $(".rating_value").val();
            var _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ url('/send_comment') }}",
                type: "POST",
                data: { 
                    book_id: book_id, 
                    comment_name: comment_name, 
                    comment_content: comment_content, 
                    rating: rating, _token: _token 
                },
                success: function(data) {
                    Swal.fire({
                    title: "Thành công!",
                    text: "Bình luận của bạn đã được gửi và đang chờ duyệt!",
                    icon: "success",
                    confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            load_comment();
                            $('.comment_content').val('');
                            $('.comment_name').val('');
                        }
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Lỗi!",
                        text: "Có lỗi xảy ra, vui lòng thử lại.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        });
    });

    
</script>
</body>
</html>