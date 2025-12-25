@extends('layouts.app')

@section('content')
<div class="peserta-dashboard" data-category="{{ $user->kategori_lomba }}">
  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="sidebar-profile">
      <div class="profile-avatar">
        @if($user->foto && file_exists(public_path('storage/' . $user->foto)))
          <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama }}" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
        @else
          <img src="{{ asset('assets/images/default-avatar.png') }}" alt="{{ $user->nama }}" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
        @endif
        <div class="avatar-placeholder">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
        </div>
      </div>
      <h3 class="profile-name">{{ explode(' ', $user->nama)[0] }}</h3>
      <p class="profile-team">{{ $user->nama_tim ?? 'No Team' }}</p>
    </div>

    <nav class="sidebar-nav">
      <a href="{{ route('peserta.dashboard') }}" class="nav-item active">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
      </a>
      <a href="#" class="nav-item">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        <span>Profile</span>
      </a>
      <a href="#" class="nav-item">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span>Notification</span>
      </a>
    </nav>
  </aside>

  {{-- Main Content --}}
  <main class="main-content">
    {{-- Competition Header --}}
    <div class="competition-header" style="background: {{ $competition['color'] }};">
      <h1>{{ strtoupper($competition['name']) }}</h1>
      <a href="{{ asset($competition['guidebook']) }}" class="btn-guidebook" target="_blank">
        <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
          <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
        </svg>
        Download Guidebook
      </a>
    </div>

    {{-- Team Section --}}
    <section class="section-team">
      <h2 class="section-title">TEAM</h2>
      <div class="team-card">
        <div class="team-header">
          <h3>{{ $user->nama_tim ?? 'No Team' }}</h3>
          <span class="status-badge {{ $user->status_verifikasi }}">
            {{ ucfirst($user->status_verifikasi) }}
          </span>
        </div>
        <div class="team-info">
          <div class="info-item">
            <span class="label">Leader's Name</span>
            <span class="value">{{ $user->nama }}</span>
          </div>
          <div class="info-item">
            <span class="label">Members</span>
            <span class="value">-</span>
            <span class="value">-</span>
          </div>
        </div>
      </div>
    </section>

    {{-- Tasks Section --}}
    <section class="section-tasks">
      <h2 class="section-title">TASKS</h2>
      <div class="task-card">
        <h3>Payment</h3>
        <div class="payment-upload">
          <div class="upload-box">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="48" height="48">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
            </svg>
            <p>Drag and drop or <a href="#">Browse</a></p>
            <span>Max 10 MB | PNG, JPEG, PDF</span>
          </div>
        </div>

        <div class="payment-info">
          <h4>Ketentuan Submisi</h4>
          <p>Setiap tim wajib mentransfer biaya pendaftaran ke rekening yang tertera, dengan menyertakan catatan dengan format:</p>
          <div class="format-example">
            <p>[NAMA TIM/PESERTA] - [NAMA SINGKAT KOMPETISI] Nama tim apabila lomba dalam bentuk tim, sedangkan nama peserta apabila lomba dalam bentuk Individu.</p>
          </div>
          
          <div class="bank-info">
            <p>Detail alamat rekening yang harus di transfer:</p>
            <p><strong>{{ $payment['bank_name'] }}</strong> {{ $payment['account_number'] }}</p>
            <p>({{ $payment['account_holder'] }})</p>
          </div>

          <div class="file-types">
            <h4>Accepted File Types:</h4>
            <p>.{{ implode(', .', $payment['accepted_file_types']) }}</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  {{-- Timeline Sidebar --}}
  <aside class="timeline-sidebar">
    <h2 class="timeline-title">Timeline</h2>
    <div class="timeline-container">
      <div class="timeline-line-vertical"></div>
      @foreach($competition['timeline'] as $index => $item)
        <div class="timeline-item {{ $index % 2 == 0 ? 'timeline-left' : 'timeline-right' }}">
          <div class="timeline-content-wrapper">
            <div class="timeline-content">
              <span class="timeline-date">{{ $item['date'] }}</span>
              <span class="timeline-event">{{ $item['event'] }}</span>
            </div>
          </div>
          <div class="timeline-marker">
            <img src="{{ asset('assets/images/dropoil-nobg.png') }}" alt="timeline marker">
          </div>
        </div>
      @endforeach
    </div>
  </aside>
</div>
@endsection