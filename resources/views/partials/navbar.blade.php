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
        <li><a href="{{ route('home') }}#home" data-section="home" class="nav-link">Home</a></li>
        <li><a href="{{ route('home') }}#about" data-section="about" class="nav-link">About</a></li>
        <li><a href="{{ route('home') }}#events" data-section="events" class="nav-link">Events</a></li>
        <li><a href="{{ route('home') }}#competitions" data-section="competitions" class="nav-link">Competitions</a></li>
        <li><a href="{{ route('home') }}#timeline" data-section="timeline" class="nav-link">Timeline</a></li>
        
        {{-- Auth buttons di collapse menu (mobile only) --}}
        @auth
          <li class="mobile-auth-item dashboard-item"><a href="{{ route('dashboard') }}" class="nav-link nav-link-dashboard">Dashboard</a></li>
          <li class="mobile-auth-item logout-item">
            <form action="{{ route('logout') }}" method="POST" class="logout-form-mobile">
              @csrf
              <button type="submit" class="nav-link nav-link-logout">Logout</button>
            </form>
          </li>
        @else
          <li class="mobile-auth-item login-item"><a href="{{ route('login') }}" class="nav-link nav-link-login">Login</a></li>
          <li class="mobile-auth-item register-item"><a href="{{ route('register') }}" class="nav-link nav-link-register">Register</a></li>
        @endauth
      </ul>
    </div>

    {{-- Desktop auth buttons --}}
    <div class="navbar-auth">
      @auth
        <a href="{{ route('dashboard') }}" class="btn-dashboard">Dashboard</a>
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
          @csrf
          <button type="submit" class="btn-logout">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn-login">Login</a>
        <a href="{{ route('register') }}" class="btn-register">Register</a>
      @endauth
    </div>
  </div>
</nav>