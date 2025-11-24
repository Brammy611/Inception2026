<nav class="navbar">
  <div class="container">
    <div class="navbar-logo">
      <a href="{{ route('home') }}">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="logo-mark">
        <span class="logo-text">INCEPTION</span>
      </a>
    </div>

    <button class="navbar-toggle" id="navToggle" aria-expanded="false" aria-controls="navLinks" aria-label="Toggle navigation menu">☰</button>

    <div class="navbar-links" id="navLinks">
      <ul>
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#events">Events</a></li>
        <li><a href="#competitions">Competitions</a></li>
        <li><a href="#timeline">Timeline</a></li>
      </ul>
    </div>
  </div>
</nav>