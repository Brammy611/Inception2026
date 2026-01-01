@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin-peserta.css') }}">
@endsection

@section('content')
<div class="admin-container">
  <div class="detail-header">
    <div>
      <a href="{{ route('admin.peserta.index') }}" class="btn-back">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to List
      </a>
      <h1>Participant Details</h1>
      <p>{{ $peserta->nama_tim }} - {{ $peserta->nama_leader }}</p>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="detail-grid">
    {{-- Team Information --}}
    <div class="detail-card">
      <div class="card-header" style="border-left: 5px solid {{ $competition['color'] ?? '#FBB137' }};">
        <h2>Team Information</h2>
        <span class="category-badge-large" style="background: {{ $competition['color'] ?? '#FBB137' }};">
          {{ $competition['name'] ?? 'Competition' }}
        </span>
      </div>
      <div class="card-body">
        <div class="info-row">
          <span class="label">Team Name:</span>
          <span class="value">{{ $peserta->nama_tim }}</span>
        </div>
        <div class="info-row">
          <span class="label">University:</span>
          <span class="value">{{ $peserta->asal_univ }}</span>
        </div>
        <div class="info-row">
          <span class="label">Registration Date:</span>
          <span class="value">{{ $peserta->created_at->format('d F Y, H:i') }}</span>
        </div>
        <div class="info-row">
          <span class="label">Email:</span>
          <span class="value">{{ $peserta->user->email }}</span>
        </div>
        <div class="info-row">
          <span class="label">Status:</span>
          <span class="status-badge status-{{ $peserta->status_verifikasi }}">
            {{ ucfirst($peserta->status_verifikasi) }}
          </span>
        </div>
      </div>
    </div>

    {{-- Members Information --}}
    <div class="detail-card">
      <div class="card-header">
        <h2>Team Members</h2>
      </div>
      <div class="card-body">
        <div class="member-section">
          <h3>Leader</h3>
          <div class="info-row">
            <span class="label">Name:</span>
            <span class="value">{{ $peserta->nama_leader }}</span>
          </div>
          <div class="info-row">
            <span class="label">Major:</span>
            <span class="value">{{ $peserta->jurusan_leader }}</span>
          </div>
        </div>

        <div class="member-section">
          <h3>Member 1</h3>
          <div class="info-row">
            <span class="label">Name:</span>
            <span class="value">{{ $peserta->nama_member_1 ?? '-' }}</span>
          </div>
          <div class="info-row">
            <span class="label">Major:</span>
            <span class="value">{{ $peserta->jurusan_member_1 ?? '-' }}</span>
          </div>
        </div>

        @if($peserta->nama_member_2)
        <div class="member-section">
          <h3>Member 2</h3>
          <div class="info-row">
            <span class="label">Name:</span>
            <span class="value">{{ $peserta->nama_member_2 }}</span>
          </div>
          <div class="info-row">
            <span class="label">Major:</span>
            <span class="value">{{ $peserta->jurusan_member_2 }}</span>
          </div>
        </div>
        @endif
      </div>
    </div>

    {{-- Documents --}}
    <div class="detail-card full-width">
      <div class="card-header">
        <h2>Uploaded Documents</h2>
      </div>
      <div class="card-body">
        <div class="documents-grid">
          {{-- KTM --}}
          <div class="document-item">
            <div class="doc-header">
              <h4>KTM (Student ID Card)</h4>
              @if($peserta->ktm)
                <span class="doc-status uploaded">✓ Uploaded</span>
              @else
                <span class="doc-status missing">✗ Not Uploaded</span>
              @endif
            </div>
            @if($peserta->ktm)
              <a href="{{ route('admin.peserta.view-ktm', basename($peserta->ktm)) }}" target="_blank" class="btn-view-doc">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Document
              </a>
            @endif
          </div>

          {{-- Follow IG --}}
          <div class="document-item">
            <div class="doc-header">
              <h4>Follow Instagram Proof</h4>
              @if($peserta->follow_ig)
                <span class="doc-status uploaded">✓ Uploaded</span>
              @else
                <span class="doc-status missing">✗ Not Uploaded</span>
              @endif
            </div>
            @if($peserta->follow_ig)
              <a href="{{ route('admin.peserta.view-follow-ig', basename($peserta->follow_ig)) }}" target="_blank" class="btn-view-doc">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Document
              </a>
            @endif
          </div>

          {{-- Share Poster --}}
          <div class="document-item">
            <div class="doc-header">
              <h4>Share Poster Proof</h4>
              @if($peserta->share_poster)
                <span class="doc-status uploaded">✓ Uploaded</span>
              @else
                <span class="doc-status missing">✗ Not Uploaded</span>
              @endif
            </div>
            @if($peserta->share_poster)
              <a href="{{ route('admin.peserta.view-share-poster', basename($peserta->share_poster)) }}" target="_blank" class="btn-view-doc">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Document
              </a>
            @endif
          </div>

          {{-- Payment --}}
          <div class="document-item">
            <div class="doc-header">
              <h4>Payment Proof</h4>
              @if($peserta->payment)
                <span class="doc-status uploaded">✓ Uploaded</span>
              @else
                <span class="doc-status missing">✗ Not Uploaded</span>
              @endif
            </div>
            @if($peserta->payment)
              <a href="{{ route('admin.peserta.view-payment', basename($peserta->payment)) }}" target="_blank" class="btn-view-doc">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Document
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Actions --}}
    <div class="detail-card full-width">
      <div class="card-header">
        <h2>Actions</h2>
      </div>
      <div class="card-body">
        <div class="action-buttons-group">
          {{-- Update Status --}}
          <form method="POST" action="{{ route('admin.peserta.update-status', $peserta) }}" class="status-form">
            @csrf
            @method('PATCH')
            <label>Update Status:</label>
            <div class="status-controls">
              <select name="status" class="status-select" required>
                <option value="pending" {{ $peserta->status_verifikasi == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ $peserta->status_verifikasi == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ $peserta->status_verifikasi == 'rejected' ? 'selected' : '' }}>Rejected</option>
              </select>
              <button type="submit" class="btn-update">Update Status</button>
            </div>
          </form>

          {{-- Delete --}}
          <form method="POST" action="{{ route('admin.peserta.destroy', $peserta) }}" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this participant? This will also delete the associated user account.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
              Delete Participant
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
