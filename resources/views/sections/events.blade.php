<section class="events" id="events">
  <div class="blur-circle"></div>
  <div class="blur-circle"></div>
  <div class="about-header">
    <h2>OUR <span class="heading">EVENTS</span></h2>
    <p class="tagline">Serangkaian kegiatan seru di Inception 2026</p>
  </div>
  <div class="events-container">
    @foreach($events as $event)
    <a href="{{ $event['link'] }}" class="event-card" style="--delay: {{ $event['delay'] }}">
        <div class="event-inner">
            <img src="{{ asset('assets/images/' . $event['image']) }}" alt="{{ $event['title'] }}">
            <h3>{{ $event['title'] }}</h3>
            <p>{{ $event['description'] }}</p>
        </div>
    </a>
    @endforeach
  </div>
</section>