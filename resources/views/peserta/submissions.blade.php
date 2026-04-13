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
      <a href="{{ route('peserta.submissions.index') }}" class="nav-item active">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11zM8 15.01l1.41 1.41L11 14.84V19h2v-4.16l1.59 1.59L16 15.01 12.01 11 8 15.01z"/>
        </svg>
        <span>Submissions</span>
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
      <h1>{{ strtoupper($submissionConfig['name']) }} - SUBMISSIONS</h1>
      <div class="header-buttons">
        <a href="{{ asset($competition['guidebook']) }}" class="btn-guidebook" target="_blank">
          <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
          </svg>
          Download Guidebook
        </a>
        @if($peserta->kategori === 'geothermal' && $semifinalQualifier)
        <a href="{{ asset('case/FinalCase_GDPC_INCEPTION_2026.rar') }}" class="btn-case-semifinal" download="FinalCase_GDPC_INCEPTION_2026.rar">
          <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
          </svg>
          Case Semifinal
        </a>
        @endif
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
        <p>Anda harus menunggu verifikasi dari admin sebelum dapat mengunggah file submission. Pastikan semua dokumen pendaftaran sudah lengkap.</p>
      </div>
    </div>
    @endif

    {{-- Submission Progress --}}
    <section class="section-progress">
      <h2 class="section-title">PROGRESS SUBMISSION</h2>
      <div class="progress-card">
        @php
          $progress = $peserta->submission_progress;
        @endphp
        <div class="progress-info">
          <span class="progress-text">{{ $progress['uploaded'] }} dari {{ $progress['total'] }} file terunggah</span>
          <span class="progress-percentage">{{ $progress['percentage'] }}%</span>
        </div>
        <div class="progress-bar-container">
          <div class="progress-bar" style="width: {{ $progress['percentage'] }}%;"></div>
        </div>
      </div>
    </section>

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
      
      // Filter stages by active stages
      $stageOrder = array_filter($stageOrder, function($stage) use ($activeStages) {
        return in_array($stage, $activeStages);
      });
    @endphp

    @foreach($stageOrder as $stage)
      @if(isset($stages[$stage]))
      <section class="section-submissions">
        <h2 class="section-title">{{ strtoupper($stageNames[$stage]) }}</h2>
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
              
              @if($submission)
              <div class="submission-file-info">
                <div class="file-details">
                  <svg fill="currentColor" viewBox="0 0 24 24" width="20" height="20">
                    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                  </svg>
                  <div class="file-meta">
                    <span class="file-name" title="{{ $submission->original_filename }}">{{ Str::limit($submission->original_filename, 30) }}</span>
                    <span class="file-size">{{ $submission->formatted_file_size }} • {{ $submission->uploaded_at->format('d M Y, H:i') }}</span>
                  </div>
                </div>
                <div class="file-actions">
                  <a href="{{ route('peserta.submissions.view', ['type' => $requirement['type'], 'stage' => $requirement['stage']]) }}" 
                     target="_blank" class="btn-action btn-view" title="Lihat File">
                    <svg fill="currentColor" viewBox="0 0 24 24" width="18" height="18">
                      <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                  </a>
                  <a href="{{ route('peserta.submissions.download', ['type' => $requirement['type'], 'stage' => $requirement['stage']]) }}" 
                     class="btn-action btn-download" title="Download">
                    <svg fill="currentColor" viewBox="0 0 24 24" width="18" height="18">
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
                      <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" width="32" height="32">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                      </svg>
                    </div>
                    <span class="upload-text">{{ $submission ? 'Ganti File' : 'Upload PDF' }}</span>
                    <span class="upload-hint">Maksimum {{ $requirement['max_size'] }} MB</span>
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
                <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                  <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                </svg>
                Hapus
              </button>
              @endif
            </div>
          @endforeach
        </div>
      </section>
      @endif
    @endforeach

    {{-- Submission Guidelines --}}
    <section class="section-guidelines">
      <h2 class="section-title">PANDUAN SUBMISSION</h2>
      <div class="guidelines-card">
        <div class="guideline-item">
          <div class="guideline-icon">
            <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
              <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
            </svg>
          </div>
          <div class="guideline-content">
            <h4>Format File</h4>
            <p>Semua file submission harus dalam format <strong>PDF</strong>.</p>
          </div>
        </div>
        <div class="guideline-item">
          <div class="guideline-icon">
            <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
              <path d="M2 20h20v-4H2v4zm2-3h2v2H4v-2zM2 4v4h20V4H2zm4 3H4V5h2v2zm-4 7h20v-4H2v4zm2-3h2v2H4v-2z"/>
            </svg>
          </div>
          <div class="guideline-content">
            <h4>Ukuran File</h4>
            <p>Perhatikan batas maksimum ukuran file untuk setiap jenis submission.</p>
          </div>
        </div>
        <div class="guideline-item">
          <div class="guideline-icon">
            <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
              <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
          </div>
          <div class="guideline-content">
            <h4>Penyimpanan</h4>
            <p>File yang diunggah akan menggantikan file sebelumnya untuk jenis submission yang sama.</p>
          </div>
        </div>
        <div class="guideline-item">
          <div class="guideline-icon">
            <svg fill="currentColor" viewBox="0 0 24 24" width="24" height="24">
              <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
          </div>
          <div class="guideline-content">
            <h4>Deadline</h4>
            <p>Pastikan mengunggah file sebelum batas waktu yang ditentukan. Lihat guidebook untuk lebih detail.</p>
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
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // File upload handling
    document.querySelectorAll('.upload-dropzone').forEach(dropzone => {
        const fileInput = dropzone.querySelector('.file-input-hidden');
        const type = dropzone.dataset.type;
        const stage = dropzone.dataset.stage;
        const maxSize = parseInt(dropzone.dataset.maxSize) * 1024 * 1024; // Convert to bytes
        
        // Drag and drop events
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
        
        // Click to upload
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0], type, stage, maxSize, dropzone);
            }
        });
    });
    
    function handleFileUpload(file, type, stage, maxSize, dropzone) {
        // Validate file type
        if (file.type !== 'application/pdf') {
            showToast('error', 'Hanya file PDF yang diperbolehkan.');
            return;
        }
        
        // Validate file size
        if (file.size > maxSize) {
            const maxSizeMB = maxSize / (1024 * 1024);
            showToast('error', `Ukuran file melebihi batas maksimum ${maxSizeMB} MB.`);
            return;
        }
        
        const card = dropzone.closest('.submission-card');
        const uploadProgress = card.querySelector('.upload-progress');
        const progressFill = uploadProgress.querySelector('.progress-fill');
        const progressStatus = uploadProgress.querySelector('.progress-status');
        
        // Show progress
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
                    // Reload page to show updated submission
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
    
    // Toast notification
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
});
</script>
@endpush
@endsection
