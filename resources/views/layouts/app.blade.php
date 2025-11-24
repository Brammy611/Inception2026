<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="{{ $metaDescription ?? 'Inception 2026 - Showcase of creativity, innovation, and technology.' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Inception 2026' }}</title>
  
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Great+Vibes&family=Kavoon&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&family=Playwrite+AU+SA:wght@100..400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Sacramento&family=Sniglet:wght@400;800&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <script type="module" src="https://unpkg.com/@splinetool/viewer@1.10.90/build/spline-viewer.js"></script>
  
  @stack('styles')
</head>

<body>
  {{-- Navbar --}}
  @include('partials.navbar')

  {{-- Main Content --}}
  @yield('content')

  {{-- Footer --}}
  @include('partials.footer')

  {{-- Back to Top Button --}}
  <button class="back-to-top" id="backToTop" aria-label="Back to top">
    <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
      <path d="m18 15-6-6-6 6"/>
    </svg>
  </button>

  {{-- Scripts --}}
  @include('partials.scripts')
  @stack('scripts')
</body>
</html>