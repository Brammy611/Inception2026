@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin-peserta.css') }}">
@endsection

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <div>
      <h1>Semifinal Payment Management</h1>
      <p>Monitor and verify semifinal payment proofs</p>
    </div>
  </div>

  {{-- Alert Messages --}}
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-error">
      {{ session('error') }}
    </div>
  @endif

  {{-- Statistics Cards --}}
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon total">
        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
          <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
      </div>
      <div class="stat-info">
        <h3>Total Payments</h3>
        <p>{{ $statistics['total'] }}</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon verified">
        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="stat-info">
        <h3>Verified</h3>
        <p>{{ $statistics['verified'] }}</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon pending">
        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
          <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="stat-info">
        <h3>Pending</h3>
        <p>{{ $statistics['pending'] }}</p>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon rejected">
        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
          <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div class="stat-info">
        <h3>Rejected</h3>
        <p>{{ $statistics['rejected'] }}</p>
      </div>
    </div>
  </div>

  {{-- Filters --}}
  <div class="filters-section">
    <form method="GET" class="filters-form">
      <div class="form-group">
        <label>Search Team</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by team name...">
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Status</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
          <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category">
          <option value="all" {{ request('category') === 'all' ? 'selected' : '' }}>All Categories</option>
          <option value="business_case" {{ request('category') === 'business_case' ? 'selected' : '' }}>Business Case</option>
          <option value="geothermal" {{ request('category') === 'geothermal' ? 'selected' : '' }}>Geothermal</option>
          <option value="poster_paper" {{ request('category') === 'poster_paper' ? 'selected' : '' }}>Poster Paper</option>
          <option value="well_stimulation" {{ request('category') === 'well_stimulation' ? 'selected' : '' }}>Well Stimulation</option>
        </select>
      </div>

      <button type="submit" class="btn-filter">Apply Filters</button>
      <a href="{{ route('admin.semifinal-payments.index') }}" class="btn-reset">Reset</a>
    </form>
  </div>

  {{-- Payments Table --}}
  <div class="table-container">
    <table class="data-table">
      <thead>
        <tr>
          <th>Team Name</th>
          <th>Competition</th>
          <th>File</th>
          <th>Uploaded At</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($payments as $payment)
        <tr>
          <td>
            <strong>{{ $payment->peserta->nama_tim }}</strong>
            <br>
            <small>{{ $payment->peserta->asal_univ }}</small>
          </td>
          <td>
            @php
              $categoryMap = [
                'business_case' => 'BCC',
                'geothermal' => 'GDPC',
                'poster_paper' => 'PPC',
                'well_stimulation' => 'WSC',
              ];
              $shortName = $categoryMap[$payment->semifinalQualifier->competition_category] ?? 'Unknown';
            @endphp
            <span class="badge badge-category">{{ $shortName }}</span>
          </td>
          <td>
            <small>{{ $payment->original_filename }}</small>
            <br>
            <small class="text-muted">{{ $payment->file_size_human }}</small>
          </td>
          <td>{{ $payment->uploaded_at->format('d M Y, H:i') }}</td>
          <td>
            <span class="status-badge status-{{ $payment->status }}">
              {{ ucfirst($payment->status) }}
            </span>
          </td>
          <td>
            <div class="action-buttons">
              <a href="{{ route('admin.semifinal-payments.view', $payment) }}" target="_blank" class="btn-action btn-view" title="View Payment Proof">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <span class="btn-text">View</span>
              </a>
              
              @if($payment->status === 'pending')
              <form action="{{ route('admin.semifinal-payments.verify', $payment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to verify this payment? The team will be able to upload semifinal submissions.')">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-action btn-verify" title="Verify Payment">
                  <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <span class="btn-text">Verify</span>
                </button>
              </form>
              
              <button type="button" class="btn-action btn-reject" title="Reject Payment" onclick="showRejectModal({{ $payment->id }})">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="btn-text">Reject</span>
              </button>
              @endif
              
              @if($payment->status === 'verified')
              <span class="badge-status badge-verified">✓ Verified</span>
              @endif
              
              @if($payment->status === 'rejected')
              <span class="badge-status badge-rejected">✗ Rejected</span>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align: center; padding: 2rem;">
            <p style="color: #6b7280;">No payments found</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($payments->hasPages())
    <div class="pagination-container">
      {{ $payments->appends(request()->query())->links() }}
    </div>
  @endif
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="modal" style="display: none;">
  <div class="modal-content">
    <div class="modal-header">
      <h3>Reject Payment</h3>
      <button type="button" class="modal-close" onclick="closeRejectModal()">&times;</button>
    </div>
    <form id="rejectForm" method="POST">
      @csrf
      @method('PATCH')
      <div class="modal-body">
        <div class="form-group">
          <label for="rejection_reason">Rejection Reason *</label>
          <textarea id="rejection_reason" name="rejection_reason" rows="4" required placeholder="Please explain why this payment is rejected..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeRejectModal()">Cancel</button>
        <button type="submit" class="btn-confirm">Reject Payment</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function showRejectModal(paymentId) {
  const modal = document.getElementById('rejectModal');
  const form = document.getElementById('rejectForm');
  form.action = `/admin/semifinal-payments/${paymentId}/reject`;
  modal.style.display = 'flex';
}

