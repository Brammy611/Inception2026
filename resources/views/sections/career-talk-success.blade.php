@extends('layouts.app')

@section('title', 'Registrasi Berhasil - Inception 2026')

@section('content')
<section class="success-section">
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    
    <div class="container-custom">
        <div class="success-wrapper">
            <div class="success-animation">
                <div class="success-checkmark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
            </div>

            <div class="success-content">
                <h1>Pendaftaran Berhasil! 🎉</h1>
                <p class="success-message">
                    Terima kasih telah mendaftar Career Talk Inception 2026. Kami akan mengirimkan email konfirmasi beserta detail acara ke alamat email yang kamu daftarkan.
                </p>

                <div class="next-steps">
                    <h3>Langkah Selanjutnya:</h3>
                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-number">1</div>
                            <h4>Cek Email</h4>
                            <p>Konfirmasi pendaftaran akan dikirim dalam 24 jam</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">2</div>
                            <h4>Join Grup WhatsApp</h4>
                            <p>Scan QR Code di bawah atau klik tombol untuk bergabung</p>
                        </div>
                        <div class="step-card">
                            <div class="step-number">3</div>
                            <h4>Hadiri Acara</h4>
                            <p>Datang tepat waktu di hari H</p>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Group Section -->
                <div class="whatsapp-group-section">
                    <div class="whatsapp-header">
                        <div class="wa-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <h3>Join Grup WhatsApp Career Talk</h3>
                        <p>Bergabunglah dengan peserta lainnya untuk mendapatkan update terbaru!</p>
                    </div>

                    <div class="qr-code-container">
                        <div class="qr-code-wrapper">
                            <img src="{{ asset('assets/images/qrgrupct.png') }}" alt="QR Code WhatsApp Group Career Talk" class="qr-code-image">
                        </div>
                        <p class="qr-instruction">Scan QR Code dengan kamera WhatsApp</p>
                    </div>

                    <div class="wa-divider">
                        <span>atau</span>
                    </div>

                    <a href="https://chat.whatsapp.com/KqOOvLf0gYR2T7yZehCus0" target="_blank" class="wa-join-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Klik Untuk Join Grup WhatsApp
                    </a>

                    <div class="group-info">
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            Grup ini khusus untuk peserta Career Talk Inception 2026
                        </p>
                    </div>
                </div>

                <div class="success-actions">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('career-talk') }}" class="btn btn-secondary">
                        Lihat Detail Acara
                    </a>
                </div>

                <div class="contact-info">
                    <p>Jika ada pertanyaan, hubungi kami:</p>
                    <div class="contact-links">
                        <a href="mailto:info@inception2026.com">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            info@inception2026.com
                        </a>
                        <a href="https://wa.me/628123456789" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            +62 812-3456-789
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection