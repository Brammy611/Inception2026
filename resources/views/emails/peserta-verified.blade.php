<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Diverifikasi - Inception 2026</title>
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
        .verified-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: center;
        }
        .verified-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .verified-text {
            color: white;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
        }
        .info-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
        }
        .info-title {
            font-size: 18px;
            font-weight: 700;
            color: #32477C;
            margin-bottom: 15px;
            border-bottom: 2px solid #FBB137;
            padding-bottom: 10px;
        }
        .info-item {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #666;
            min-width: 120px;
        }
        .info-value {
            color: #333;
            flex: 1;
        }
        .whatsapp-section {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            text-align: center;
        }
        .whatsapp-title {
            color: white;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .whatsapp-text {
            color: rgba(255,255,255,0.95);
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .whatsapp-button {
            display: inline-block;
            background: white;
            color: #128C7E;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .whatsapp-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .important-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
        }
        .important-title {
            font-weight: 700;
            color: #856404;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .important-text {
            color: #856404;
            font-size: 14px;
            line-height: 1.6;
        }
        .important-text ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .important-text li {
            margin: 5px 0;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .footer-text {
            color: #666;
            font-size: 13px;
            margin: 5px 0;
        }
        .footer-link {
            color: #4683B5;
            text-decoration: none;
        }
        .footer-link:hover {
            text-decoration: underline;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #666;
            text-decoration: none;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 INCEPTION 2026 🎉</h1>
            <p>International Petroleum Engineering Competition</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $leaderName }}!
            </div>

            <div class="verified-badge">
                <div class="verified-icon">✓</div>
                <div class="verified-text">PENDAFTARAN TERVERIFIKASI</div>
            </div>

            <div class="message">
                Selamat! Kami dengan senang hati mengumumkan bahwa pendaftaran tim Anda untuk <strong>{{ $category }}</strong> telah <strong>berhasil diverifikasi</strong> oleh tim kami.
            </div>

            <!-- Team Information -->
            <div class="info-section">
                <div class="info-title">📋 Informasi Tim</div>
                <div class="info-item">
                    <div class="info-label">Nama Tim:</div>
                    <div class="info-value"><strong>{{ $teamName }}</strong></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kategori:</div>
                    <div class="info-value">{{ $category }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Leader:</div>
                    <div class="info-value">{{ $leaderName }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Universitas:</div>
                    <div class="info-value">{{ $university }}</div>
                </div>
            </div>

            <!-- WhatsApp Group -->
            <div class="whatsapp-section">
                <div class="whatsapp-title">📱 Bergabung dengan Grup WhatsApp</div>
                <div class="whatsapp-text">
                    Segera bergabung dengan grup WhatsApp peserta untuk mendapatkan informasi terbaru, 
                    pengumuman penting, dan berkomunikasi dengan tim panitia serta peserta lainnya.
                </div>
                <a href="{{ $whatsappLink }}" class="whatsapp-button" target="_blank">
                    Join Grup WhatsApp
                </a>
            </div>

            <!-- Important Information -->
            <div class="important-box">
                <div class="important-title">⚠️ Informasi Penting</div>
                <div class="important-text">
                    <ul>
                        <li>Pastikan untuk bergabung dengan grup WhatsApp untuk mendapatkan update terkini</li>
                        <li>Periksa email secara berkala untuk informasi lebih lanjut mengenai kompetisi</li>
                        <li>Simpan email ini sebagai bukti verifikasi pendaftaran Anda</li>
                        <li>Jika ada pertanyaan, jangan ragu untuk menghubungi kami</li>
                    </ul>
                </div>
            </div>

            <div class="message">
                Terima kasih atas partisipasi Anda dalam <strong>Inception 2026</strong>. 
                Kami sangat menantikan kontribusi dan performa terbaik dari tim Anda!
            </div>

            <div class="message" style="margin-top: 30px;">
                <strong>Salam Hangat,</strong><br>
                <strong>Tim Panitia Inception 2026</strong><br>
                Himpunan Mahasiswa Teknik Perminyakan<br>
                Universitas Diponegoro
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="footer-text">
                <strong>Inception 2026</strong><br>
                International Petroleum Engineering Competition
            </p>
            <p class="footer-text">
                Email: <a href="mailto:inceptionundip@gmail.com" class="footer-link">inceptionundip@gmail.com</a><br>
                Website: <a href="https://inception2026.com" class="footer-link" target="_blank">inception2026.com</a>
            </p>
            <div class="social-links">
                <a href="#" class="social-link">Instagram</a> |
                <a href="#" class="social-link">LinkedIn</a> |
                <a href="#" class="social-link">Twitter</a>
            </div>
            <p class="footer-text" style="margin-top: 20px; color: #999;">
                Email ini dikirim secara otomatis, mohon untuk tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