function closeRejectModal() {
  const modal = document.getElementById('rejectModal');
  modal.style.display = 'none';
  document.getElementById('rejection_reason').value = '';
}

// Close modal when clicking outside
window.onclick = function(event) {
  const modal = document.getElementById('rejectModal');
  if (event.target === modal) {
    closeRejectModal();
  }
}
</script>
@endpush

<style>
.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  align-items: center;
  justify-content: center;
}

.modal-content {
  background-color: #fefefe;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #e5e7eb;
}

.modal-header h3 {
  margin: 0;
  font-size: 1.25rem;
  color: #1f2937;
}

.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #6b7280;
}

.modal-body {
  padding: 1.5rem;
}

.modal-body .form-group {
  margin-bottom: 0;
}

.modal-body label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #374151;
}

.modal-body textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  font-family: inherit;
  font-size: 0.9375rem;
  resize: vertical;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
  padding: 1.5rem;
  border-top: 1px solid #e5e7eb;
}

.btn-cancel, .btn-confirm {
  padding: 0.625rem 1.25rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-cancel {
  background: #f3f4f6;
  color: #374151;
}

.btn-cancel:hover {
  background: #e5e7eb;
}

.btn-confirm {
  background: #ef4444;
  color: white;
}

.btn-confirm:hover {
  background: #dc2626;
}

.action-buttons {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.btn-action {
  padding: 0.5rem 0.75rem;
  border: 1.5px solid;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s;
  font-weight: 500;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.375rem;
  text-decoration: none;
  white-space: nowrap;
}

.btn-text {
  font-size: 0.875rem;
  line-height: 1;
}

.btn-view {
  background: #eff6ff;
  border-color: #3b82f6;
  color: #3b82f6;
}

.btn-view:hover {
  background: #3b82f6;
  color: white;
}

.btn-verify {
  background: #d1fae5;
  border-color: #10b981;
  color: #10b981;
}

.btn-verify:hover {
  background: #10b981;
  color: white;
}

.btn-reject {
  background: #fee2e2;
  border-color: #ef4444;
  color: #ef4444;
}

.btn-reject:hover {
  background: #ef4444;
  color: white;
}

.badge-status {
  padding: 0.5rem 0.875rem;
  border-radius: 6px;
  font-size: 0.875rem;
  font-weight: 600;
  white-space: nowrap;
}

.badge-verified {
  background: #d1fae5;
  color: #065f46;
  border: 1.5px solid #10b981;
}

.badge-rejected {
  background: #fee2e2;
  color: #991b1b;
  border: 1.5px solid #ef4444;
}

.badge-category {
  padding: 0.25rem 0.625rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
  color: white;
  background: #6b7280;
}

.text-muted {
  color: #9ca3af;
  font-size: 0.8125rem;
}

.alert {
  padding: 1rem 1.5rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.alert-success {
  background: #d1fae5;
  color: #065f46;
  border: 1px solid #6ee7b7;
}

.alert-error {
  background: #fee2e2;
  color: #991b1b;
  border: 1px solid #fca5a5;
}

.btn-reset {
  padding: 0.625rem 1.5rem;
  background: white;
  color: #6b7280;
  border: 1.5px solid #d1d5db;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
  display: inline-block;
}

.btn-reset:hover {
  background: #f9fafb;
  border-color: #9ca3af;
}

/* Responsive Modal */
@media (max-width: 768px) {
  .modal-content {
    width: 95%;
    max-width: none;
    margin: 1rem;
  }

  .modal-header,
  .modal-body,
  .modal-footer {
    padding: 1rem;
  }

  .modal-header h3 {
    font-size: 1.125rem;
  }

  .modal-footer {
    flex-direction: column;
  }

  .btn-cancel,
  .btn-confirm {
    width: 100%;
  }

  .action-buttons {
    flex-wrap: wrap;
  }

  .btn-action {
    padding: 0.375rem 0.625rem;
    font-size: 0.875rem;
  }

  .btn-text {
    display: none;
  }

  .badge-status {
    padding: 0.375rem 0.625rem;
    font-size: 0.75rem;
  }
}
</style>
@endsection
