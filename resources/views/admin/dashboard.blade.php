@extends('layouts.app')

@section('content')
<div class="dashboard-container">
  <div class="dashboard-content">
    <div class="dashboard-header">
      <h1>Dashboard Admin</h1>
      <p>Selamat datang, {{ auth()->user()->nama }}!</p>
    </div>

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

      <div class="dashboard-card">
        <div class="card-icon orange">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Kompetisi</h3>
          <p>Kelola kompetisi</p>
        </div>
      </div>

      <div class="dashboard-card">
        <div class="card-icon red">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
          </svg>
        </div>
        <div class="card-content">
          <h3>Peserta</h3>
          <p>Kelola data peserta</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-container {
  min-height: 100vh;
  padding: 120px 2rem 2rem;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.dashboard-content {
  max-width: 1200px;
  margin: 0 auto;
}

.dashboard-header {
  margin-bottom: 2rem;
}

.dashboard-header h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 2rem;
  font-weight: 700;
  color: #32477C;
  margin-bottom: 0.5rem;
}

.dashboard-header p {
  color: #666;
  font-size: 1.1rem;
}

.dashboard-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}

.dashboard-card {
  background: #fff;
  padding: 1.5rem;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  display: flex;
  align-items: flex-start;
  gap: 1rem;
  transition: all 0.3s ease;
  cursor: pointer;
  text-decoration: none;
}

.dashboard-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, #32477C, #4a5f94);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.card-icon.orange {
  background: linear-gradient(135deg, #f59e0b, #fbbf24);
}

.card-icon.red {
  background: linear-gradient(135deg, #B22A2A, #dc2626);
}

.card-icon svg {
  width: 24px;
  height: 24px;
  color: #fff;
}

.card-content h3 {
  font-family: 'Poppins', sans-serif;
  font-size: 1.1rem;
  font-weight: 600;
  color: #333;
  margin-bottom: 0.25rem;
}

.card-content p {
  color: #666;
  font-size: 0.9rem;
}
</style>
@endpush
