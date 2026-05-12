@extends('layouts.app')

@section('title', 'Company Visit - Inception 2026')

@section('content')
<!-- Hero Section -->
<section class="career-hero company-visit-hero">
    <div class="hero-background-overlay"></div>
    
    <div class="career-hero-content">
        <h1 class="hero-title company-visit-title">COMPANY VISIT</h1>
        <p class="hero-subtitle">"From Classroom to Industry: Preparing Future<br>Leaders for Energy Sustainability"</p>
        <a href="{{ $googleFormUrl }}" target="_blank" class="cta-button-hero">
            Register
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </a>
    </div>
</section>

<!-- About Company Visit -->
<section class="career-about">
    <div class="container-custom">
        <div class="section-header-center">
            <h2 class="section-title-competitions">About inception<br>Company Visit</h2>
            <p class="section-description">
                Company Visit INCEPTION 2026 will be conducted as an on-site visit to energy companies operating in the energy sector. This program is designed to provide participants with a comprehensive understanding of the industrial world, work culture, and innovations supporting the transition to sustainable energy. Participants will attend company presentations, facility or departmental tours, and interactive Q&A sessions that connect academic knowledge with real experience, helping shape the next generation of students' professional relevance.
            </p>
        </div>
    </div>
</section>

<!-- Pertamina Balongan Section -->
<section class="career-about" style="background: padding: 60px 0;">
    <div class="container-custom">
        <!-- Tab Buttons -->
        <div style="margin-bottom: 40px; text-align: center;">
            <button class="tab-button active" onclick="switchTab('company')" id="companyTab" style="
                background: linear-gradient(135deg, #E97132 0%, #ff8a4d 100%);
                color: white;
                border: none;
                padding: 12px 35px;
                border-radius: 25px;
                font-size: 15px;
                font-weight: 600;
                margin-right: 15px;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(233, 113, 50, 0.3);
            ">COMPANY</button>
            <button class="tab-button" onclick="switchTab('requirement')" id="requirementTab" style="
                background: #e2e8f0;
                color: #64748b;
                border: none;
                padding: 12px 35px;
                border-radius: 25px;
                font-size: 15px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            ">REQUIREMENT</button>
        </div>

        <!-- Content Container -->
        <div style="
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 3px solid #FBB137;
        ">
            <div style="display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
                <!-- Left: Image -->
                <div style="flex: 0 0 auto; width: 100%; max-width: 400px;">
                    <div style="position: relative; overflow: hidden; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                        <img src="{{ asset('assets/images/balongan.png') }}" alt="Pertamina Balongan" style="width: 100%; height: auto; display: block;" onerror="this.src='{{ asset('assets/images/logo.png') }}'">
                    </div>
                </div>
                
                <!-- Right: Content -->
                <div style="flex: 1; min-width: 300px;">
                    <!-- Company Content -->
                    <div id="companyContent" class="tab-content">
                        <h2 style="font-size: 2.5rem; font-weight: 700; color: #E97132; margin-bottom: 20px; line-height: 1.2;">PERTAMINA BALONGAN</h2>
                        <p style="font-size: 1rem; line-height: 1.8; color: #4a5568; text-align: justify;">
                            {{ $description }}
                        </p>
                    </div>
                    
                    <!-- Requirement Content -->
                    <div id="requirementContent" class="tab-content" style="display: none;">
                        <h2 style="font-size: 2.5rem; font-weight: 700; color: #3b82f6; margin-bottom: 25px; line-height: 1.2;">Requirements Peserta & Registrasi</h2>
                        <div style="font-size: 1rem; line-height: 2; color: #4a5568;">
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Students of Diponegoro University</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Full name</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Student ID Number</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Faculty</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Study Program</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Class of Year</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Student ID Card</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Proof of Payment</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Wearpack Size (S, M, L, XL, XXL)</span>
                            </div>
                            <div style="display: flex; align-items: start; gap: 12px; margin-bottom: 12px;">
                                <div style="
                                    min-width: 24px;
                                    width: 24px;
                                    height: 24px;
                                    border-radius: 50%;
                                    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-shrink: 0;
                                    margin-top: 3px;
                                ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span style="font-weight: 500;">Shoe Size</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function switchTab(tab) {
    // Get elements
    const companyTab = document.getElementById('companyTab');
    const requirementTab = document.getElementById('requirementTab');
    const companyContent = document.getElementById('companyContent');
    const requirementContent = document.getElementById('requirementContent');
    
    if (tab === 'company') {
        // Show company content
        companyContent.style.display = 'block';
        requirementContent.style.display = 'none';
        
        // Update button styles
        companyTab.style.background = 'linear-gradient(135deg, #E97132 0%, #ff8a4d 100%)';
        companyTab.style.color = 'white';
        companyTab.style.boxShadow = '0 4px 15px rgba(233, 113, 50, 0.3)';
        
        requirementTab.style.background = '#e2e8f0';
        requirementTab.style.color = '#64748b';
        requirementTab.style.boxShadow = 'none';
    } else {
        // Show requirement content
        companyContent.style.display = 'none';
        requirementContent.style.display = 'block';
        
        // Update button styles
        requirementTab.style.background = 'linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%)';
        requirementTab.style.color = 'white';
        requirementTab.style.boxShadow = '0 4px 15px rgba(59, 130, 246, 0.3)';
        
        companyTab.style.background = '#e2e8f0';
        companyTab.style.color = '#64748b';
        companyTab.style.boxShadow = 'none';
    }
}
</script>
                                        
<!-- Benefits Section -->
<section class="benefits-section" style="padding: 80px 0;">
    <div class="container-custom">
        <div class="section-header-center" style="margin-bottom: 40px;">
            <h2 class="section-title-competitions" style="margin-bottom: 20px;">BENEFITS</h2>
            <p class="benefits-intro-text" style="font-size: 1.1rem; line-height: 1.8; color: #4a5568; max-width: 900px; margin: 0 auto; text-align: center;">
                The Company Visit Inception 2026 to Pertamina RU VI Balongan connects classroom learning with real industry experience, providing insights into energy sustainability, industrial operations, and professional practices in a strategic national refinery. <strong>By joining this program, participants will get:</strong>
            </p>
        </div>

        <!-- Desktop: Circular Layout -->
        <div class="benefits-desktop-layout" style="position: relative; max-width: 1200px; margin: 0 auto; min-height: 700px;">
            <!-- Center Logo -->
            <div class="benefits-center-logo" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1;">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Inception Logo" style="width: 280px; height: auto; opacity: 0.95;">
            </div>

            <!-- Benefits positioned around the logo in circular pattern -->
            @php
                $positions = [
                    // Top row
                    ['top' => '2%', 'left' => '5%'],      // 1. Top-left
                    ['top' => '2%', 'right' => '5%'],     // 2. Top-right
                    
                    // Upper-middle row
                    ['top' => '25%', 'left' => '0%'],     // 3. Upper-middle-left
                    ['top' => '25%', 'right' => '0%'],    // 4. Upper-middle-right
                    
                    // Middle row (left and right sides)
                    ['top' => '48%', 'left' => '0%'],     // 5. Middle-left
                    ['top' => '48%', 'right' => '0%'],    // 6. Middle-right
                    
                    // Lower-middle row
                    ['bottom' => '25%', 'left' => '0%'],  // 7. Lower-middle-left
                    ['bottom' => '25%', 'right' => '0%'], // 8. Lower-middle-right
                    
                    // Bottom row
                    ['bottom' => '2%', 'left' => '5%'],   // 9. Bottom-left
                    ['bottom' => '2%', 'right' => '5%'],  // 10. Bottom-right
                ];
            @endphp

            @foreach($benefits as $index => $benefit)
                <div class="benefit-floating benefit-item-{{ $index }}" style="
                    position: absolute;
                    {{ isset($positions[$index]['top']) ? 'top: ' . $positions[$index]['top'] . ';' : '' }}
                    {{ isset($positions[$index]['bottom']) ? 'bottom: ' . $positions[$index]['bottom'] . ';' : '' }}
                    {{ isset($positions[$index]['left']) ? 'left: ' . $positions[$index]['left'] . ';' : '' }}
                    {{ isset($positions[$index]['right']) ? 'right: ' . $positions[$index]['right'] . ';' : '' }}
                    max-width: 280px;
                    z-index: 2;
                    animation: fadeInScale 0.8s ease forwards, float{{ ($index % 3) + 1 }} 3s ease-in-out infinite;
                    animation-delay: {{ $index * 0.1 }}s, {{ $index * 0.1 }}s;
                    opacity: 0;
                ">
                    <div style="
                        background: white;
                        padding: 18px 22px;
                        border-radius: 12px;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                        transition: all 0.3s ease;
                        border: 2px solid {{ $index % 2 == 0 ? '#FBB137' : '#3b82f6' }};
                    " class="benefit-hover-card">
                        <p style="
                            margin: 0;
                            font-size: 0.88rem;
                            line-height: 1.5;
                            color: #dc2626;
                            font-weight: 600;
                            text-align: center;
                        ">
                            {{ $benefit }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile/Tablet: Grid Layout -->
        <div class="benefits-mobile-layout" style="display: none;">
            <div class="benefits-grid">
                @foreach($benefits as $index => $benefit)
                    <div class="benefit-grid-item" style="
                        animation: fadeInScale 0.8s ease forwards;
                        animation-delay: {{ $index * 0.1 }}s;
                        opacity: 0;
                    ">
                        <div style="
                            background: white;
                            padding: 20px;
                            border-radius: 12px;
                            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                            transition: all 0.3s ease;
                            border: 2px solid {{ $index % 2 == 0 ? '#FBB137' : '#3b82f6' }};
                            height: 100%;
                        " class="benefit-hover-card">
                            <p style="
                                margin: 0;
                                font-size: 0.9rem;
                                line-height: 1.6;
                                color: #dc2626;
                                font-weight: 600;
                                text-align: center;
                            ">
                                {{ $benefit }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Floating animations with different patterns */
@keyframes float1 {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-15px);
    }
}

@keyframes float2 {
    0%, 100% {
        transform: translateY(0px) translateX(0px);
    }
    50% {
        transform: translateY(-10px) translateX(5px);
    }
}

@keyframes float3 {
    0%, 100% {
        transform: translateY(0px) translateX(0px);
    }
    50% {
        transform: translateY(-12px) translateX(-5px);
    }
}

.benefit-hover-card:hover {
    transform: translateY(-8px) scale(1.08);
    box-shadow: 0 12px 30px rgba(233, 113, 50, 0.25) !important;
    border-color: #E97132 !important;
}

.benefit-floating:hover {
    animation-play-state: paused;
}
</style>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container-custom">
        <div class="cta-box">
            <h2 class="section-title-competitions">SECURE YOUR SPOT NOW</h2>
            <p>Don't miss this opportunity to gain valuable industry experience!</p>
            <div class="cta-buttons">
                <a href="{{ $googleFormUrl }}" target="_blank" class="cta-button primary">
                    Register
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section" style="padding: 80px 0;">
    <div class="container-custom">
        <div class="section-header-center" style="margin-bottom: 50px;">
            <h2 class="section-title-competitions">FAQ's</h2>
        </div>

        <div class="accordion" id="faqAccordion" style="max-width: 900px; margin: 0 auto;">
            @foreach($faqs as $index => $faq)
            <div class="accordion-item" style="
                background: white;
                border: none;
                border-radius: 12px;
                margin-bottom: 15px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                overflow: hidden;
                animation: fadeInUp 0.6s ease forwards;
                animation-delay: {{ $index * 0.1 }}s;
                opacity: 0;
            ">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" 
                            onclick="toggleFaq({{ $index }})"
                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                            aria-controls="collapse{{ $index }}"
                            style="
                                font-size: 1.1rem;
                                font-weight: 600;
                                color: #1e3a8a;
                                background: white;
                                border: none;
                                padding: 20px 25px;
                                box-shadow: none;
                                cursor: pointer;
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                width: 100%;
                                text-align: left;
                                transition: all 0.3s ease;
                            ">
                        <span>{{ $faq['question'] }}</span>
                        <svg class="accordion-icon" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" style="transition: transform 0.3s ease; transform: {{ $index === 0 ? 'rotate(180deg)' : 'rotate(0deg)' }};">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </h2>
                <div id="collapse{{ $index }}" 
                     class="accordion-collapse"
                     style="
                        max-height: {{ $index === 0 ? '1000px' : '0' }};
                        overflow: hidden;
                        transition: max-height 0.4s ease;
                     ">
                    <div class="accordion-body" style="
                        padding: 0 25px 25px 25px;
                        color: #4a5568;
                        line-height: 1.8;
                        font-size: 0.95rem;
                    ">
                        {!! $faq['answer'] !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
function toggleFaq(index) {
    const collapseElement = document.getElementById('collapse' + index);
    const button = collapseElement.previousElementSibling.querySelector('.accordion-button');
    const icon = button.querySelector('.accordion-icon');
    const isExpanded = button.getAttribute('aria-expanded') === 'true';
    
    if (isExpanded) {
        // Collapse
        collapseElement.style.maxHeight = '0';
        button.classList.add('collapsed');
        button.setAttribute('aria-expanded', 'false');
        button.style.color = '#1e3a8a';
        button.style.backgroundColor = 'white';
        icon.style.transform = 'rotate(0deg)';
    } else {
        // Expand - close all others first
        const allCollapses = document.querySelectorAll('.accordion-collapse');
        const allButtons = document.querySelectorAll('.accordion-button');
        const allIcons = document.querySelectorAll('.accordion-icon');
        
        allCollapses.forEach(collapse => {
            collapse.style.maxHeight = '0';
        });
        
        allButtons.forEach(btn => {
            btn.classList.add('collapsed');
            btn.setAttribute('aria-expanded', 'false');
            btn.style.color = '#1e3a8a';
            btn.style.backgroundColor = 'white';
        });
        
        allIcons.forEach(ic => {
            ic.style.transform = 'rotate(0deg)';
        });
        
        // Open current
        collapseElement.style.maxHeight = '1000px';
        button.classList.remove('collapsed');
        button.setAttribute('aria-expanded', 'true');
        button.style.color = '#E97132';
        button.style.backgroundColor = '#f8f9fa';
        icon.style.transform = 'rotate(180deg)';
    }
}
</script>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.benefit-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa !important;
    color: #E97132 !important;
}

.accordion-button::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231e3a8a'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23E97132'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.container-custom {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Company Visit Hero Specific Styles */
.company-visit-hero {
    background: url('{{ asset('assets/images/company-visit-hero.png') }}') center center / cover no-repeat;
    position: relative;
    min-height: 85vh;
}

.hero-background-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.5) 100%);
    z-index: 1;
}

