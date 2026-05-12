@extends('layouts.app')

@section('content')
<div class="competition-home">
  {{-- Hero Section --}}
  <section class="hero-section">
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    
    <div class="hero-content">
      <h1 class="hero-title">
        <span class="gradient-text">INCEPTION COMPETITION</span>
      </h1>
      <p class="hero-subtitle">
        "Empowering Young Innovators in Geothermal<br>
        Development Towards Indonesia's Net Zero Future"
      </p>
    </div>
  </section>

  {{-- About Section --}}
  <section class="about-section">
    <div class="container">
      <h2 class="section-title-about">
        <span class="about-a">A</span><span class="about-b">B</span><span class="about-o">O</span><span class="about-u">U</span><span class="about-t">T</span> <span class="comp-c">C</span><span class="comp-o">O</span><span class="comp-m">M</span><span class="comp-p">P</span><span class="comp-e">E</span><span class="comp-t">T</span><span class="comp-i">I</span><span class="comp-t2">T</span><span class="comp-i2">I</span><span class="comp-o2">O</span><span class="comp-n">N</span><span class="comp-s">S</span>
      </h2>
      <p class="about-description">
        Inception Competition 2026 is a series of prestigious academic competitions designed to empower young innovators in contributing to Indonesia's sustainable energy future. Through four distinct competition categories - Business Case, Geothermal Development Plan, Poster & Paper, and Well Stimulation - participants will have the opportunity to showcase their creativity, analytical skills, and technical expertise. These competitions provide a platform for students to develop innovative solutions, engage with industry professionals, and compete for recognition and prizes while making meaningful contributions to the energy sector's advancement toward net-zero emissions.
      </p>
    </div>
  </section>

  {{-- Competitions Section --}}
  <section class="competitions-section">
    <div class="container">
      <h2 class="section-title-competitions">COMPETITIONS</h2>
      
      <div class="competitions-grid">
        @php
          $competitions = [
            [
              'key' => 'business_case',
              'title' => 'BUSINESS CASE COMPETITION',
              'color' => '#FBB137',
              'description' => 'Case-based competition that challenges students to analyze real-world energy industry problems and develop innovative, sustainable, and implementable business strategies.',
              'position' => 'left'
            ],
            [
              'key' => 'geothermal',
              'title' => 'GEOTHERMAL DEVELOPMENT PLAN COMPETITION',
              'color' => '#B22A2A',
              'description' => 'Challenges participants to design comprehensive and sustainable geothermal field development plans through a progressive case study approach. Participants will work on a real-world geothermal case, developing their solutions step by step.',
              'position' => 'right'
            ],
            [
              'key' => 'poster_paper',
              'title' => 'POSTER AND PAPER COMPETITION',
              'color' => '#4683B5',
              'description' => 'Academic platform to present scientific ideas, research findings, and innovative solutions addressing current and future challenges in the energy sector.',
              'position' => 'left'
            ],
            [
              'key' => 'well_stimulation',
              'title' => 'WELL STIMULATION COMPETITION',
              'color' => '#32477C',
              'description' => 'Encourages participants to develop innovative, technically sound, and environmentally responsible solutions that enhance well performance while addressing modern energy challenges.',
              'position' => 'right'
            ]
          ];
        @endphp

        @foreach($competitions as $comp)
        @php
          $logoMap = [
            'business_case' => 'BCC Logo.png',
            'geothermal' => 'GDPC Logo.png',
            'poster_paper' => 'PPC Logo.png',
            'well_stimulation' => 'WSC Logo.png',
          ];
          $logo = $logoMap[$comp['key']] ?? 'logo.png';
        @endphp
        <div class="competition-card card-{{ $comp['position'] }}" 
             data-category="{{ $comp['key'] }}"
             style="border-left: 5px solid {{ $comp['color'] }}; cursor: pointer;"
             onclick="openCompetitionModal('{{ $comp['key'] }}')">
          <div class="card-icon">
            <img src="{{ asset('assets/images/' . $logo) }}" alt="{{ $comp['title'] }}">
          </div>
          <div class="card-content">
            <h3 class="card-title" style="color: {{ $comp['color'] }};">{{ $comp['title'] }}</h3>
            <p class="card-description">{{ $comp['description'] }}</p>
            <span class="btn-read-more" style="color: {{ $comp['color'] }};">Read more →</span>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  {{-- Competition Modal --}}
  <div id="competitionModal" class="competition-modal">
    <div class="modal-content">
      <span class="modal-close" onclick="closeCompetitionModal()">&times;</span>
      <div id="modalBody"></div>
    </div>
  </div>

  {{-- FAQ Section --}}
  <section class="faq-section">
    <div class="container">
      <h2 class="section-title-faq">
        <span class="faq-f">F</span><span class="faq-a">A</span><span class="faq-q">Q</span><span class="faq-s">'s</span>
      </h2>

      <div class="faq-list">
        <div class="faq-item">
          <button class="faq-question">
            <span>How to pay/print?</span>
            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div class="faq-answer">
            <p>Detailed payment instructions will be provided after registration. You can pay through various methods including bank transfer and e-wallet.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>How to pay/print?</span>
            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div class="faq-answer">
            <p>Detailed payment instructions will be provided after registration.</p>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-question">
            <span>How to pay/print?</span>
            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div class="faq-answer">
            <p>Detailed payment instructions will be provided after registration.</p>
          </div>
        </div>

        <div class="faq-item active">
          <button class="faq-question">
            <span>How to pay/print?</span>
            <svg class="faq-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
          <div class="faq-answer" style="display: block;">
            <div class="faq-content-box">
              <h4>How to pay/print?</h4>
              <p>Pay for each user separately when purchasing in multiple user forms. After each separate payment you will find download button to download the pdf file.</p>
              <p><strong>Siapa yang boleh mengikuti Career Talk Inception 2026?</strong><br>
              Career Talk Inception 2026 terbuka untuk siswa SMA, mahasiswa, fresh graduates, dan khalayak umum yang tertarik untuk belajar tentang industri energi, khususnya geothermal, minyak dan gas.</p>
              <p><strong>Apa yang akan saya pelajari dalam Career Talk Inception 2026?</strong><br>
              Anda akan mendapatkan wawasan tentang tren pekerjaan, keterampilan masa depan, dan peluang karier di bidang energi.</p>
              <p><strong>Accepted File Types:</strong><br>
              .png, .jpeg, .jpg, .pdf</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Contact Section --}}
  <section class="contact-section">
    <div class="container">
      <h2 class="contact-title">Let's talk with us</h2>
      <p class="contact-subtitle">If you have question, we would be happy to help! Just send us a message in the form below with any question you might have.</p>

      <div class="contact-wrapper">
        {{-- Contact Info --}}
        <div class="contact-info">
          <div class="contact-item">
            <svg class="contact-icon" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
            <div>
              <p>1850 Arthur ave Elk Groot, 67. Elk Grove Illinois 60007</p>
            </div>
          </div>

          <div class="contact-item">
            <svg class="contact-icon" fill="currentColor" viewBox="0 0 24 24">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
            <div>
              <p>+1 234 678 9108 99</p>
            </div>
          </div>

          <div class="contact-item">
            <svg class="contact-icon" fill="currentColor" viewBox="0 0 24 24">
              <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <div>
              <p>Contact@ittemplate.com</p>
            </div>
          </div>
        </div>

        {{-- Contact Form --}}
        <div class="contact-form">
          <form action="#" method="POST">
            @csrf
            <div class="form-row">
              <input type="text" name="name" placeholder="Name" required>
              <input type="text" name="last_name" placeholder="Last Name" required>
            </div>
            <div class="form-row">
              <input type="email" name="email" placeholder="Email" required>
              <input type="tel" name="phone" placeholder="Phone Number" required>
            </div>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn-submit">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
