<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đăng ký tài khoản</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; line-height: 1.6;">
        <h2 style="color: #d9534f;">Xin chào {{ $data['name'] }},</h2><br>
        <p>Bạn vừa đăng ký tài khoản tại website của <strong>Cửa hàng sách Fahasa</strong>.</p><br>
        <p>Vui lòng nhấn vào nút bên dưới để xác nhận email và hoàn tất đăng ký:</p><br>
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $data['verify_url'] }}" 
               style="padding: 10px 20px; background-color: #d9534f; color: #fff; text-decoration: none; border-radius: 5px;">
                Xác nhận đăng ký
            </a>
        </p><br>
        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p><br>
        <p>Trân trọng,<br>Đội ngũ Fahasa</p>
    </div>
</body>
</html>
