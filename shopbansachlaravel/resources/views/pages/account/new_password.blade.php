@extends('welcome')
@section('content')
<div class="container mt-5">
    <h4>Khôi phục mật khẩu</h4>
    @if(session()->has('message'))
        <div class="alert alert-success">{{ session()->get('message') }}</div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger">{{ session()->get('error') }}</div>
    @endif

    @php
        $token = $_GET['token'];
        $email = $_GET['email'];
    @endphp
    <form action="{{ url('/reset_password') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="email_account">Nhập mật khẩu mới</label>
            <input type="hidden" name="email" value="{{$email}}">
            <input type="hidden" name="token" value="{{$token}}">
            <input type="text" name="password_account" class="form-control" required placeholder="Nhập mật khẩu mới" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-danger mt-3">Khôi phục</button>
    </form>
</div>
@endsection