// Competition Modal Data
const competitionData = {
  business_case: {
    title: 'Business Case Competition',
    color: '#FBB137',
    description: 'Business Case Competition (BCC) is a competition that challenges participants to analyze real-world business problems and develop strategic solutions.',
    details: `The Business Case Competition tests your analytical thinking, strategic planning, and presentation skills. 
    Participants will work in teams to solve complex business challenges in the energy and geothermal sector.`,
    requirements: [
      'Team of 3 members maximum',
      'University students (undergraduate or graduate)',
      'Submit business analysis and strategic recommendations',
      'Present solutions to panel of judges'
    ],
    prizes: 'Total Prize Pool: IDR 15,000,000',
    timeline: @json(config('competitions.categories.business_case.timeline', []))
  },
  geothermal: {
    title: 'Geothermal Development Plan Competition',
    color: '#B22A2A',
    description: 'Geothermal Development Plan Competition (GDPC) focuses on sustainable energy development and geothermal resource planning.',
    details: `This competition challenges teams to develop comprehensive geothermal development plans, 
    including technical feasibility, environmental impact, and economic viability assessments.`,
    requirements: [
      'Team of 3 members maximum',
      'Engineering or related field students',
      'Submit technical development plan',
      'Demonstrate understanding of geothermal systems'
    ],
    prizes: 'Total Prize Pool: IDR 15,000,000',
    timeline: @json(config('competitions.categories.geothermal.timeline', []))
  },
  poster_paper: {
    title: 'Poster and Paper Competition',
    color: '#4683B5',
    description: 'Poster and Paper Competition (PPC) encourages research and innovation in energy and sustainability topics.',
    details: `Participants present original research through academic papers and visual posters, 
    showcasing innovative solutions and scientific contributions to the energy sector.`,
    requirements: [
      'Team of 3 members maximum',
      'Submit original research paper',
      'Create scientific poster presentation',
      'Present findings to academic panel'
    ],
    prizes: 'Total Prize Pool: IDR 12,000,000',
    timeline: @json(config('competitions.categories.poster_paper.timeline', []))
  },
  well_stimulation: {
    title: 'Well Stimulation Competition',
    color: '#32477C',
    description: 'Well Stimulation Competition (WSC) focuses on advanced techniques in oil and gas well optimization.',
    details: `This technical competition challenges participants to design and optimize well stimulation strategies, 
    demonstrating expertise in petroleum engineering and reservoir management.`,
    requirements: [
      'Team of 3 members maximum',
      'Petroleum/Mechanical Engineering students',
      'Submit stimulation design and analysis',
      'Technical presentation required'
    ],
    prizes: 'Total Prize Pool: IDR 15,000,000',
    timeline: @json(config('competitions.categories.well_stimulation.timeline', []))
  }
};

