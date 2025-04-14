@extends('welcome')
@section('content')
<div class="container mt-5">
    <h4>Quên mật khẩu</h4>
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session()->get('message') }}</div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif
    <form action="{{ url('/send_password') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email_account">Nhập địa chỉ email của bạn để lấy lại mật khẩu</label>
            <input type="email" name="email_account" class="form-control" required placeholder="Nhập địa chỉ Email" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-danger mt-3">Gửi liên kết</button>
    </form>
</div>
@endsection
