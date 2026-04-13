@extends('layouts.app')

@section('content')
<div class="peserta-dashboard" data-category="{{ $peserta->kategori }}">
  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="sidebar-profile">
      <div class="profile-avatar">
        @php
          $logoMap = [
            'business_case' => 'BCC Logo.png',
            'geothermal' => 'GDPC Logo.png',
            'poster_paper' => 'PPC Logo.png',
            'well_stimulation' => 'WSC Logo.png',
          ];
          $logo = $logoMap[$peserta->kategori] ?? 'logo.png';
        @endphp
        <img src="{{ asset('assets/images/' . $logo) }}" alt="{{ $competition['name'] }}">
      </div>
      <h3 class="profile-name">{{ explode(' ', $peserta->nama_leader)[0] }}</h3>
      <p class="profile-team">{{ $peserta->nama_tim }}</p>
    </div>

    <nav class="sidebar-nav">
      <a href="{{ route('peserta.dashboard') }}" class="nav-item">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
      </a>
      <a href="{{ route('peserta.profile') }}" class="nav-item active">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        <span>Profile</span>
      </a>
      <a href="{{ route('peserta.notifications') }}" class="nav-item">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span>Notification</span>
        @if(auth()->user()->unreadNotificationsCount() > 0)
          <span class="notification-badge">{{ auth()->user()->unreadNotificationsCount() }}</span>
        @endif
      </a>
    </nav>
  </aside>

  {{-- Main Content --}}
  <main class="main-content">
    {{-- Page Header --}}
    <div class="page-header">
      <h1>Team Profile</h1>
      <p>Manage your team information</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success" style="margin-bottom: 2rem; padding: 1rem; background: #d4edda; color: #155724; border-radius: 8px;">
        {{ session('success') }}
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-error" style="margin-bottom: 2rem; padding: 1rem; background: #f8d7da; color: #721c24; border-radius: 8px;">
        <ul style="margin: 0; padding-left: 20px;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('peserta.profile.update') }}" class="profile-form">
      @csrf
      @method('PUT')

      {{-- Team Basic Info --}}
      <section class="section-team">
        <div class="section-header">
          <h2 class="section-title">TEAM INFORMATION</h2>
        </div>
        <div class="team-card profile-card">
          <div class="form-row">
            <div class="form-group">
              <label for="nama_tim">Team Name</label>
              <input 
                type="text" 
                id="nama_tim" 
                name="nama_tim" 
                value="{{ old('nama_tim', $peserta->nama_tim) }}" 
                readonly
                class="form-control"
                style="background-color: #f5f5f5; cursor: not-allowed;"
              >
              <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">Team name cannot be changed</small>
            </div>
            <div class="form-group">
              <label for="asal_univ">University</label>
              <input 
                type="text" 
                id="asal_univ" 
                name="asal_univ" 
                value="{{ old('asal_univ', $peserta->asal_univ) }}" 
                required
                class="form-control"
              >
            </div>
          </div>
        </div>
      </section>

      {{-- Leader Information --}}
      <section class="section-team">
        <div class="section-header">
          <h2 class="section-title">LEADER INFORMATION</h2>
        </div>
        <div class="team-card profile-card">
          <div class="form-row">
            <div class="form-group">
              <label for="nama_leader">Full Name</label>
              <input 
                type="text" 
                id="nama_leader" 
                name="nama_leader" 
                value="{{ old('nama_leader', $peserta->nama_leader) }}" 
                required
                class="form-control"
              >
            </div>
            <div class="form-group">
              <label for="jurusan_leader">Major</label>
              <input 
                type="text" 
                id="jurusan_leader" 
                name="jurusan_leader" 
                value="{{ old('jurusan_leader', $peserta->jurusan_leader) }}" 
                required
                class="form-control"
              >
            </div>
          </div>
        </div>
      </section>

      {{-- Member 1 Information --}}
      <section class="section-team">
        <div class="section-header">
          <h2 class="section-title">MEMBER 1 INFORMATION</h2>
          @if($peserta->kategori === 'poster_paper')
            <span class="optional-badge">Optional</span>
          @endif
        </div>
        <div class="team-card profile-card">
          @if($peserta->kategori === 'poster_paper')
            <div class="info-notice" style="background: #e3f2fd; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #1565c0; font-size: 14px;">
              <strong>Poster & Paper Competition:</strong> Min 2 members (Leader + 1 member), Max 3 members
            </div>
          @else
            <div class="info-notice" style="background: #fff3e0; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #e65100; font-size: 14px;">
              <strong>{{ $competition['name'] }}:</strong> Min 3 members (Leader + 2 members), Max 4 members
            </div>
          @endif
          <div class="form-row">
            <div class="form-group">
              <label for="nama_member_1">Full Name</label>
              <input 
                type="text" 
                id="nama_member_1" 
                name="nama_member_1" 
                value="{{ old('nama_member_1', $peserta->nama_member_1) }}" 
                {{ $peserta->kategori === 'poster_paper' ? '' : 'required' }}
                class="form-control"
                placeholder="Enter member 1 full name{{ $peserta->kategori === 'poster_paper' ? ' (min 2 members total)' : '' }}"
              >
            </div>
            <div class="form-group">
              <label for="jurusan_member_1">Major</label>
              <input 
                type="text" 
                id="jurusan_member_1" 
                name="jurusan_member_1" 
                value="{{ old('jurusan_member_1', $peserta->jurusan_member_1) }}" 
                {{ $peserta->kategori === 'poster_paper' ? '' : 'required' }}
                class="form-control"
                placeholder="Enter member 1 major{{ $peserta->kategori === 'poster_paper' ? ' (optional)' : '' }}"
              >
            </div>
          </div>
        </div>
      </section>

      {{-- Member 2 Information --}}
      <section class="section-team">
        <div class="section-header">
          <h2 class="section-title">MEMBER 2 INFORMATION</h2>
          @if(in_array($peserta->kategori, ['poster_paper']))
            <span class="optional-badge">Optional</span>
          @endif
        </div>
        <div class="team-card profile-card">
          @if($peserta->kategori === 'poster_paper')
            <div class="info-notice" style="background: #e3f2fd; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #1565c0; font-size: 14px;">
              <strong>Poster & Paper:</strong> Member 2 is optional (max 3 members total)
            </div>
          @else
            <div class="info-notice" style="background: #fff3e0; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #e65100; font-size: 14px;">
              <strong>Required:</strong> Member 2 is required (min 3 members). Member 3 is optional (max 4 members)
            </div>
          @endif
          <div class="form-row">
            <div class="form-group">
              <label for="nama_member_2">Full Name</label>
              <input 
                type="text" 
                id="nama_member_2" 
                name="nama_member_2" 
                value="{{ old('nama_member_2', $peserta->nama_member_2) }}" 
                {{ in_array($peserta->kategori, ['poster_paper']) ? '' : 'required' }}
                class="form-control"
                placeholder="Enter member 2 full name{{ in_array($peserta->kategori, ['poster_paper']) ? ' (optional)' : '' }}"
              >
            </div>
            <div class="form-group">
              <label for="jurusan_member_2">Major</label>
              <input 
                type="text" 
                id="jurusan_member_2" 
                name="jurusan_member_2" 
                value="{{ old('jurusan_member_2', $peserta->jurusan_member_2) }}" 
                {{ in_array($peserta->kategori, ['poster_paper']) ? '' : 'required' }}
                class="form-control"
                placeholder="Enter member 2 major{{ in_array($peserta->kategori, ['poster_paper']) ? ' (optional)' : '' }}"
              >
            </div>
          </div>
        </div>
      </section>

      {{-- Member 3 Information --}}
      @if(in_array($peserta->kategori, ['business_case', 'geothermal', 'well_stimulation']))
      <section class="section-team">
        <div class="section-header">
          <h2 class="section-title">MEMBER 3 INFORMATION</h2>
          <span class="optional-badge">Optional</span>
        </div>
        <div class="team-card profile-card">
          <div class="info-notice" style="background: #e8f5e9; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #2e7d32; font-size: 14px;">
            <strong>Optional:</strong> Member 3 is optional. Maximum 4 members total (Leader + 3 members)
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="nama_member_3">Full Name</label>
              <input 
                type="text" 
                id="nama_member_3" 
                name="nama_member_3" 
                value="{{ old('nama_member_3', $peserta->nama_member_3) }}" 
                class="form-control"
                placeholder="Enter member 3 full name (optional)"
              >
            </div>
            <div class="form-group">
              <label for="jurusan_member_3">Major</label>
              <input 
                type="text" 
                id="jurusan_member_3" 
                name="jurusan_member_3" 
                value="{{ old('jurusan_member_3', $peserta->jurusan_member_3) }}" 
                class="form-control"
                placeholder="Enter member 3 major (optional)"
              >
            </div>
          </div>
        </div>
      </section>
      @endif

      {{-- Submit Button --}}
      <div class="form-actions">
        <button type="submit" class="btn-submit">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="20" height="20">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
          Save Changes
        </button>
        <a href="{{ route('peserta.dashboard') }}" class="btn-cancel">Cancel</a>
      </div>
    </form>
  </main>

  {{-- Timeline Sidebar (same as dashboard) --}}
  <aside class="timeline-sidebar">
    <h2 class="timeline-title">Competition</h2>
    <div class="competition-info-box">
      <h3 style="color: {{ $competition['color'] }}; margin-bottom: 1rem;">{{ $competition['name'] }}</h3>
      <div class="status-badge {{ $peserta->status_verifikasi }}" style="margin-bottom: 1rem;">
        {{ ucfirst($peserta->status_verifikasi) }}
      </div>
      <div class="sidebar-buttons" style="display: flex; flex-direction: column; gap: 8px;">
        <a href="{{ asset($competition['guidebook']) }}" class="btn-guidebook-small" target="_blank">
          <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
          </svg>
          Download Guidebook
        </a>
        @if($peserta->kategori === 'geothermal' && $semifinalQualifier)
        <a href="{{ asset('case/FinalCase_GDPC_INCEPTION_2026.rar') }}" class="btn-case-semifinal-small" download="FinalCase_GDPC_INCEPTION_2026.rar">
          <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
          </svg>
          Case Semifinal
        </a>
        @endif
      </div>
    </div>
  </aside>
</div>
@endsection
