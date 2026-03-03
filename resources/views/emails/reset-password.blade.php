<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Inception 2026</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            margin: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #FBB137 0%, #B22A2A 50%, #4683B5 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 16px;
            opacity: 0.95;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #32477C;
            margin-bottom: 20px;
        }
        .message {
            font-size: 15px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
        }
        .btn-reset {
            display: inline-block;
            background: linear-gradient(135deg, #FBB137 0%, #B22A2A 100%);
            color: white !important;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
        }
        .btn-reset:hover {
            opacity: 0.9;
        }
        .center {
            text-align: center;
        }
        .warning-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px 20px;
            border-radius: 0 8px 8px 0;
            margin: 25px 0;
        }
        .warning-box p {
            margin: 0;
            font-size: 14px;
            color: #856404;
        }
        .info-text {
            font-size: 13px;
            color: #888;
            margin-top: 20px;
        }
        .footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #888;
        }
        .footer .brand {
            font-weight: 700;
            color: #32477C;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>INCEPTION 2026</h1>
            <p>Reset Password</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">Halo!</p>
            
            <p class="message">
                Anda menerima email ini karena kami menerima permintaan reset password untuk akun Inception Anda.
            </p>

            <div class="center">
                <a href="{{ $resetLink }}" class="btn-reset">Reset Password</a>
            </div>

            <div class="warning-box">
                <p><strong>Penting:</strong> Link reset password ini akan expired dalam <strong>1 jam</strong>. Segera lakukan reset password sebelum link kadaluarsa.</p>
            </div>

            <p class="message">
                Jika Anda tidak meminta reset password, abaikan email ini dan password Anda akan tetap sama seperti sebelumnya.
            </p>

            <p class="info-text">
                Jika tombol di atas tidak berfungsi, copy dan paste link berikut ke browser Anda:<br>
                <a href="{{ $resetLink }}" style="color: #4683B5; word-break: break-all;">{{ $resetLink }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="brand">INCEPTION 2026</p>
            <p>Industrial Engineering Competition and Exhibition</p>
            <p>&copy; {{ date('Y') }} Inception. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
