@extends('welcome')
@section('content')
<!-- Contact Start -->
<div class="container-fluid">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Liên hệ với chúng tôi</span></h2>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form bg-light p-30">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ url('/send_contact') }}" method="POST">
                    @csrf
                    <div class="control-group mb-3">
                        @error('contact_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="text" name="contact_name" class="form-control" placeholder="Họ và Tên" 
                            value="{{ old('contact_name') }}" required>
                    </div>
                    <div class="control-group mb-3">
                        @error('contact_email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="email" name="contact_email" class="form-control" placeholder="Email của bạn" 
                            value="{{ old('contact_email') }}" required>
                    </div>
                    <div class="form-group mb-3">
                        @error('contact_phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="text" name="contact_phone" class="form-control" placeholder="Số điện thoại" 
                            value="{{ old('contact_phone') }}" required>
                    </div>
                    <div class="control-group mb-3">
                        @error('contact_subject')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="text" name="contact_subject" class="form-control" placeholder="Tiêu đề" required>
                    </div>
                    <div class="control-group mb-3">
                        @error('contact_message')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <textarea name="contact_message" class="form-control" rows="5" placeholder="Nội dung" required></textarea>
                    </div>                    
                    <div>
                        <button class="btn btn-danger py-2 px-4" type="submit">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <div class="bg-light p-30 mb-30">
                <iframe style="width: 100%; height: 250px;"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.9662895070733!2d106.6826392!3d20.8330677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7188ccdc676f%3A0x69aa50a71a532a62!2zTmjDoCBTw6FjaCBGQUhBU0EgSOG6o2kgUGjDsm5n!5e0!3m2!1svi!2s!4v1743493448907!5m2!1svi!2s"
                frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                
            </div>
            <div class="bg-light p-30 mb-3">
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Số 10 Võ Nguyên Giáp, Kênh Dương, Lê Chân, Hải Phòng 05000, Việt Nam</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>toramhatsunemiku69@gmail.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+84 936 5494 42</p>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->
@endsection