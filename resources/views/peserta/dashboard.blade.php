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
      <a href="{{ route('peserta.dashboard') }}" class="nav-item active">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        <span>Home</span>
      </a>
      <a href="{{ route('peserta.profile') }}" class="nav-item">
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

    {{-- Semifinal Section (Only for Qualified Teams) --}}
    @if($semifinalQualifier)
    <section class="section-semifinal">
      <h2 class="section-title">SEMIFINAL STATUS</h2>
      
      {{-- Congratulations Card --}}
      <div class="semifinal-congratulations">
        <div class="congrats-icon">
          <svg fill="currentColor" viewBox="0 0 24 24" width="32" height="32">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
          </svg>
        </div>
        <div class="congrats-content">
          <h3>🎉 Congratulations! Your Team Advanced to Semifinals</h3>
          <p>Team <strong>{{ $peserta->nama_tim }}</strong> has successfully advanced to the semifinals of {{ $competition['name'] }}!</p>
        </div>
      </div>

      {{-- Payment Section --}}
      <div class="semifinal-payment-section">
        <h3 class="subsection-title">Semifinal Payment</h3>
        
        @if(!$semifinalPayment)
          {{-- Upload Payment Form --}}
          <div class="payment-upload-card">
            <div class="payment-info">
              <h4>Upload Semifinal Payment Proof</h4>
              <p>To proceed to the semifinal round, please complete the payment and upload the payment proof.</p>
              
              <div class="payment-details">
                <div class="payment-detail-item">
                  <span class="label">Bank</span>
                  <strong>{{ $payment['bank_name'] }}</strong>
                </div>
                <div class="payment-detail-item">
                  <span class="label">Account Number</span>
                  <strong>{{ $payment['account_number'] }}</strong>
                </div>
                <div class="payment-detail-item">
                  <span class="label">Account Holder</span>
                  <strong>{{ $payment['account_holder'] }}</strong>
                </div>
              </div>
            </div>

            <form action="{{ route('peserta.semifinal.payment.upload') }}" method="POST" enctype="multipart/form-data" class="payment-upload-form" id="semifinalPaymentForm">
              @csrf
              <div class="submission-upload">
                <div class="upload-dropzone" id="semifinalPaymentDropzone">
                  <input type="file" 
                         name="payment_proof" 
                         id="payment_proof" 
                         accept=".pdf,.jpg,.jpeg,.png,image/jpeg,image/png,application/pdf" 
                         class="file-input-hidden"
                         required>
                  <label for="payment_proof" class="upload-label">
                    <div class="upload-icon">
                      <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="28" height="28">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                      </svg>
                    </div>
                    <span class="upload-text">Upload Payment Proof</span>
                    <span class="upload-hint">PDF, JPG, or PNG (Max 10MB)</span>
                  </label>
                </div>
                <div class="upload-progress" id="semifinalPaymentProgress" style="display: none;">
                  <div class="progress-bar-mini">
                    <div class="progress-fill"></div>
                  </div>
                  <span class="progress-status">Uploading...</span>
                </div>
              </div>
              <button type="submit" class="btn-upload-payment" id="submitPaymentBtn" style="display: none;">
                <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
                  <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                </svg>
                Upload Payment Proof
              </button>
            </form>
          </div>
        @else
          {{-- Payment Status --}}
          <div class="payment-status-card status-{{ $semifinalPayment->status }}">
            <div class="status-header">
              <h4>Payment Proof Status</h4>
              <span class="status-badge {{ $semifinalPayment->status }}">
                @if($semifinalPayment->status === 'pending')
                  ⏳ Pending
                @elseif($semifinalPayment->status === 'verified')
                  ✓ Verified
                @else
                  ✗ Rejected
                @endif
              </span>
            </div>
            
            <div class="payment-file-info">
              <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
                <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
              </svg>
              <div class="file-details">
                <span class="filename">{{ $semifinalPayment->original_filename }}</span>
                <span class="filesize">{{ $semifinalPayment->file_size_human }}</span>
                <span class="upload-date">Uploaded: {{ $semifinalPayment->uploaded_at->format('d M Y, H:i') }}</span>
              </div>
              <a href="{{ route('peserta.semifinal.payment.view') }}" target="_blank" class="btn-view-file">View</a>
            </div>

            @if($semifinalPayment->status === 'pending')
              <div class="status-message pending">
                <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                <span>Waiting for admin verification...</span>
              </div>
            @elseif($semifinalPayment->status === 'verified')
              <div class="status-message verified">
                <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
                  <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                </svg>
                <span>Payment verified! You can now upload semifinal submissions.</span>
                @if($semifinalPayment->verified_at)
                  <small>Verified at: {{ $semifinalPayment->verified_at->format('d M Y, H:i') }}</small>
                @endif
              </div>
            @elseif($semifinalPayment->status === 'rejected')
              <div class="status-message rejected">
                <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
                  <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/>
                </svg>
                <div>
                  <span>Payment rejected.</span>
                  @if($semifinalPayment->rejection_reason)
                    <p class="rejection-reason"><strong>Reason:</strong> {{ $semifinalPayment->rejection_reason }}</p>
                  @endif
                  <p>Please contact admin for more information.</p>
                </div>
              </div>
            @endif
          </div>
        @endif
      </div>
    </section>
    @endif

    {{-- Competition Submissions Section --}}
    @if($submissionConfig)
    <section class="section-submissions-full">
      <div class="section-header-with-progress">
        <h2 class="section-title">COMPETITION SUBMISSIONS</h2>
        @php
          $progress = $peserta->submission_progress;
        @endphp
        <div class="progress-inline">
          <span class="progress-text">{{ $progress['uploaded'] }}/{{ $progress['total'] }}</span>
          <div class="progress-bar-inline">
            <div class="progress-fill-inline" style="width: {{ $progress['percentage'] }}%;"></div>
          </div>
          <span class="progress-percentage-inline">{{ $progress['percentage'] }}%</span>
        </div>
      </div>

      {{-- Verification Notice --}}
      @if(!$peserta->isVerified())
      <div class="verification-notice">
        <div class="notice-icon">
          <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
        </div>
        <div class="notice-content">
          <h4>Akun Belum Terverifikasi</h4>
          <p>Anda harus menunggu verifikasi dari admin sebelum dapat mengunggah file submission.</p>
        </div>
      </div>
      @endif

      {{-- Semifinal Payment Notice --}}
      @if($peserta->isQualifiedForSemifinal() && !$peserta->canUploadSemifinalSubmission() && in_array('semifinal', config('submissions.active_stages', [])))
      <div class="verification-notice" style="background: #fef3c7; border-color: #fbbf24;">
        <div class="notice-icon" style="background: #fbbf24;">
          <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
          </svg>
        </div>
        <div class="notice-content">
          <h4>Semifinal Payment Required</h4>
          @if(!$peserta->hasUploadedSemifinalPayment())
            <p>Please upload your semifinal payment proof to access semifinal submissions. Check the "Semifinal Status" section above.</p>
          @elseif($peserta->semifinalPayment->status === 'pending')
            <p>Your semifinal payment is pending verification. Semifinal submissions will be available once your payment is verified.</p>
          @elseif($peserta->semifinalPayment->status === 'rejected')
            <p>Your semifinal payment was rejected. Please contact admin to resolve this issue before you can upload semifinal submissions.</p>
          @endif
        </div>
      </div>
      @endif

      {{-- Submissions by Stage --}}
      @php
        $stages = [];
        foreach ($submissionConfig['requirements'] as $req) {
          $stages[$req['stage']][] = $req;
        }
        $stageOrder = ['preliminary', 'semifinal', 'final'];
        $stageNames = [
          'preliminary' => 'Preliminary Round',
          'semifinal' => 'Semifinal Round', 
          'final' => 'Final Round',
        ];
        
        // Filter stages by active stages from config
        $activeStages = config('submissions.active_stages', ['preliminary']);
        $stageOrder = array_filter($stageOrder, function($stage) use ($activeStages, $peserta) {
          // Check if stage is active
          if (!in_array($stage, $activeStages)) {
            return false;
          }
          
          // For semifinal stage, check if team qualified and payment verified
          if ($stage === 'semifinal') {
            return $peserta->canUploadSemifinalSubmission();
          }
          
          // For final stage, add similar check if needed in the future
          if ($stage === 'final') {
            // Add final stage qualification check here if needed
            return true;
          }
          
          return true;
        });
      @endphp

      @foreach($stageOrder as $stage)
        @if(isset($stages[$stage]))
        <div class="stage-section">
          <h3 class="stage-title">{{ $stageNames[$stage] }}</h3>
          <div class="submissions-grid">
            @foreach($stages[$stage] as $requirement)
              @php
                $key = $requirement['type'] . '_' . $requirement['stage'];
                $submission = $existingSubmissions->get($key);
              @endphp
              <div class="submission-card" data-type="{{ $requirement['type'] }}" data-stage="{{ $requirement['stage'] }}">
                <div class="submission-header">
                  <h4>{{ $requirement['label'] }}</h4>
                  <span class="submission-status {{ $submission ? 'uploaded' : 'pending' }}">
                    {{ $submission ? '✓ Uploaded' : 'Belum Upload' }}
                  </span>
                </div>
                
                <p class="submission-description">{{ $requirement['description'] }}</p>

                {{-- Submission Guidelines for All Categories --}}
                <div class="submission-guidelines">
                  @if($kategori === 'business_case')
                    {{-- BCC Guidelines --}}
                    @if($requirement['type'] === 'essay' && $requirement['stage'] === 'preliminary')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>File Format:</strong> PDF</li>
                          <li><strong>Language:</strong> English (Mandatory)</li>
                          <li><strong>Page Limit:</strong> Maximum 5 Pages (Main content, excluding cover/references)</li>
                          <li><strong>Content Requirements:</strong> Must include Introduction, Methodology, Result, Novelty, Conclusion, & References</li>
                          <li><strong>Restriction:</strong> University logo must NOT be included in the document</li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>INCEPTION2026_BCC_Essay_TeamName_UnivName</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'full_paper' && $requirement['stage'] === 'semifinal')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>File Format:</strong> PDF</li>
                          <li><strong>Language:</strong> English (Mandatory)</li>
                          <li><strong>Page Limit:</strong> Maximum 15 Pages (Main content)</li>
                          <li><strong>Content:</strong> In-depth development of the previous essay</li>
                          <li><strong>Restriction:</strong> University logo must NOT be included</li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>INCEPTION2026_BCC_FullPaper_TeamName_UnivName</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'pitch_deck' && $requirement['stage'] === 'final')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>File Format:</strong> PPTX or PDF</li>
                          <li><strong>Slide Size:</strong> 16:9 Ratio (Widescreen)</li>
                          <li><strong>Slide Count:</strong> Maximum 20 Slides (Including cover & references)</li>
                          <li><strong>Language:</strong> English</li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>INCEPTION2026_BCC_PitchDeck_TeamName_UnivName</code>
                        </div>
                      </div>
                    @endif
                  @endif

                  @if($kategori === 'poster_paper')
                    {{-- PPC Guidelines --}}
                    @if($requirement['type'] === 'abstract' && $requirement['stage'] === 'preliminary')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Maximum <strong>1 A4 page</strong></li>
                          <li>Font: <strong>Times New Roman 12</strong></li>
                          <li>Spacing: <strong>1.15</strong></li>
                          <li>Margins: <strong>Left 2cm, Top 4cm, Bottom 3cm, Right 2cm</strong></li>
                          <li>Language: <strong>English or Bahasa Indonesia</strong></li>
                          <li>Format: <strong>PDF</strong></li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Abstract_Inception2026</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'full_paper' && $requirement['stage'] === 'semifinal')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Word count: <strong>7,000 - 10,000 words</strong></li>
                          <li>Structure: <strong>Abstract, Keywords, Introduction, Methods, Results & Discussion, Conclusion, References</strong></li>
                          <li>Use the <strong>provided template</strong> (download from guidebooks)</li>
                          <li>Language: <strong>English or Bahasa Indonesia</strong></li>
                          <li>Format: <strong>PDF</strong></li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Paper_Inception2026</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'poster' && $requirement['stage'] === 'semifinal')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Size: <strong>A3 (297 × 420 mm)</strong></li>
                          <li>Format: <strong>JPG/JPEG (High Resolution)</strong></li>
                          <li>Required logos: <strong>INCEPTION 2026, SPE STT Migas, SEG STT Migas</strong></li>
                          <li>Content: <strong>Team name, members, institution, title, background, methods, results, conclusion</strong></li>
                          <li>Language: <strong>English or Bahasa Indonesia</strong></li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Poster_Inception2026</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'presentation_slides' && $requirement['stage'] === 'final')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Format: <strong>PPTX</strong></li>
                          <li>Language: <strong>English mandatory</strong></li>
                          <li>No university logos or names allowed</li>
                          <li>Duration: <strong>10 minutes presentation + 5 minutes Q&A</strong></li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Presentation_Inception2026</code>
                        </div>
                      </div>
                    @endif
                  @endif

                  @if($kategori === 'well_stimulation')
                    {{-- WSC Guidelines --}}
                    @if($requirement['type'] === 'essay' && $requirement['stage'] === 'preliminary')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>Word Count:</strong> 400 – 600 words</li>
                          <li><strong>Page Format:</strong> Margin 2.54 cm (All sides)</li>
                          <li><strong>Typography:</strong> Times New Roman, Size 12, Line Spacing 1.15</li>
                          <li><strong>File Format:</strong> PDF</li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Essay_WSC_INCEPTION2026.pdf</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'final_case_report' && $requirement['stage'] === 'semifinal')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>Report Length:</strong> 20 – 50 pages</li>
                          <li><strong>Page Format:</strong> Margin 2.54 cm (All sides)</li>
                          <li><strong>Typography:</strong> Times New Roman, Size 12, Line Spacing 1.15</li>
                          <li><strong>File Format:</strong> PDF</li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_FinalReport_WSC_INCEPTION2026.pdf</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'turnitin_report' && $requirement['stage'] === 'semifinal')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>Mandatory Attachment:</strong> Turnitin Similarity Report</li>
                          <li><strong>File Format:</strong> PDF</li>
                        </ul>
                      </div>
                    @endif

                    @if($requirement['type'] === 'presentation_slides' && $requirement['stage'] === 'final')
                      <div class="guideline-content">
                        <h5>Requirements</h5>
                        <ul>
                          <li><strong>Slide Count:</strong> Maximum 15 Slides</li>
                          <li><strong>Language:</strong> English (Mandatory)</li>
                          <li><strong>Duration:</strong> 15 Minutes Presentation + Q&A</li>
                          <li><strong>Participation:</strong> All team members must participate</li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Presentation_WSC_INCEPTION2026.pdf</code>
                        </div>
                      </div>
                    @endif
                  @endif

                  @if($kategori === 'geothermal')
                    {{-- GDPC Guidelines --}}
                    @if($requirement['type'] === 'essay' && $requirement['stage'] === 'preliminary')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Maximum <strong>3,000 words</strong></li>
                          <li>Font: <strong>Times New Roman 12</strong></li>
                          <li>Spacing: <strong>1.5</strong></li>
                          <li>Margins: <strong>2.54 cm (all sides)</strong></li>
                          <li>Language: <strong>English or Bahasa Indonesia</strong></li>
                          <li>Format: <strong>PDF</strong></li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_Essay_GDPC_INCEPTION2026.pdf</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'final_report' && $requirement['stage'] === 'semifinal')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Maximum <strong>50 pages</strong></li>
                          <li>Must include: <strong>Geoscience & reservoir analysis, drilling & surface facilities, project economics, risk assessment & sustainability</strong></li>
                          <li>Language: <strong>English mandatory</strong></li>
                          <li>Format: <strong>PDF</strong></li>
                        </ul>
                        <div class="filename-box">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                          </svg>
                          <code>TeamName_FinalReport_GDPC_INCEPTION2026.pdf</code>
                        </div>
                      </div>
                    @endif

                    @if($requirement['type'] === 'presentation_slides' && $requirement['stage'] === 'final')
                      <div class="guideline-content">
                        <h5>Requirements:</h5>
                        <ul>
                          <li>Maximum <strong>20 slides</strong></li>
                          <li>Language: <strong>English mandatory</strong></li>
                          <li>Duration: <strong>15 minutes presentation + 30 minutes Q&A</strong></li>
                          <li>All team members <strong>must present</strong></li>
                          <li>Format: <strong>PPTX or PDF</strong></li>
                        </ul>
                      </div>
                    @endif
                  @endif
                </div>
                
                @if($submission)
                <div class="submission-file-info">
                  <div class="file-details">
                    <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
                      <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    <div class="file-meta">
                      <span class="file-name" title="{{ $submission->original_filename }}">{{ Str::limit($submission->original_filename, 25) }}</span>
                      <span class="file-size">{{ $submission->formatted_file_size }} • {{ $submission->uploaded_at->format('d M Y') }}</span>
                    </div>
                  </div>
                  <div class="file-actions">
                    <a href="{{ route('peserta.submissions.view', ['type' => $requirement['type'], 'stage' => $requirement['stage']]) }}" 
                       target="_blank" class="btn-action btn-view" title="Lihat File">
                      <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                      </svg>
                    </a>
                    <a href="{{ route('peserta.submissions.download', ['type' => $requirement['type'], 'stage' => $requirement['stage']]) }}" 
                       class="btn-action btn-download" title="Download">
                      <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                        <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                      </svg>
                    </a>
                  </div>
                </div>
                @endif

                <div class="submission-upload {{ $peserta->isVerified() ? '' : 'disabled' }}">
                  <div class="upload-dropzone" data-type="{{ $requirement['type'] }}" data-stage="{{ $requirement['stage'] }}" data-max-size="{{ $requirement['max_size'] }}">
                    <input type="file" 
                           id="file_{{ $requirement['type'] }}_{{ $requirement['stage'] }}" 
                           accept=".pdf,application/pdf" 
                           class="file-input-hidden"
                           {{ $peserta->isVerified() ? '' : 'disabled' }}>
                    <label for="file_{{ $requirement['type'] }}_{{ $requirement['stage'] }}" class="upload-label">
                      <div class="upload-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="28" height="28">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                      </div>
                      <span class="upload-text">{{ $submission ? 'Ganti File' : 'Upload PDF' }}</span>
                      <span class="upload-hint">Max {{ $requirement['max_size'] }} MB</span>
                    </label>
                  </div>
                  <div class="upload-progress" style="display: none;">
                    <div class="progress-bar-mini">
                      <div class="progress-fill"></div>
                    </div>
                    <span class="progress-status">Mengunggah...</span>
                  </div>
                </div>

                @if($submission && $peserta->isVerified())
                <button type="button" class="btn-delete-submission" 
                        data-type="{{ $requirement['type'] }}" 
                        data-stage="{{ $requirement['stage'] }}"
                        title="Hapus File">
                  <svg fill="currentColor" viewBox="0 0 24 24" width="14" height="14">
                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                  </svg>
                  Hapus
                </button>
                @endif
              </div>
            @endforeach
          </div>
        </div>
        @endif
      @endforeach
    </section>
    @endif

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
              <a href="{{ route('peserta.view-ktm', basename($peserta->ktm)) }}" target="_blank" class="btn-view-doc">View PDF</a>
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
              <a href="{{ route('peserta.view-follow-ig', basename($peserta->follow_ig)) }}" target="_blank" class="btn-view-doc">View PDF</a>
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
              <a href="{{ route('peserta.view-share-poster', basename($peserta->share_poster)) }}" target="_blank" class="btn-view-doc">View PDF</a>
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
              <a href="{{ route('peserta.view-payment', basename($peserta->payment)) }}" target="_blank" class="btn-view-doc">View PDF</a>
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
          
          @if($kategori === 'business_case')
            <div class="format-example">
              <p><strong>INCEPTION2026_BCC_[NAMA TIM]</strong></p>
              <p style="margin-top: 8px; color: #666; font-size: 12px;">(Contoh: INCEPTION2026_BCC_AlphaTeam)</p>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #FBB137;">
              <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #1a1a1a;">Ketentuan Upload Bukti Bayar</h4>
              <p style="margin: 0; font-size: 13px; color: #333;">
                <strong>Format Nama File:</strong> NamaPengirim_Bank_NamaTim_BCC<br>
                <span style="color: #666; font-size: 12px;">(Contoh: Dega_BCA_AlphaTeam_BCC)</span>
              </p>
            </div>
          @elseif($kategori === 'well_stimulation')
            <div class="format-example">
              <p><strong>INCEPTION2026_WSC_[NAMA TIM]</strong></p>
              <p style="margin-top: 8px; color: #666; font-size: 12px;">(Contoh: INCEPTION2026_WSC_AlphaTeam)</p>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #32477C;">
              <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #1a1a1a;">Ketentuan Upload Bukti Bayar</h4>
              <p style="margin: 0; font-size: 13px; color: #333;">
                <strong>Format Nama File:</strong> NamaPengirim_Bank_NamaTim_WSC<br>
                <span style="color: #666; font-size: 12px;">(Contoh: Dega_BCA_AlphaTeam_WSC)</span>
              </p>
            </div>
          @elseif($kategori === 'poster_paper')
            <div class="format-example">
              <p><strong>INCEPTION2026_PPC_[NAMA TIM]</strong></p>
              <p style="margin-top: 8px; color: #666; font-size: 12px;">(Contoh: INCEPTION2026_PPC_AlphaTeam)</p>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #4683B5;">
              <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #1a1a1a;">Ketentuan Upload Bukti Bayar</h4>
              <p style="margin: 0; font-size: 13px; color: #333;">
                <strong>Format Nama File:</strong> NamaPengirim_Bank_NamaTim_PPC<br>
                <span style="color: #666; font-size: 12px;">(Contoh: Dega_BCA_AlphaTeam_PPC)</span>
              </p>
            </div>
          @elseif($kategori === 'geothermal')
            <div class="format-example">
              <p><strong>INCEPTION2026_GDPC_[NAMA TIM]</strong></p>
              <p style="margin-top: 8px; color: #666; font-size: 12px;">(Contoh: INCEPTION2026_GDPC_AlphaTeam)</p>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 3px solid #B22A2A;">
              <h4 style="margin: 0 0 10px 0; font-size: 14px; color: #1a1a1a;">Ketentuan Upload Bukti Bayar</h4>
              <p style="margin: 0; font-size: 13px; color: #333;">
                <strong>Format Nama File:</strong> NamaPengirim_Bank_NamaTim_GDPC<br>
                <span style="color: #666; font-size: 12px;">(Contoh: Dega_BCA_AlphaTeam_GDPC)</span>
              </p>
            </div>
          @else
            <div class="format-example">
              <p>[NAMA TIM] - [NAMA KOMPETISI]</p>
            </div>
          @endif
          
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

