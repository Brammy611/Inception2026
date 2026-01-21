@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/admin-peserta.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection

@section('content')
<div class="admin-container">
  <div class="detail-header">
    <div>
      <a href="{{ route('admin.peserta.show', $peserta) }}" class="btn-back">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Participant
      </a>
      <h1>Submissions</h1>
      <p>{{ $peserta->nama_tim }} - {{ $competition['name'] ?? 'Competition' }}</p>
    </div>
  </div>

  {{-- Submission Progress --}}
  <div class="detail-card">
    <div class="card-header" style="border-left: 5px solid {{ $competition['color'] ?? '#FBB137' }};">
      <h2>Submission Progress</h2>
    </div>
    <div class="card-body">
      @php
        $progress = $peserta->submission_progress;
      @endphp
      <div class="admin-progress-info">
        <span class="progress-text">{{ $progress['uploaded'] }} dari {{ $progress['total'] }} file terunggah</span>
        <span class="progress-percentage" style="color: {{ $competition['color'] ?? '#07AD33' }};">{{ $progress['percentage'] }}%</span>
      </div>
      <div class="progress-bar-container">
        <div class="progress-bar" style="width: {{ $progress['percentage'] }}%; background: {{ $competition['color'] ?? '#07AD33' }};"></div>
      </div>
    </div>
  </div>

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
  @endphp

  @foreach($stageOrder as $stage)
    @if(isset($stages[$stage]))
    <div class="detail-card">
      <div class="card-header">
        <h2>{{ $stageNames[$stage] }}</h2>
      </div>
      <div class="card-body">
        <div class="admin-submissions-table">
          <table>
            <thead>
              <tr>
                <th>Submission Type</th>
                <th>Status</th>
                <th>File Name</th>
                <th>Size</th>
                <th>Uploaded At</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($stages[$stage] as $requirement)
                @php
                  $key = $requirement['type'] . '_' . $requirement['stage'];
                  $submission = $existingSubmissions->get($key);
                @endphp
                <tr>
                  <td>
                    <strong>{{ $requirement['label'] }}</strong>
                    <br>
                    <small style="color: #666;">{{ $requirement['description'] }}</small>
                  </td>
                  <td>
                    @if($submission)
                      <span class="status-badge status-verified">Uploaded</span>
                    @else
                      <span class="status-badge status-pending">Not Uploaded</span>
                    @endif
                  </td>
                  <td>
                    @if($submission)
                      <span title="{{ $submission->original_filename }}">
                        {{ Str::limit($submission->original_filename, 30) }}
                      </span>
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>
                    @if($submission)
                      {{ $submission->formatted_file_size }}
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>
                    @if($submission)
                      {{ $submission->uploaded_at->format('d M Y, H:i') }}
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>
                    @if($submission)
                      <div class="action-buttons">
                        <a href="{{ route('admin.peserta.submissions.view', ['peserta' => $peserta, 'type' => $requirement['type'], 'stage' => $requirement['stage']]) }}" 
                           class="btn-action-small btn-view" target="_blank" title="View">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                          </svg>
                        </a>
                        <a href="{{ route('admin.peserta.submissions.download', ['peserta' => $peserta, 'type' => $requirement['type'], 'stage' => $requirement['stage']]) }}" 
                           class="btn-action-small btn-download" title="Download">
                          <svg fill="currentColor" viewBox="0 0 24 24" width="16" height="16">
                            <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                          </svg>
                        </a>
                      </div>
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @endif
  @endforeach
</div>

<style>
.admin-progress-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.admin-progress-info .progress-text {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  font-weight: 500;
  color: #333;
}

.admin-progress-info .progress-percentage {
  font-family: 'Poppins', sans-serif;
  font-size: 18px;
  font-weight: 700;
}

.admin-submissions-table {
  overflow-x: auto;
}

.admin-submissions-table table {
  width: 100%;
  border-collapse: collapse;
}

.admin-submissions-table th,
.admin-submissions-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
  font-family: 'Poppins', sans-serif;
}

.admin-submissions-table th {
  background: #f8f9fa;
  font-weight: 600;
  font-size: 13px;
  color: #333;
}

.admin-submissions-table td {
  font-size: 14px;
  color: #333;
}

.admin-submissions-table tr:hover {
  background: #f5f5f5;
}

.action-buttons {
  display: flex;
  gap: 8px;
}

.btn-action-small {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 6px;
  transition: all 0.2s ease;
  text-decoration: none;
}

.btn-action-small.btn-view {
  background: #e7f1ff;
  color: #0d6efd;
}

.btn-action-small.btn-view:hover {
  background: #0d6efd;
  color: #fff;
}

.btn-action-small.btn-download {
  background: #e8f5e9;
  color: #28a745;
}

.btn-action-small.btn-download:hover {
  background: #28a745;
  color: #fff;
}
</style>
@endsection