function openCompetitionModal(category) {
  const data = competitionData[category];
  const modal = document.getElementById('competitionModal');
  const modalBody = document.getElementById('modalBody');
  
  let timelineHTML = '';
  if (data.timeline && data.timeline.length > 0) {
    timelineHTML = `
      <div class="modal-section">
        <h3>Timeline</h3>
        <ul class="timeline-list">
          ${data.timeline.map(item => `
            <li>
              <span class="timeline-date" style="color: ${data.color};">${item.date}</span>
              <span class="timeline-event">${item.event}</span>
            </li>
          `).join('')}
        </ul>
      </div>
    `;
  }
  
  modalBody.innerHTML = `
    <div class="modal-header" style="border-left: 5px solid ${data.color};">
      <h2 style="color: ${data.color};">${data.title}</h2>
      <p>${data.description}</p>
    </div>
    <div class="modal-body">
      <div class="modal-section">
        <h3>About This Competition</h3>
        <p>${data.details}</p>
      </div>
      
      <div class="modal-section">
        <h3>Requirements</h3>
        <ul>
          ${data.requirements.map(req => `<li style="color: ${data.color};">${req}</li>`).join('')}
        </ul>
      </div>
      
      ${timelineHTML}
      
      <div class="modal-section">
        <h3>Prizes</h3>
        <p style="font-weight: 600; color: ${data.color}; font-size: 18px;">${data.prizes}</p>
      </div>
    </div>
    <div class="modal-footer">
      <div></div>
      <a href="/register" class="btn-register" style="background: linear-gradient(90deg, ${data.color} 0%, #32477C 100%);">
        Register Now
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
          <line x1="5" y1="12" x2="19" y2="12"></line>
          <polyline points="12 5 19 12 12 19"></polyline>
        </svg>
      </a>
    </div>
  `;
  
  modal.style.display = 'block';
  document.body.style.overflow = 'hidden';
}

function closeCompetitionModal() {
  const modal = document.getElementById('competitionModal');
  modal.style.display = 'none';
  document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
window.onclick = function(event) {
  const modal = document.getElementById('competitionModal');
  if (event.target == modal) {
    closeCompetitionModal();
  }
}

// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(button => {
  button.addEventListener('click', () => {
    const faqItem = button.parentElement;
    const isActive = faqItem.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-item').forEach(item => {
      item.classList.remove('active');
      item.querySelector('.faq-answer').style.display = 'none';
    });
    
    // Open clicked item if it wasn't active
    if (!isActive) {
      faqItem.classList.add('active');
      faqItem.querySelector('.faq-answer').style.display = 'block';
    }
  });
});
</script>
@endsection
