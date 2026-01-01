@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin-peserta.css') }}">
@endsection

@section('content')
<div class="admin-container">
  <div class="admin-header">
    <div>
      <h1>Competition Participants Management</h1>
      <p>Monitor and manage all competition participants</p>
    </div>
    <a href="{{ route('admin.peserta.export', request()->query()) }}" class="btn-export">
      <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
      </svg>
      Export CSV
    </a>
  </div>

  {{-- Statistics Cards --}}
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon total">
        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
          <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
      </div>
      <div class="stat-info">
        <h3>Total Participants</h3>
        <p>{{ $stats['total'] }}</p>
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
        <p>{{ $stats['verified'] }}</p>
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
        <p>{{ $stats['pending'] }}</p>
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
        <p>{{ $stats['rejected'] }}</p>
      </div>
    </div>
  </div>

  {{-- Category Breakdown --}}
  <div class="category-breakdown">
    <h2>By Competition Category</h2>
    <div class="category-list">
      <div class="category-item" style="border-left-color: #FBB137;">
        <span>Business Case Competition</span>
        <span>{{ $stats['business_case'] }}</span>
      </div>
      <div class="category-item" style="border-left-color: #B22A2A;">
        <span>Geothermal Drilling Paper</span>
        <span>{{ $stats['geothermal'] }}</span>
      </div>
      <div class="category-item" style="border-left-color: #4683B5;">
        <span>Petroleum Paper Competition</span>
        <span>{{ $stats['poster_paper'] }}</span>
      </div>
      <div class="category-item" style="border-left-color: #32477C;">
        <span>Well Stimulation Competition</span>
        <span>{{ $stats['well_stimulation'] }}</span>
      </div>
    </div>
  </div>

  {{-- Filters --}}
  <div class="filters-section">
    <form method="GET" class="filters-form">
      <div class="form-group">
        <label>Search</label>
        <input 
          type="text" 
          name="search" 
          placeholder="Search by team name, leader, or university..." 
          value="{{ request('search') }}"
        >
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="kategori">
          <option value="">All Categories</option>
          <option value="business_case" {{ request('kategori') == 'business_case' ? 'selected' : '' }}>Business Case</option>
          <option value="geothermal" {{ request('kategori') == 'geothermal' ? 'selected' : '' }}>Geothermal</option>
          <option value="poster_paper" {{ request('kategori') == 'poster_paper' ? 'selected' : '' }}>Poster & Paper</option>
          <option value="well_stimulation" {{ request('kategori') == 'well_stimulation' ? 'selected' : '' }}>Well Stimulation</option>
        </select>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status">
          <option value="">All Status</option>
          <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
          <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
      </div>

      <button type="submit" class="btn-filter">Filter</button>

      @if(request()->hasAny(['search', 'kategori', 'status']))
        <a href="{{ route('admin.peserta.index') }}" class="btn-clear">Clear</a>
      @endif
    </form>
  </div>

  {{-- Participants Table --}}
  <div class="table-container">
    <table class="data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Team Name</th>
          <th>Category</th>
          <th>Leader</th>
          <th>University</th>
          <th>Status</th>
          <th>Documents</th>
          <th>Registered</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($peserta as $p)
        <tr>
          <td>#{{ $p->id }}</td>
          <td>
            <strong>{{ $p->nama_tim }}</strong>
          </td>
          <td>
            @php
              $categoryColors = [
                'business_case' => '#FBB137',
                'geothermal' => '#B22A2A',
                'poster_paper' => '#4683B5',
                'well_stimulation' => '#32477C'
              ];
              $categoryNames = [
                'business_case' => 'BCC',
                'geothermal' => 'GDPC',
                'poster_paper' => 'PPC',
                'well_stimulation' => 'WSC'
              ];
            @endphp
            <span class="category-badge" style="background: {{ $categoryColors[$p->kategori] }};">
              {{ $categoryNames[$p->kategori] }}
            </span>
          </td>
          <td>{{ $p->nama_leader }}</td>
          <td>{{ $p->asal_univ }}</td>
          <td>
            <span class="status-badge status-{{ $p->status_verifikasi }}">
              {{ ucfirst($p->status_verifikasi) }}
            </span>
          </td>
          <td>
            <div class="doc-indicators">
              <span class="doc-indicator {{ $p->ktm ? 'uploaded' : 'missing' }}" title="KTM">K</span>
              <span class="doc-indicator {{ $p->follow_ig ? 'uploaded' : 'missing' }}" title="Follow IG">F</span>
              <span class="doc-indicator {{ $p->share_poster ? 'uploaded' : 'missing' }}" title="Share Poster">S</span>
              <span class="doc-indicator {{ $p->payment ? 'uploaded' : 'missing' }}" title="Payment">P</span>
            </div>
          </td>
          <td>{{ $p->created_at->format('d M Y') }}</td>
          <td>
            <div class="action-buttons">
              <a href="{{ route('admin.peserta.show', $p) }}" class="btn-action btn-view" title="View Details">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
              </a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="no-data">
            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p>No participants found</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($peserta->hasPages())
    <div class="pagination-container">
      {{ $peserta->appends(request()->query())->links() }}
    </div>
  @endif
</div>
@endsection