.company-visit-hero .career-hero-content {
    position: relative;
    z-index: 2;
}

.company-visit-title {
    font-size: clamp(3.5rem, 12vw, 6rem);
    font-weight: 900;
    background: linear-gradient(90deg, #FBB137 0%, #E97132 25%, #8B5CF6 50%, #6366F1 75%, #3B82F6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
    line-height: 1;
    letter-spacing: -0.02em;
    text-shadow: none;
}

.company-visit-hero .hero-subtitle {
    color: #ffffff;
    font-size: clamp(1rem, 2.5vw, 1.3rem);
    font-weight: 400;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    margin-bottom: 2.5rem;
}

.company-visit-hero .cta-button-hero {
    background: linear-gradient(135deg, #E97132 0%, #FBB137 100%);
    padding: 1rem 3rem;
    font-size: 1.1rem;
    box-shadow: 0 4px 20px rgba(233, 113, 50, 0.4);
}

.company-visit-hero .cta-button-hero:hover {
    box-shadow: 0 6px 30px rgba(233, 113, 50, 0.6);
    transform: translateY(-3px);
}

/* Section Title Competitions Style */
.section-title-competitions {
    text-align: center;
    font-family: 'Poppins', sans-serif;
    font-size: clamp(2.5rem, 8vw, 4rem);
    font-weight: 800;
    background: linear-gradient(135deg, #FBB137 0%, #E97132 25%, #8B5CF6 50%, #6366F1 75%, #3B82F6 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 2rem;
    letter-spacing: 3px;
}

/* ========================================
   RESPONSIVE MEDIA QUERIES
   ======================================== */

/* Mobile Devices (up to 767px) */
@media (max-width: 767px) {
    /* Hero Section */
    .company-visit-hero {
        min-height: 60vh;
        padding: 20px;
    }
    
    .company-visit-title {
        font-size: 2.5rem !important;
        letter-spacing: 1px;
    }
    
    .company-visit-hero .hero-subtitle {
        font-size: 0.9rem !important;
        margin-bottom: 1.5rem;
    }
    
    .company-visit-hero .cta-button-hero {
        padding: 0.8rem 2rem;
        font-size: 0.95rem;
    }
    
    /* Section Titles */
    .section-title-competitions {
        font-size: 2rem !important;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }
    
    /* About Section */
    .career-about {
        padding: 40px 0 !important;
    }
    
    .section-description {
        font-size: 0.9rem !important;
        padding: 0 10px;
    }
    
    .benefits-intro-text {
        font-size: 0.9rem !important;
        padding: 0 10px;
    }
    
    /* Pertamina Balongan Section */
    .career-about > .container-custom > div[style*="margin-bottom: 40px"] {
        margin-bottom: 20px !important;
    }
    
    .tab-button {
        padding: 10px 20px !important;
        font-size: 0.85rem !important;
        margin-right: 8px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] {
        padding: 20px !important;
        border-width: 2px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] > div {
        flex-direction: column !important;
        gap: 20px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] > div > div:first-child {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] h2 {
        font-size: 1.8rem !important;
        margin-bottom: 15px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] p,
    .career-about > .container-custom > div[style*="background: white"] span {
        font-size: 0.9rem !important;
    }
    
    /* Benefits Section */
    .benefits-section {
        padding: 40px 0 !important;
    }
    
    .benefits-desktop-layout {
        display: none !important;
    }
    
    .benefits-mobile-layout {
        display: block !important;
    }
    
    .benefits-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 15px;
        padding: 0 10px;
    }
    
    .benefit-grid-item div {
        padding: 15px !important;
    }
    
    .benefit-grid-item p {
        font-size: 0.85rem !important;
    }
    
    /* CTA Section */
    .cta-section {
        padding: 40px 0 !important;
    }
    
    .cta-box {
        padding: 30px 20px !important;
    }
    
    .cta-box h2 {
        font-size: 1.8rem !important;
    }
    
    .cta-box p {
        font-size: 0.9rem !important;
    }
    
    .cta-button {
        padding: 12px 30px !important;
        font-size: 0.95rem !important;
    }
    
    /* FAQ Section */
    .faq-section {
        padding: 40px 0 !important;
    }
    
    .accordion-item {
        margin-bottom: 10px !important;
    }
    
    .accordion-button {
        font-size: 0.95rem !important;
        padding: 15px 18px !important;
    }
    
    .accordion-body {
        padding: 0 18px 18px 18px !important;
        font-size: 0.85rem !important;
    }
    
    .container-custom {
        padding: 0 15px;
    }
}

/* Tablet Devices (768px to 1023px) */
@media (min-width: 768px) and (max-width: 1023px) {
    /* Hero Section */
    .company-visit-hero {
        min-height: 70vh;
    }
    
    .company-visit-title {
        font-size: 3.5rem !important;
    }
    
    .company-visit-hero .hero-subtitle {
        font-size: 1.1rem !important;
    }
    
    /* Section Titles */
    .section-title-competitions {
        font-size: 2.8rem !important;
        letter-spacing: 2px;
    }
    
    /* About Section */
    .section-description,
    .benefits-intro-text {
        font-size: 1rem !important;
    }
    
    /* Pertamina Balongan Section */
    .tab-button {
        padding: 11px 28px !important;
        font-size: 0.9rem !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] {
        padding: 35px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] > div {
        gap: 30px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] > div > div:first-child {
        max-width: 300px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] h2 {
        font-size: 2.2rem !important;
    }
    
    /* Benefits Section */
    .benefits-section {
        padding: 60px 0 !important;
    }
    
    .benefits-desktop-layout {
        display: none !important;
    }
    
    .benefits-mobile-layout {
        display: block !important;
    }
    
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    /* CTA Section */
    .cta-section {
        padding: 50px 0 !important;
    }
    
    .cta-box {
        padding: 40px 30px !important;
    }
    
    /* FAQ Section */
    .faq-section {
        padding: 60px 0 !important;
    }
    
    .accordion-button {
        font-size: 1.05rem !important;
        padding: 18px 22px !important;
    }
    
    .accordion-body {
        font-size: 0.9rem !important;
    }
}

/* Large Tablets and Small Desktops (1024px to 1279px) */
@media (min-width: 1024px) and (max-width: 1279px) {
    /* Benefits Section - Show desktop layout but adjust spacing */
    .benefits-desktop-layout {
        min-height: 600px !important;
    }
    
    .benefits-center-logo img {
        width: 220px !important;
    }
    
    .benefit-floating {
        max-width: 240px !important;
    }
    
    .benefit-floating div {
        padding: 15px 18px !important;
    }
    
    .benefit-floating p {
        font-size: 0.82rem !important;
    }
    
    /* Pertamina Section */
    .career-about > .container-custom > div[style*="background: white"] > div > div:first-child {
        max-width: 350px !important;
    }
}

/* Desktop (1280px and above) */
@media (min-width: 1280px) {
    .benefits-desktop-layout {
        display: block !important;
    }
    
    .benefits-mobile-layout {
        display: none !important;
    }
}

/* Extra Small Mobile (up to 360px) */
@media (max-width: 360px) {
    .company-visit-title {
        font-size: 2rem !important;
    }
    
    .section-title-competitions {
        font-size: 1.6rem !important;
    }
    
    .tab-button {
        padding: 8px 15px !important;
        font-size: 0.8rem !important;
        margin-right: 5px !important;
    }
    
    .career-about > .container-custom > div[style*="background: white"] {
        padding: 15px !important;
    }
    
    .benefit-grid-item div {
        padding: 12px !important;
    }
}
</style>
@endsection
