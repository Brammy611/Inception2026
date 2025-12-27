@php
$timeline = $timeline ?? [
    [
        'number' => 1,
        'title' => 'Career Talk',
        'description' => 'Professionals share experiences and insights to inspire participants\' future careers.'
    ],
    [
        'number' => 2,
        'title' => 'Company Visit',
        'description' => 'Exclusive tours of partner companies to explore real-world projects and technologies.'
    ],
    [
        'number' => 3,
        'title' => 'Competition',
        'description' => 'Teams showcase creativity and logic in challenging competitions full of innovation.'
    ],
    [
        'number' => 4,
        'title' => 'Awarding',
        'description' => 'The grand finale – celebrating winners and closing the event with pride and joy.'
    ]
];
@endphp

<section class="timeline-section" id="timeline">
  <h2 class="section-title">Timeline</h2>

  <div class="timeline-wrapper" id="timelineWrapper">
    <div class="timeline-track">
      <div class="timeline-line"></div>
      
      @foreach($timeline as $item)
      <div class="timeline-item" data-timeline-index="{{ $item['number'] }}">
        <div class="timeline-number" data-number="{{ $item['number'] }}">{{ $item['number'] }}</div>
        <div class="timeline-dot"></div>
        <div class="timeline-content">
          <h3>{{ $item['title'] }}</h3>
          <p>{{ $item['description'] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>