@extends('layouts.app')

@section('content')
<div class="dashboard-container">
  <div class="dashboard-content">
    <div class="dashboard-header">
      <h1>Dashboard Admin</h1>
      <p>Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>

    {{-- Quick Actions --}}
    <div class="dashboard-cards">
      <a href="{{ route('admin.career-talk.index') }}" class="dashboard-card">
        <div class="card-icon">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Career Talk</h3>
          <p>Kelola pendaftaran Career Talk</p>
        </div>
      </a>

      <a href="{{ route('admin.peserta.index') }}" class="dashboard-card">
        <div class="card-icon orange">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Competition Participants</h3>
          <p>Manage competition participants</p>
        </div>
      </a>

      <a href="{{ route('admin.semifinal-payments.index') }}" class="dashboard-card">
        <div class="card-icon purple">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 9V7a5 5 0 00-10 0v2M5 9h14l-1 11H6L5 9z"/>
            <path d="M9 13h6"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Semifinal Payments</h3>
          <p>Review and verify semifinal payment proofs</p>
        </div>
      </a>

      <a href="{{ route('admin.final-payments.index') }}" class="dashboard-card">
        <div class="card-icon purple">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 9V7a5 5 0 00-10 0v2M5 9h14l-1 11H6L5 9z"/>
            <path d="M8 13h8"/>
            <path d="M10 16h4"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Final Payments</h3>
          <p>Review and verify final payment proofs</p>
        </div>
      </a>

      <div class="dashboard-card">
        <div class="card-icon red">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Reports</h3>
          <p>View statistics and reports</p>
        </div>
      </div>
    </div>

    {{-- Statistics Overview --}}
    <div class="stats-overview">
      <div class="stats-section">
        <h2>Career Talk Statistics</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon purple">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $careerTalkStats['total'] }}</p>
              <p class="stat-label">Total Registrations</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon green">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $careerTalkStats['confirmed'] }}</p>
              <p class="stat-label">Confirmed</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon yellow">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $careerTalkStats['pending'] }}</p>
              <p class="stat-label">Pending</p>
            </div>
          </div>
        </div>
      </div>

      <div class="stats-section">
        <h2>Competition Statistics</h2>
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon purple">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $competitionStats['total'] }}</p>
              <p class="stat-label">Total Teams</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon green">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $competitionStats['verified'] }}</p>
              <p class="stat-label">Verified</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon yellow">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $competitionStats['pending'] }}</p>
              <p class="stat-label">Pending</p>
            </div>
          </div>

          <div class="stat-card">
            <div class="stat-icon red">
              <svg fill="white" viewBox="0 0 24 24" width="28" height="28">
                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            </div>
            <div class="stat-info">
              <p class="stat-value">{{ $competitionStats['rejected'] }}</p>
              <p class="stat-label">Rejected</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Charts Section --}}
    <div class="charts-section">
      <div class="chart-card">
        <h2>Registration Trend (Last 7 Days)</h2>
        <canvas id="registrationChart"></canvas>
      </div>

      <div class="chart-card">
        <h2>Competition by Category</h2>
        <canvas id="categoryChart"></canvas>
      </div>
    </div>

    {{-- Recent Activity --}}
    <div class="recent-activity-section">
      <div class="activity-card">
        <div class="activity-header">
          <h2>Recent Career Talk Registrations</h2>
          <a href="{{ route('admin.career-talk.index') }}" class="view-all">View All →</a>
        </div>
        <div class="activity-list">
          @forelse($recentCareerTalk as $registration)
            <div class="activity-item">
              <div class="activity-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </div>
              <div class="activity-content">
                <p class="activity-name">{{ $registration->nama }}</p>
                <p class="activity-detail">{{ $registration->universitas }} • {{ $registration->email }}</p>
              </div>
              <div class="activity-meta">
                <span class="status-badge status-{{ $registration->status }}">{{ ucfirst($registration->status) }}</span>
                <span class="activity-time">{{ $registration->created_at->diffForHumans() }}</span>
              </div>
            </div>
          @empty
            <p class="empty-state">No recent registrations</p>
          @endforelse
        </div>
      </div>

      <div class="activity-card">
        <div class="activity-header">
          <h2>Recent Competition Registrations</h2>
          <a href="{{ route('admin.peserta.index') }}" class="view-all">View All →</a>
        </div>
        <div class="activity-list">
          @forelse($recentCompetition as $team)
            <div class="activity-item">
              <div class="activity-icon" style="background: {{ ['#FBB137', '#B22A2A', '#4683B5', '#32477C'][array_rand([0,1,2,3])] }};">
                <svg fill="white" viewBox="0 0 24 24" width="20" height="20">
                  <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </div>
              <div class="activity-content">
                <p class="activity-name">{{ $team->nama_tim }}</p>
                <p class="activity-detail">{{ $team->asal_univ }} • {{ ucfirst(str_replace('_', ' ', $team->kategori_lomba)) }}</p>
              </div>
              <div class="activity-meta">
                <span class="status-badge status-{{ $team->status_verifikasi }}">{{ ucfirst($team->status_verifikasi) }}</span>
                <span class="activity-time">{{ $team->created_at->diffForHumans() }}</span>
              </div>
            </div>
          @empty
            <p class="empty-state">No recent registrations</p>
          @endforelse
        </div>
      </div>
    </div>

    
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Registration Trend Chart
const registrationCtx = document.getElementById('registrationChart').getContext('2d');
new Chart(registrationCtx, {
  type: 'line',
  data: {
    labels: {!! json_encode($registrationTrend['labels']) !!},
    datasets: [
      {
        label: 'Career Talk',
        data: {!! json_encode($registrationTrend['careerTalk']) !!},
        borderColor: '#667eea',
        backgroundColor: 'rgba(102, 126, 234, 0.1)',
        tension: 0.4,
        fill: true
      },
      {
        label: 'Competition',
        data: {!! json_encode($registrationTrend['competition']) !!},
        borderColor: '#FBB137',
        backgroundColor: 'rgba(251, 177, 55, 0.1)',
        tension: 0.4,
        fill: true
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        position: 'top'
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          stepSize: 1
        }
      }
    }
  }
});

// Category Chart
const categoryCtx = document.getElementById('categoryChart').getContext('2d');
new Chart(categoryCtx, {
  type: 'doughnut',
  data: {
    labels: ['Business Case', 'Geothermal', 'Poster & Paper', 'Well Stimulation'],
    datasets: [{
      data: [
        {{ $competitionByCategory['business_case'] }},
        {{ $competitionByCategory['geothermal'] }},
        {{ $competitionByCategory['poster_paper'] }},
        {{ $competitionByCategory['well_stimulation'] }}
      ],
      backgroundColor: [
        '#FBB137',
        '#B22A2A',
        '#4683B5',
        '#32477C'
      ],
      borderWidth: 2,
      borderColor: '#fff'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: true,
        position: 'bottom'
      }
    }
  }
});
</script>
@endsection
