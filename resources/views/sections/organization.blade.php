<section class="organization" id="organization">
  <div class="about-header">
    <h2>OUR <span class="heading">ORGANIZATION</span></h2>
    <p class="tagline">Organisasi yang menaungi Inception</p>
  </div>

  <div class="carousel-container">
    <div class="carousel-track">
      @foreach($organizations as $index => $org)
      <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}">
        <div class="cards-container">
          <div class="highlight-card">
            <div class="date-badge">{{ $org['badge'] }}</div>
            <h3>{{ $org['title'] }}</h3>
            <p>{{ $org['tagline'] ?? $org['university'] ?? '' }}</p>
          </div>
          <div class="mascot-card">
            <img src="{{ asset('assets/images/' . $org['logo']) }}" alt="{{ $org['name'] }} Logo" class="mascot-image">
          </div>
          <div class="info-card">
            <div class="card-content">
              <h3>{{ $org['short_name'] }}</h3>
              <p>{{ $org['description'] }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Carousel Navigation -->
    <div class="carousel-nav">
      <button class="nav-button prev">‹</button>
      <div class="carousel-dots">
        @foreach($organizations as $index => $org)
        <button class="dot {{ $index === 0 ? 'active' : '' }}"></button>
        @endforeach
      </div>
      <button class="nav-button next">›</button>
    </div>
  </div>
</section>