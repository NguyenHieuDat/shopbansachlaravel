<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khôi phục mật khẩu</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        @if(session('message') || isset($message))
            Swal.fire({
                icon: 'success',
                title: 'Khôi phục mật khẩu thành công!',
                text: '{{ session("message") ?? $message }}',
                confirmButtonText: 'Đăng nhập',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('login_checkout') }}";
                }
            });
        @elseif(session('error') || isset($error))
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: '{{ session("error") ?? $error }}',
                confirmButtonText: 'Vui lòng thử lại',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('quen_mat_khau') }}";
                }
            });
        @endif
    </script>
</body>
</html>
