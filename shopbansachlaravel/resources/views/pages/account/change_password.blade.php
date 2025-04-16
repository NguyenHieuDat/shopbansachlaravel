@extends('welcome')
@section('content')
<div class="container">
    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Đổi mật khẩu</span></h5>
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="bg-light p-30 mb-5">
        <form action="{{ url('/change_password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                @error('current_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Mật khẩu mới</label>
                @error('new_password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                @error('new_password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Đổi mật khẩu</button>
        </form>
    </div>
</div>
@endsection
