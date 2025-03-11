@extends('welcome')

@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Cấu trúc chính */
        #form {
            background-color: #f8d7da;
            padding: 50px 0;
        }
        .login-container {
            max-width: 900px;
            margin: auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        /* Ô nhập */
        .form-control {
            border-radius: 5px;
            border: 1px solid #dc3545;
        }
        /* Nút */
        .btn-danger {
            background-color: #dc3545;
            border: none;
            transition: 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .or-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        }
        .or-circle {
            width: 70px !important;
            height: 70px !important;
            background-color: #dc3545 !important; /* Màu đỏ */
            color: white !important; /* Chữ trắng */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 50% !important; /* Bo góc thành hình tròn */
            font-size: 14px !important;
            font-weight: bold !important;
            text-transform: uppercase !important;
            text-align: center !important;
        }
    </style>
@endsection

@section('content')
<section id="form">
    <div class="container">
        <div class="login-container">
            <div class="row align-items-center">
                <!-- Đăng nhập -->
                <div class="col-md-5">
                    <div class="login-form">
                        <h2 class="text-danger text-center mb-4">Đăng nhập</h2>
                        <form action="{{URL::to('/login_customer')}}" method="POST" id="loginForm">
                            @csrf
                            <div id="error-message" style="color: red; margin-top: 10px;"></div>
                            <div class="mb-3">
                                <input type="text" name="email_account" class="form-control" placeholder="Nhập tài khoản">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password_account" class="form-control" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="keepSignedIn">
                                <label class="form-check-label" for="keepSignedIn">Ghi nhớ đăng nhập</label>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Đăng nhập</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 d-flex flex-column align-items-center or-container">
                    <div style="width: 70px; height: 70px; background-color: #dc3545 !important; color: white !important; display: flex !important; align-items: center !important; justify-content: center !important; border-radius: 50% !important; font-size: 14px !important; font-weight: bold !important; text-transform: uppercase !important; text-align: center !important;">
                        HOẶC
                    </div>
                </div>
                <!-- Đăng ký -->
                <div class="col-md-5">
                    <div class="signup-form">
                        <h2 class="text-danger text-center mb-4">Đăng ký</h2>
                        <form action="{{URL::to('/add_customer')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="customer_name" class="form-control" placeholder="Nhập tên tài khoản">
                            </div>
                            <div class="mb-3">
                                <input type="email" name="customer_email" class="form-control" placeholder="Nhập địa chỉ Email">
                            </div>
                            <div class="mb-3">
                                <input type="password" name="customer_password" class="form-control" placeholder="Nhập mật khẩu">
                            </div>
                            <div class="mb-3">
                                <input type="text" name="customer_phone" class="form-control" placeholder="Nhập số điện thoại">
                            </div>
                            <button type="submit" class="btn btn-danger w-100">Đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
