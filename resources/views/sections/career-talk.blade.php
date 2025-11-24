@extends('layouts.app')

@section('title', 'Career Talk - Inception 2026')

@section('content')
<!-- Hero Section -->
<section class="career-hero">
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    
    <div class="career-hero-content">
        <div class="hero-badge">INCEPTION 2026</div>
        <h1 class="hero-title">Career Talk</h1>
        <p class="hero-subtitle">"Igniting Careers, Shaping a Sustainable Future"</p>
        <div class="hero-info">
            <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <span>30 November 2025</span>
            </div>
            <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>09:00 - 13:00 WIB</span>
            </div>
            <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <span>Zoom Online</span>
            </div>
        </div>
        <a href="{{ route('career-talk.register') }}" class="cta-button-hero">
            Daftar Sekarang
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
    </div>
</section>

<!-- About Event -->
<section class="career-about">
    <div class="container-custom">
        <div class="section-header-center">
            <h2 class="heading">Tentang Career Talk</h2>
            <p class="section-description">
                Career Talk Inception 2026 adalah talkshow interaktif yang menghadirkan profesional dari industri energi dan sektor terkait untuk berbagi pengalaman, wawasan, dan strategi membangun karier di era transisi energi. Melalui diskusi dan tanya jawab, peserta akan memahami tren dunia kerja, keterampilan masa depan, serta peluang karier di bidang energi, teknologi, dan keberlanjutan. Kegiatan ini juga menjadi ruang bagi mahasiswa dan fresh graduate untuk memperluas jejaring dan mempersiapkan diri memasuki dunia profesional.
            </p>
        </div>

        <div class="benefits-grid">
            @foreach($benefits as $benefit)
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <p>{{ $benefit }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Speakers -->
<section class="speakers-section">
    <div class="container-custom">
        <div class="section-header-center">
            <h2 class="heading">Pembicara Kami</h2>
            <p class="section-description">Belajar dari para ahli industri dengan pengalaman bertahun-tahun</p>
        </div>

        <div class="speakers-grid">
            @foreach($speakers as $speaker)
            <div class="speaker-card">
                <div class="speaker-image-wrapper">
                    <img src="{{ asset('assets/images/' . $speaker['image']) }}" alt="{{ $speaker['name'] }}" class="speaker-image" onerror="this.src='{{ asset('assets/images/logo.png') }}'">
                    <div class="speaker-overlay"></div>
                </div>
                <div class="speaker-info">
                    <h3>{{ $speaker['name'] }}</h3>
                    <p class="speaker-position">{{ $speaker['position'] }}</p>
                    <p class="speaker-company">{{ $speaker['company'] }}</p>
                    <p class="speaker-bio">{{ $speaker['bio'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Schedule -->
<section class="schedule-section">
    <div class="container-custom">
        <div class="section-header-center">
            <h2 class="heading">Jadwal Acara</h2>
            <p class="section-description">Rangkaian kegiatan Career Talk yang dikemas secara menarik</p>
        </div>

        <div class="schedule-timeline">
            @foreach($schedule as $index => $item)
            <div class="schedule-item" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="schedule-time">{{ $item['time'] }}</div>
                <div class="schedule-connector"></div>
                <div class="schedule-content">
                    <h4>{{ $item['activity'] }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container-custom">
        <div class="cta-box">
            <h2>Siap Mengembangkan Karirmu?</h2>
            <p>Jangan lewatkan kesempatan emas ini untuk mendapatkan insight berharga dari para profesional!</p>
            <div class="cta-buttons">
                <a href="{{ route('career-talk.register') }}" class="cta-button primary">
                    Daftar Sekarang
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="{{ route('home') }}#contact" class="cta-button secondary">Hubungi Kami</a>
            </div>
        </div>
    </div>
</section>
@endsection