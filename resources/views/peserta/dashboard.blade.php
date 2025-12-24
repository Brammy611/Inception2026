@extends('layouts.app')

@section('content')
<div class="peserta-dashboard" data-category="{{ $user->kategori_lomba }}">
  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="sidebar-profile">
      <div class="profile-avatar">
        @if($user->foto)
          <img src="{{ asset('storage/' . $user->foto) }}" alt="{{ $user->nama }}">
        @else
          <img src="{{ asset('assets/images/default-avatar.png') }}" alt="{{ $user->nama }}">
        @endif
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
      <h2 class="section-title">Team</h2>
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
      <h2 class="section-title">Tasks</h2>
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
    <div class="timeline">
      @foreach($competition['timeline'] as $index => $item)
        <div class="timeline-item">
          <div class="timeline-marker">
            <svg viewBox="0 0 24 24" fill="#FFA629" width="20" height="20">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
            @if(!$loop->last)
              <div class="timeline-line"></div>
            @endif
          </div>
          <div class="timeline-content">
            <span class="timeline-date">{{ $item['date'] }}</span>
            <span class="timeline-event">{{ $item['event'] }}</span>
          </div>
        </div>
      @endforeach
    </div>
  </aside>
</div>
@endsection

@push('styles')
<style>
/* Color Variables based on category */
:root {
  --gradient-main: linear-gradient(90deg, #FBB137 0%, #B22A2A 50%, #32477C 100%);
  --color-orange: #FFA629;
  --color-yellow: #FBB137;
  --color-red: #B22A2A;
  --color-blue-light: #4683B5;
  --color-blue-dark: #32477C;
  --color-verified: #07AD33;
  --color-pending: #F2B900;
}

.peserta-dashboard {
  display: grid;
  grid-template-columns: 220px 1fr 300px;
  min-height: calc(100vh - 80px);
  padding: 100px 40px 40px;
  background: #f5f5f5;
  gap: 25px;
  max-width: 1440px;
  margin: 0 auto;
}

/* Sidebar */
.sidebar {
  background: #fff;
  border-radius: 20px;
  padding: 40px 25px;
  border: 1px solid #FBB137;
  height: fit-content;
  position: sticky;
  top: 100px;
}

.sidebar-profile {
  text-align: center;
  margin-bottom: 35px;
}

.profile-avatar {
  width: 180px;
  height: 180px;
  border-radius: 50%;
  overflow: hidden;
  margin: 0 auto 20px;
  background: #f0f0f0;
}

.profile-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.profile-name {
  font-family: 'Kumbh Sans', 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 700;
  color: #1A1A1A;
  margin-bottom: 5px;
}

.profile-team {
  font-family: 'Kumbh Sans', 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #A7A7A7;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 10px;
  align-items: center;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 20px;
  border-radius: 10px;
  color: #000;
  text-decoration: none;
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  transition: all 0.2s ease;
  width: fit-content;
}

.nav-item svg {
  width: 24px;
  height: 24px;
  color: #FFA629;
}

.nav-item:hover {
  background: #fff8e8;
}

.nav-item.active {
  color: #000;
}

.nav-item.active svg {
  color: #FFA629;
}

/* Main Content */
.main-content {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* Competition Header */
.competition-header {
  border-radius: 20px;
  padding: 50px 75px;
  color: #fff;
}

.competition-header h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 32px;
  font-weight: 800;
  margin-bottom: 20px;
  line-height: 48px;
}

.btn-guidebook {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--gradient-main);
  color: #fff;
  padding: 10px 25px;
  border-radius: 15px;
  text-decoration: none;
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  border: 1px solid #104E81;
  transition: all 0.3s ease;
}

.btn-guidebook:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

/* Section Title - Gradient Text */
.section-title {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 700;
  line-height: 36px;
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 15px;
  text-transform: uppercase;
}

/* Team Card */
.team-card {
  background: #fff;
  border-radius: 20px;
  padding: 25px 30px;
  border: 1px solid #FBB137;
}

.team-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

.team-header h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 700;
  line-height: 36px;
  color: #000;
}

.status-badge {
  padding: 4px 20px;
  border-radius: 20px;
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 600;
  line-height: 20px;
  text-transform: capitalize;
}

.status-badge.pending {
  background: #F2B900;
  color: #fff;
}

.status-badge.verified {
  background: #07AD33;
  color: #fff;
}

.status-badge.rejected {
  background: #B22A2A;
  color: #fff;
}

.team-info {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 5px;
}

.info-item .label {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 500;
  line-height: 24px;
  color: #000;
}

.info-item .value {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 500;
  line-height: 24px;
  color: #000;
}

/* Task Card */
.task-card {
  background: #fff;
  border-radius: 20px;
  padding: 25px 30px;
  border: 1px solid #FBB137;
}

.task-card h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 700;
  line-height: 36px;
  color: #000;
  margin-bottom: 20px;
}

.upload-box {
  border: 2px dashed #ccc;
  border-radius: 12px;
  padding: 25px;
  text-align: center;
  background: #fafafa;
  margin-bottom: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  max-width: 200px;
}

.upload-box:hover {
  border-color: #32477C;
  background: #f5f7ff;
}

