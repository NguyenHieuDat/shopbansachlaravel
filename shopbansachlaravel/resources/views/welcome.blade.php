<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Nhà sách Fahasa</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="public/frontend/img/favicon.ico" rel="icon">

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
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
              
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Tài Khoản</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Đăng Nhập</button>
                            <button class="dropdown-item" type="button">Đăng Ký</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Tiếng Việt</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Tiếng Anh</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <img src="{{asset('public/frontend/img/fahasa-logo.jpeg')}}" alt="Logo" style="height: 50px; max-width: 100%; object-fit: contain;">
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm Kiếm Sách">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-danger">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Liên hệ với chúng tôi!</p>
                <h5 class="m-0">+012 345 6789</h5>
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
                        <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Thể loại<i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                @foreach ($category as $key => $cate)
                                <a href="{{URL::to('/danh_muc_sach/'.$cate->category_id)}}" class="dropdown-item">{{$cate->category_name}}</a>
                                @endforeach
                            </div>
                        </div>

                            <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Tác giả<i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                @foreach ($author as $key => $aut)
                                <a href="{{URL::to('/danh_muc_tac_gia/'.$aut->author_id)}}" class="dropdown-item">{{$aut->author_name}}</a>
                                @endforeach
                            </div>
                        </div>

                        <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Nhà xuất bản<i class="fa fa-angle-right float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                @foreach ($publisher as $key => $pub)
                                <a href="{{URL::to('/danh_muc_nha_xb/'.$pub->publisher_id)}}" class="dropdown-item">{{$pub->publisher_name}}</a>
                                @endforeach
                            </div>
                        </div>

                            <a href="" class="nav-item nav-link">Shirts</a>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-danger navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{URL::to('/trang_chu')}}" class="nav-item nav-link text-light active">Trang Chủ</a>
                            <a href="shop.html" class="nav-item nav-link text-light">Cửa Hàng</a>
                            <a href="{{URL::to('/gio_hang')}}" class="nav-item nav-link text-light">Giỏ Hàng</a>
                            <a href="checkout.html" class="nav-item nav-link text-light">Thanh Toán</a>
                            <a href="contact.html" class="nav-item nav-link text-light">Liên Hệ</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-light"></i>
                                <span class="badge text-light border border-light rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="{{URL::to('/gio_hang')}}" class="btn px-0 ml-3">
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

    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 300px;">
                            <img class="position-absolute w-100 h-100" src="{{asset('public/frontend/img/banner-1.jpg')}}" style="object-fit: cover;">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 300px;">
                            <img class="position-absolute w-100 h-100" src="{{asset('public/frontend/img/banner-2.jpg')}}" style="object-fit: cover;">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 300px;">
                            <img class="position-absolute w-100 h-100" src="{{asset('public/frontend/img/banner-3.jpg')}}" style="object-fit: cover;">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                
                            </div>
                        </div>
                        <!-- Nút chuyển bên trái -->
                        <a class="carousel-control-prev custom-carousel-control" href="#header-carousel" role="button" data-slide="prev">
                            <i class="fa-solid fa-circle-chevron-left"></i>
                        </a>

                        <!-- Nút chuyển bên phải -->
                        <a class="carousel-control-next custom-carousel-control" href="#header-carousel" role="button" data-slide="next">
                            <i class="fa-solid fa-circle-chevron-right"></i>
                        </a>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 135px;">
                    <img class="img-fluid" src="{{asset('public/frontend/img/sub-banner-1.jpg')}}" alt="">
                    
                </div>
                <div class="product-offer mb-30" style="height: 135px;">
                    <img class="img-fluid" src="{{asset('public/frontend/img/sub-banner-2.jpg')}}" alt="">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('public/frontend/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('public/frontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{asset('public/frontend/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{asset('public/frontend/mail/contact.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('public/frontend/js/main.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

    $(document).ready(function(){
    console.log("Initial input value:", $('.quantity-input').val());
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
        $('.check_coupon').click(function(e){
            e.preventDefault(); // Ngăn trang reload

            var coupon_code = $('#coupon_code').val(); // Lấy giá trị mã giảm giá

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
                    } else {
                        showMessage('<div class="alert alert-danger">'+ response.message +'</div>');
                    }
                },
                error: function() {
                    showMessage('<div class="alert alert-danger">Có lỗi xảy ra!</div>');
                },
                complete: function() {
                    $('.check_coupon').prop('disabled', false).text('Tính Mã Giảm Giá'); // Bật lại nút sau khi xử lý xong
                }
            });
        });

        function showMessage(message) {
            $('#coupon_message').stop(true, true).html(message).fadeIn(); // Hiển thị lại nếu bị ẩn
            setTimeout(function() {
                $('#coupon_message').fadeOut(); // Ẩn sau 6 giây
            }, 6000);
        }
    });
    </script>
    
</body>

</html>