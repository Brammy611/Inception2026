@extends('layouts.app')

@section('content')
<div class="peserta-dashboard" data-category="{{ $peserta->kategori }}">
  {{-- Sidebar --}}
  <aside class="sidebar">
    <div class="sidebar-profile">
      <div class="profile-avatar">
        <div class="avatar-placeholder">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
        </div>
      </div>
      <h3 class="profile-name">{{ explode(' ', $peserta->nama_leader)[0] }}</h3>
      <p class="profile-team">{{ $peserta->nama_tim }}</p>
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
          <h3>{{ $peserta->nama_tim }}</h3>
          <span class="status-badge {{ $peserta->status_verifikasi }}">
            {{ ucfirst($peserta->status_verifikasi) }}
          </span>
        </div>
        <div class="team-info">
          <div class="info-item">
            <span class="label">Leader's Name</span>
            <span class="value">{{ $peserta->nama_leader }}</span>
          </div>
          <div class="info-item">
            <span class="label">Asal Universitas</span>
            <span class="value">{{ $peserta->asal_univ }}</span>
          </div>
          <div class="info-item">
            <span class="label">Jurusan Leader</span>
            <span class="value">{{ $peserta->jurusan_leader }}</span>
          </div>
          <div class="info-item">
            <span class="label">Members</span>
            <span class="value">{{ $peserta->nama_member_1 }} ({{ $peserta->jurusan_member_1 }})</span>
            @if($peserta->nama_member_2)
              <span class="value">{{ $peserta->nama_member_2 }} ({{ $peserta->jurusan_member_2 }})</span>
            @else
              <span class="value">-</span>
            @endif
          </div>
        </div>
      </div>
    </section>

    {{-- Documents Section --}}
    <section class="section-tasks">
      <h2 class="section-title">DOCUMENTS</h2>
      
      <div class="documents-grid">
        {{-- KTM --}}
        <div class="document-card">
          <h4>KTM</h4>
          @if($peserta->ktm)
            <div class="doc-uploaded">
              <span class="upload-status success">✓ Uploaded</span>
              <a href="{{ asset('storage/' . $peserta->ktm) }}" target="_blank" class="btn-view-doc">View PDF</a>
            </div>
          @else
            <span class="upload-status pending">Belum diupload</span>
          @endif
          <form action="{{ route('peserta.documents.update') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="upload-box">
              <input type="file" name="ktm" id="ktm" accept=".pdf" class="file-input" onchange="this.form.submit()">
              <label for="ktm" class="upload-label">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="32" height="32">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <span>{{ $peserta->ktm ? 'Ganti File' : 'Upload PDF' }}</span>
              </label>
            </div>
          </form>
        </div>
        
        {{-- Bukti Follow IG --}}
        <div class="document-card">
          <h4>Bukti Follow IG</h4>
          @if($peserta->follow_ig)
            <div class="doc-uploaded">
              <span class="upload-status success">✓ Uploaded</span>
              <a href="{{ asset('storage/' . $peserta->follow_ig) }}" target="_blank" class="btn-view-doc">View PDF</a>
            </div>
          @else
            <span class="upload-status pending">Belum diupload</span>
          @endif
          <form action="{{ route('peserta.documents.update') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="upload-box">
              <input type="file" name="follow_ig" id="follow_ig" accept=".pdf" class="file-input" onchange="this.form.submit()">
              <label for="follow_ig" class="upload-label">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="32" height="32">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <span>{{ $peserta->follow_ig ? 'Ganti File' : 'Upload PDF' }}</span>
              </label>
            </div>
          </form>
        </div>
        
        {{-- Bukti Share Poster --}}
        <div class="document-card">
          <h4>Bukti Share Poster</h4>
          @if($peserta->share_poster)
            <div class="doc-uploaded">
              <span class="upload-status success">✓ Uploaded</span>
              <a href="{{ asset('storage/' . $peserta->share_poster) }}" target="_blank" class="btn-view-doc">View PDF</a>
            </div>
          @else
            <span class="upload-status pending">Belum diupload</span>
          @endif
          <form action="{{ route('peserta.documents.update') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="upload-box">
              <input type="file" name="share_poster" id="share_poster" accept=".pdf" class="file-input" onchange="this.form.submit()">
              <label for="share_poster" class="upload-label">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="32" height="32">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <span>{{ $peserta->share_poster ? 'Ganti File' : 'Upload PDF' }}</span>
              </label>
            </div>
          </form>
        </div>
        
        {{-- Bukti Payment --}}
        <div class="document-card">
          <h4>Bukti Payment</h4>
          @if($peserta->payment)
            <div class="doc-uploaded">
              <span class="upload-status success">✓ Uploaded</span>
              <a href="{{ asset('storage/' . $peserta->payment) }}" target="_blank" class="btn-view-doc">View PDF</a>
            </div>
          @else
            <span class="upload-status pending">Belum diupload</span>
          @endif
          <form action="{{ route('peserta.documents.update') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf
            <div class="upload-box">
              <input type="file" name="payment" id="payment" accept=".pdf" class="file-input" onchange="this.form.submit()">
              <label for="payment" class="upload-label">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="32" height="32">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <span>{{ $peserta->payment ? 'Ganti File' : 'Upload PDF' }}</span>
              </label>
            </div>
          </form>
        </div>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-error">
          @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif
    </section>

    {{-- Payment Info Section --}}
    <section class="section-tasks">
      <h2 class="section-title">PAYMENT INFO</h2>
      <div class="task-card">
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