.upload-box svg {
  color: #999;
  margin-bottom: 10px;
}

.upload-box p {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  color: #666;
  margin-bottom: 5px;
}

.upload-box a {
  font-weight: 600;
  text-decoration: none;
  color: #32477C;
}

.upload-box span {
  font-size: 10px;
  color: #999;
}

.payment-info h4 {
  font-family: 'Poppins', sans-serif;
  font-size: 16px;
  font-weight: 600;
  line-height: 24px;
  color: #000;
  margin-bottom: 10px;
}

.payment-info p {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 500;
  line-height: 15px;
  color: #000;
  margin-bottom: 10px;
}

.format-example {
  background: #f5f5f5;
  padding: 12px;
  border-radius: 8px;
  margin: 15px 0;
}

.format-example p {
  font-size: 10px;
  line-height: 15px;
  margin: 0;
}

.bank-info {
  margin: 20px 0;
}

.bank-info p {
  margin-bottom: 5px;
}

.file-types {
  margin-top: 20px;
  padding-top: 15px;
  border-top: 1px solid #f0f0f0;
}

.file-types h4 {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 5px;
}

.file-types p {
  font-size: 10px;
  line-height: 15px;
  color: #000;
}

/* Timeline Sidebar */
.timeline-sidebar {
  background: #fff;
  border-radius: 20px;
  padding: 20px;
  border: 1px solid #FBB137;
  height: fit-content;
  position: sticky;
  top: 100px;
  max-height: calc(100vh - 140px);
  overflow-y: auto;
}

.timeline-title {
  font-family: 'Poppins', sans-serif;
  font-size: 24px;
  font-weight: 700;
  line-height: 36px;
  background: var(--gradient-main);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-transform: uppercase;
  margin-bottom: 20px;
  text-align: center;
}

.timeline {
  display: flex;
  flex-direction: column;
}

.timeline-item {
  display: flex;
  gap: 15px;
  position: relative;
}

.timeline-marker {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex-shrink: 0;
}

.timeline-marker svg {
  flex-shrink: 0;
}

.timeline-line {
  width: 2px;
  flex-grow: 1;
  background: #FFA629;
  margin: 5px 0;
  min-height: 30px;
}

.timeline-content {
  display: flex;
  flex-direction: column;
  gap: 2px;
  padding-bottom: 15px;
  flex: 1;
}

.timeline-date {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 500;
  line-height: 15px;
  color: #000;
}

.timeline-event {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 500;
  line-height: 15px;
  color: #000;
}

/* Responsive */
@media (max-width: 1400px) {
  .peserta-dashboard {
    grid-template-columns: 200px 1fr 280px;
    padding: 100px 20px 40px;
  }
  
  .competition-header {
    padding: 40px 50px;
  }
  
  .competition-header h1 {
    font-size: 28px;
  }
}

@media (max-width: 1200px) {
  .peserta-dashboard {
    grid-template-columns: 180px 1fr 250px;
    gap: 15px;
  }
  
  .profile-avatar {
    width: 120px;
    height: 120px;
  }
  
  .competition-header h1 {
    font-size: 24px;
  }
}

@media (max-width: 992px) {
  .peserta-dashboard {
    grid-template-columns: 1fr;
    padding: 100px 15px 30px;
  }

  .sidebar {
    position: relative;
    top: 0;
  }

  .sidebar-profile {
    display: flex;
    align-items: center;
    gap: 20px;
    text-align: left;
    margin-bottom: 20px;
  }

  .profile-avatar {
    width: 80px;
    height: 80px;
    margin: 0;
  }

  .sidebar-nav {
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
  }

  .timeline-sidebar {
    position: relative;
    top: 0;
    max-height: none;
  }
  
  .competition-header {
    padding: 30px;
  }
  
  .competition-header h1 {
    font-size: 20px;
    line-height: 30px;
  }
}

/* Category-specific border colors */
.peserta-dashboard[data-category="business_case"] .sidebar,
.peserta-dashboard[data-category="business_case"] .team-card,
.peserta-dashboard[data-category="business_case"] .task-card,
.peserta-dashboard[data-category="business_case"] .timeline-sidebar {
  border-color: #FBB137;
}

.peserta-dashboard[data-category="geothermal"] .sidebar,
.peserta-dashboard[data-category="geothermal"] .team-card,
.peserta-dashboard[data-category="geothermal"] .task-card,
.peserta-dashboard[data-category="geothermal"] .timeline-sidebar {
  border-color: #B22A2A;
}

.peserta-dashboard[data-category="poster_paper"] .sidebar,
.peserta-dashboard[data-category="poster_paper"] .team-card,
.peserta-dashboard[data-category="poster_paper"] .task-card,
.peserta-dashboard[data-category="poster_paper"] .timeline-sidebar {
  border-color: #4683B5;
}

.peserta-dashboard[data-category="well_stimulation"] .sidebar,
.peserta-dashboard[data-category="well_stimulation"] .team-card,
.peserta-dashboard[data-category="well_stimulation"] .task-card,
.peserta-dashboard[data-category="well_stimulation"] .timeline-sidebar {
  border-color: #32477C;
}
</style>
@endpush
