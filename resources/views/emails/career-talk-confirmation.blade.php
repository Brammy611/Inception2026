<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Registrasi Career Talk</title>
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
        .registration-box {
            background: linear-gradient(135deg, #FBB137 0%, #B22A2A 100%);
            padding: 20px;
            border-radius: 10px;
            margin: 30px 0;
            text-align: center;
        }
        .registration-label {
            color: rgba(255,255,255,0.9);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .registration-number {
            color: white;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
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
        .event-details {
            background: linear-gradient(135deg, rgba(251, 177, 55, 0.1) 0%, rgba(70, 131, 181, 0.1) 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            border-left: 4px solid #FBB137;
        }
        .event-details h3 {
            color: #32477C;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .event-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        .event-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }
        .event-text strong {
            display: block;
            color: #333;
            font-size: 14px;
            margin-bottom: 2px;
        }
        .event-text span {
            color: #666;
            font-size: 13px;
        }
        .checklist {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            margin: 25px 0;
            border: 2px solid #FBB137;
        }
        .checklist h3 {
            color: #32477C;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .checklist-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        .checklist-icon {
            color: #FBB137;
            font-size: 20px;
            margin-right: 12px;
            margin-top: 2px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #FBB137 0%, #B22A2A 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(251, 177, 55, 0.3);
        }
        .footer {
            background: #32477C;
            padding: 30px;
            text-align: center;
            color: white;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
        }
        .footer a {
            color: #FBB137;
            text-decoration: none;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: white;
            text-decoration: none;
            font-size: 14px;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
            }
            .content {
                padding: 25px 20px;
            }
            .info-item {
                flex-direction: column;
            }
            .info-label {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🚀 INCEPTION 2026</h1>
            <p>Career Talk Registration Confirmed</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $fullName }}! 👋
            </div>

            <div class="message">
                Terima kasih telah mendaftar <strong>Career Talk Inception 2026</strong>! Kami sangat senang Anda akan bergabung dengan kami dalam acara yang inspiratif ini.
            </div>

            <!-- Registration Number -->
            <div class="registration-box">
                <div class="registration-label">Nomor Registrasi Anda</div>
                <div class="registration-number">{{ $registrationNumber }}</div>
            </div>

            <div class="message">
                <strong>Simpan nomor registrasi ini dengan baik!</strong> Anda akan memerlukan nomor ini untuk check-in di hari acara.
            </div>

            <!-- Registration Info -->
            <div class="info-section">
                <div class="info-title">📋 Data Registrasi Anda</div>
                <div class="info-item">
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $fullName }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">WhatsApp</div>
                    <div class="info-value">{{ $phone }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Institusi</div>
                    <div class="info-value">{{ $institution }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Program Studi</div>
                    <div class="info-value">{{ $major }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Semester</div>
                    <div class="info-value">{{ $semester }}</div>
                </div>
            </div>

            <!-- Event Details -->
            <div class="event-details">
                <h3>📅 Detail Acara</h3>
                <div class="event-item">
                    <div class="event-icon">📆</div>
                    <div class="event-text">
                        <strong>Tanggal</strong>
                        <span>Sabtu, 15 Februari 2026</span>
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-icon">⏰</div>
                    <div class="event-text">
                        <strong>Waktu</strong>
                        <span>08:00 - 16:00 WIB</span>
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-icon">📍</div>
                    <div class="event-text">
                        <strong>Lokasi</strong>
                        <span>Auditorium Universitas Diponegoro</span>
                    </div>
                </div>
                <div class="event-item">
                    <div class="event-icon">👔</div>
                    <div class="event-text">
                        <strong>Dress Code</strong>
                        <span>Business Casual</span>
                    </div>
                </div>
            </div>

            <!-- Checklist -->
            <div class="checklist">
                <h3>✅ Yang Perlu Anda Persiapkan</h3>
                <div class="checklist-item">
                    <div class="checklist-icon">✓</div>
                    <div>
                        <strong>Join Grup WhatsApp</strong><br>
                        Link grup akan dikirimkan 3 hari sebelum acara
                    </div>
                </div>
                <div class="checklist-item">
                    <div class="checklist-icon">✓</div>
                    <div>
                        <strong>Catat Nomor Registrasi</strong><br>
                        Screenshot atau simpan email ini untuk check-in
                    </div>
                </div>
                <div class="checklist-item">
                    <div class="checklist-icon">✓</div>
                    <div>
                        <strong>Siapkan Pertanyaan</strong><br>
                        Akan ada sesi Q&A dengan para pembicara
                    </div>
                </div>
                <div class="checklist-item">
                    <div class="checklist-icon">✓</div>
                    <div>
                        <strong>Datang Tepat Waktu</strong><br>
                        Registrasi dibuka mulai pukul 08:00 WIB
                    </div>
                </div>
            </div>

            <div class="message">
                Jika ada pertanyaan atau perlu bantuan, jangan ragu untuk menghubungi kami melalui:
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <p style="margin: 10px 0;">
                    📧 Email: <a href="mailto:info@inception2026.com" style="color: #FBB137;">info@inception2026.com</a>
                </p>
                <p style="margin: 10px 0;">
                    💬 WhatsApp: <a href="https://wa.me/628123456789" style="color: #FBB137;">+62 812-3456-789</a>
                </p>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/career-talk') }}" class="cta-button">
                    Lihat Detail Acara
                </a>
            </div>

            <div class="message" style="margin-top: 30px; text-align: center; font-style: italic; color: #888;">
                Kami tidak sabar untuk bertemu dengan Anda di Career Talk! 🎉
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>INCEPTION 2026</strong></p>
            <p>Showcase of Creativity, Innovation, and Technology</p>
            <p style="margin-top: 15px; font-size: 13px;">
                Organized by SPE UNDIP SC & SRE UNDIP
            </p>
            <div class="social-links">
                <a href="#">Instagram</a> | 
                <a href="#">LinkedIn</a> | 
                <a href="#">Website</a>
            </div>
            <p style="margin-top: 20px; font-size: 12px; opacity: 0.8;">
                © 2026 Inception. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>