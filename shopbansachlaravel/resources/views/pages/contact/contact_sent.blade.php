<!DOCTYPE html>
<html>
<head>
    <title>Thông báo liên hệ</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd;">
        <h1 style="color: #2d3748;">📬 Liên hệ mới từ khách hàng của Cửa hàng sách Fahasa</h1>
        <h2><strong>Tiêu đề chính: </strong> {{ $contact['contact_subject'] }}</h2>
        <div style="background: #f7fafc; padding: 15px; border-radius: 5px;">
            <p><strong>Tên khách hàng: </strong> {{ $contact['contact_name'] }}</p>
            <p><strong>Email: </strong> {{ $contact['contact_email'] }}</p>
            <p><strong>Số điện thoại: </strong> {{ $contact['contact_phone'] }}</p>
            <p><strong>Nội dung: </strong> {{ $contact['contact_message'] }}</p>
        </div>
    </div>
</body>
</html>