<style>
.notification-badge {
  position: absolute;
  top: 8px;
  right: 8px;
  background: #ef4444;
  color: white;
  font-size: 11px;
  font-weight: 700;
  padding: 2px 6px;
  border-radius: 10px;
  min-width: 18px;
  text-align: center;
}

.nav-item {
  position: relative;
}

/* Semifinal Section Styles */
.section-semifinal {
  margin-bottom: 2rem;
}

.semifinal-congratulations {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 1.5rem;
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  border-radius: 12px;
  color: white;
  margin-bottom: 1.5rem;
  box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
}

.congrats-icon {
  flex-shrink: 0;
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
}

.congrats-content h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.25rem;
  font-weight: 700;
}

.congrats-content p {
  margin: 0 0 0.5rem 0;
  font-size: 1rem;
  opacity: 0.95;
}

.congrats-content small {
  font-size: 0.875rem;
  opacity: 0.85;
}

.semifinal-payment-section {
  background: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.subsection-title {
  margin: 0 0 1.5rem 0;
  font-size: 1.125rem;
  font-weight: 600;
  color: #1f2937;
}

.payment-upload-card {
  display: grid;
  gap: 1.5rem;
}

.payment-info h4 {
  margin: 0 0 0.75rem 0;
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
}

.payment-info p {
  margin: 0 0 1rem 0;
  color: #6b7280;
  font-size: 0.875rem;
}

.payment-details {
  display: grid;
  gap: 0.75rem;
  padding: 1rem;
  background: #f9fafb;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.payment-detail-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.payment-detail-item .label {
  color: #6b7280;
  font-size: 0.875rem;
}

.payment-detail-item strong {
  color: #1f2937;
  font-size: 0.875rem;
}

.payment-upload-form {
  display: grid;
  gap: 1rem;
}

.btn-upload-payment {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.875rem 1.5rem;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.9375rem;
  cursor: pointer;
  transition: all 0.2s;
  margin-top: 0.5rem;
}

.btn-upload-payment:hover {
  background: #2563eb;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
}

.payment-status-card {
  padding: 1.25rem;
  border-radius: 8px;
  border: 2px solid;
}

.payment-status-card.status-pending {
  background: #fef3c7;
  border-color: #fbbf24;
}

.payment-status-card.status-verified {
  background: #d1fae5;
  border-color: #10b981;
}

.payment-status-card.status-rejected {
  background: #fee2e2;
  border-color: #ef4444;
}

.status-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.status-header h4 {
  margin: 0;
  font-size: 1rem;
  font-weight: 600;
  color: #1f2937;
}

.status-badge {
  padding: 0.375rem 0.875rem;
  border-radius: 20px;
  font-size: 0.8125rem;
  font-weight: 600;
}

.status-badge.pending {
  background: #fbbf24;
  color: #78350f;
}

.status-badge.verified {
  background: #10b981;
  color: white;
}

.status-badge.rejected {
  background: #ef4444;
  color: white;
}

.payment-file-info {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: white;
  border-radius: 8px;
  margin-bottom: 1rem;
}

.payment-file-info svg {
  flex-shrink: 0;
  color: #6b7280;
}

.file-details {
  flex: 1;
  display: grid;
  gap: 0.25rem;
}

.file-details .filename {
  font-weight: 600;
  color: #1f2937;
  font-size: 0.9375rem;
}

.file-details .filesize,
.file-details .upload-date {
  color: #6b7280;
  font-size: 0.8125rem;
}

.btn-view-file {
  padding: 0.5rem 1rem;
  background: #3b82f6;
  color: white;
  text-decoration: none;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 600;
  transition: all 0.2s;
}

.btn-view-file:hover {
  background: #2563eb;
}

.status-message {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1rem;
  border-radius: 8px;
}

.status-message.pending {
  background: rgba(251, 191, 36, 0.1);
}

.status-message.verified {
  background: rgba(16, 185, 129, 0.1);
}

.status-message.rejected {
  background: rgba(239, 68, 68, 0.1);
}

.status-message svg {
  flex-shrink: 0;
  margin-top: 0.125rem;
}

.status-message.pending svg {
  color: #d97706;
}

.status-message.verified svg {
  color: #059669;
}

.status-message.rejected svg {
  color: #dc2626;
}

.status-message span {
  font-weight: 600;
  color: #1f2937;
  font-size: 0.9375rem;
}

.status-message small {
  display: block;
  margin-top: 0.25rem;
  color: #6b7280;
  font-size: 0.8125rem;
}

.rejection-reason {
  margin: 0.5rem 0;
  padding: 0.75rem;
  background: rgba(0, 0, 0, 0.05);
  border-radius: 6px;
  font-size: 0.875rem;
}
</style>

{{-- Toast Notification --}}
<div id="toast-notification" class="toast-notification" style="display: none;">
  <div class="toast-icon"></div>
  <div class="toast-message"></div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="modal-overlay" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Konfirmasi Hapus</h3>
      <button type="button" class="modal-close">&times;</button>
    </div>
    <div class="modal-body">
      <p>Apakah Anda yakin ingin menghapus file submission ini?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn-modal-cancel">Batal</button>
      <button type="button" class="btn-modal-confirm">Hapus</button>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // File upload handling
    document.querySelectorAll('.upload-dropzone').forEach(dropzone => {
        const fileInput = dropzone.querySelector('.file-input-hidden');
        const type = dropzone.dataset.type;
        const stage = dropzone.dataset.stage;
        const maxSize = parseInt(dropzone.dataset.maxSize) * 1024 * 1024;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.add('dragover'), false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => dropzone.classList.remove('dragover'), false);
        });
        
        dropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileUpload(files[0], type, stage, maxSize, dropzone);
            }
        });
        
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0], type, stage, maxSize, dropzone);
            }
        });
    });
    
    function handleFileUpload(file, type, stage, maxSize, dropzone) {
        if (file.type !== 'application/pdf') {
            showToast('error', 'Hanya file PDF yang diperbolehkan.');
            return;
        }
        
        if (file.size > maxSize) {
            const maxSizeMB = maxSize / (1024 * 1024);
            showToast('error', `Ukuran file melebihi batas maksimum ${maxSizeMB} MB.`);
            return;
        }
        
        const card = dropzone.closest('.submission-card');
        const uploadProgress = card.querySelector('.upload-progress');
        const progressFill = uploadProgress.querySelector('.progress-fill');
        const progressStatus = uploadProgress.querySelector('.progress-status');
        
        dropzone.style.display = 'none';
        uploadProgress.style.display = 'block';
        
        const formData = new FormData();
        formData.append('file', file);
        formData.append('submission_type', type);
        formData.append('stage', stage);
        formData.append('_token', csrfToken);
        
        const xhr = new XMLHttpRequest();
        
        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressFill.style.width = percent + '%';
                progressStatus.textContent = `Mengunggah... ${percent}%`;
            }
        });
        
        xhr.addEventListener('load', () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    showToast('success', response.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast('error', response.message);
                    resetUpload(dropzone, uploadProgress);
                }
            } else {
                try {
                    const response = JSON.parse(xhr.responseText);
                    showToast('error', response.message || 'Terjadi kesalahan.');
                } catch {
                    showToast('error', 'Terjadi kesalahan saat mengunggah file.');
                }
                resetUpload(dropzone, uploadProgress);
            }
        });
        
        xhr.addEventListener('error', () => {
            showToast('error', 'Terjadi kesalahan jaringan.');
            resetUpload(dropzone, uploadProgress);
        });
        
        xhr.open('POST', '{{ route("peserta.submissions.upload") }}');
        xhr.send(formData);
    }
    
    function resetUpload(dropzone, uploadProgress) {
        dropzone.style.display = 'block';
        uploadProgress.style.display = 'none';
        const progressFill = uploadProgress.querySelector('.progress-fill');
        progressFill.style.width = '0%';
    }
    
    // Delete submission handling
    let deleteType = null;
    let deleteStage = null;
    const deleteModal = document.getElementById('delete-modal');
    
    document.querySelectorAll('.btn-delete-submission').forEach(btn => {
        btn.addEventListener('click', () => {
            deleteType = btn.dataset.type;
            deleteStage = btn.dataset.stage;
            deleteModal.style.display = 'flex';
        });
    });
    
    document.querySelector('.modal-close')?.addEventListener('click', closeDeleteModal);
    document.querySelector('.btn-modal-cancel')?.addEventListener('click', closeDeleteModal);
    
    deleteModal?.addEventListener('click', (e) => {
        if (e.target === deleteModal) closeDeleteModal();
    });
    
    function closeDeleteModal() {
        deleteModal.style.display = 'none';
        deleteType = null;
        deleteStage = null;
    }
    
    document.querySelector('.btn-modal-confirm')?.addEventListener('click', () => {
        if (!deleteType || !deleteStage) return;
        
        fetch('{{ route("peserta.submissions.delete") }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                submission_type: deleteType,
                stage: deleteStage,
            }),
        })
        .then(response => response.json())
        .then(data => {
            closeDeleteModal();
            if (data.success) {
                showToast('success', data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast('error', data.message);
            }
        })
        .catch(() => {
            closeDeleteModal();
            showToast('error', 'Terjadi kesalahan.');
        });
    });
    
    function showToast(type, message) {
        const toast = document.getElementById('toast-notification');
        const icon = toast.querySelector('.toast-icon');
        const msg = toast.querySelector('.toast-message');
        
        toast.className = 'toast-notification ' + type;
        msg.textContent = message;
        
        if (type === 'success') {
            icon.innerHTML = '<svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>';
        } else {
            icon.innerHTML = '<svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>';
        }
        
        toast.style.display = 'flex';
        
        setTimeout(() => {
            toast.style.display = 'none';
        }, 4000);
    }

    // Semifinal payment upload handling
    const paymentFileInput = document.getElementById('payment_proof');
    const submitPaymentBtn = document.getElementById('submitPaymentBtn');
    const paymentDropzone = document.getElementById('semifinalPaymentDropzone');
    
    if (paymentFileInput && submitPaymentBtn && paymentDropzone) {
        // Handle file selection
        paymentFileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const fileName = file.name;
                const fileSize = (file.size / (1024 * 1024)).toFixed(2); // MB
                
                // Update dropzone to show selected file
                const uploadText = paymentDropzone.querySelector('.upload-text');
                const uploadHint = paymentDropzone.querySelector('.upload-hint');
                
                if (uploadText && uploadHint) {
                    uploadText.textContent = fileName;
                    uploadHint.textContent = fileSize + ' MB';
                }
                
                // Show submit button
                submitPaymentBtn.style.display = 'flex';
            }
        });
        
        // Handle drag and drop for payment
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            paymentDropzone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            paymentDropzone.addEventListener(eventName, () => paymentDropzone.classList.add('dragover'), false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            paymentDropzone.addEventListener(eventName, () => paymentDropzone.classList.remove('dragover'), false);
        });
        
        paymentDropzone.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                
                // Validate file type
                const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    showToast('error', 'Hanya file PDF, JPG, atau PNG yang diperbolehkan.');
                    return;
                }
                
                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    showToast('error', 'Ukuran file melebihi batas maksimum 10 MB.');
                    return;
                }
                
                // Create a DataTransfer to set files
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                paymentFileInput.files = dataTransfer.files;
                
                // Trigger change event
                const event = new Event('change', { bubbles: true });
                paymentFileInput.dispatchEvent(event);
            }
        });
    }
});
</script>
@endpush
@endsection