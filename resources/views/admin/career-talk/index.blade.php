@extends('layouts.app')

@section('title', 'Career Talk Registrations')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1>Career Talk Registrations</h1>
        <div class="admin-actions">
            <a href="{{ route('admin.career-talk.export', request()->query()) }}" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Export CSV
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue-gradient">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Registrasi</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange-gradient">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green-gradient">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['confirmed'] }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple-gradient">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $stats['attended'] }}</div>
            <div class="stat-label">Attended</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filters-section">
    <form method="GET" action="{{ route('admin.career-talk.index') }}" class="filters-form">
        <div class="filter-group">
            <input type="text" name="search" placeholder="Search by name, email, institution..." value="{{ request('search') }}" class="filter-input">
        </div>
        
        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>Attended</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.35-4.35"></path></svg>
            Filter
        </button>

        @if(request('search') || request('status'))
        <a href="{{ route('admin.career-talk.index') }}" class="btn btn-secondary">Clear</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="table-container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>Registration No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Institution</th>
                <th>Status</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $registration)
            <tr>
                <td>
                    <span class="reg-number">{{ $registration->registration_number }}</span>
                </td>
                <td>
                    <div class="participant-info">
                        <strong>{{ $registration->full_name }}</strong>
                        <small>{{ $registration->major }}</small>
                    </div>
                </td>
                <td>{{ $registration->email }}</td>
                <td>{{ $registration->institution }}</td>
                <td>
                    <span class="badge badge-{{ $registration->status }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </td>
                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.career-talk.show', $registration) }}" class="btn-icon" title="View Details">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        
                        <form method="POST" action="{{ route('admin.career-talk.update-status', $registration) }}" class="form-inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="status-select">
                                <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $registration->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="attended" {{ $registration->status == 'attended' ? 'selected' : '' }}>Attended</option>
                                <option value="cancelled" {{ $registration->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>

                        <form method="POST" action="{{ route('admin.career-talk.destroy', $registration) }}" onsubmit="return confirm('Are you sure?')" class="form-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-danger" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="empty-state">
                    <p>No registrations found</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

<style>
.admin-header {
    margin-bottom: 2rem;
}

.admin-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.admin-header h1 {
    font-size: 2rem;
    color: var(--text-primary);
}

.admin-actions {
    display: flex;
    gap: 1rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    border: 1px solid rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-label {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.filters-section {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.filters-form {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-input,
.filter-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid rgba(0,0,0,0.1);
    border-radius: 10px;
    font-size: 0.95rem;
}

.table-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--bg-secondary);
}

.data-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 2px solid rgba(0,0,0,0.1);
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.reg-number {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: var(--accent-primary);
}

.participant-info strong {
    display: block;
    margin-bottom: 0.25rem;
}

.participant-info small {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.badge-pending {
    background: rgba(251, 177, 55, 0.2);
    color: #FBB137;
}

.badge-confirmed {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.badge-attended {
    background: rgba(139, 92, 246, 0.2);
    color: #8b5cf6;
}

.badge-cancelled {
    background: rgba(178, 42, 42, 0.2);
    color: #B22A2A;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-icon {
    padding: 0.5rem;
    border: none;
    background: rgba(0,0,0,0.05);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-icon:hover {
    background: var(--accent-primary);
    color: white;
}

.btn-icon.btn-danger:hover {
    background: var(--accent-secondary);
}

.status-select {
    padding: 0.4rem 0.8rem;
    border: 2px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    font-size: 0.85rem;
    cursor: pointer;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--gradient-warm);
    color: white;
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.btn-secondary {
    background: white;
    color: var(--text-primary);
    border: 2px solid rgba(0,0,0,0.1);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.alert-success {
    background: rgba(16, 185, 129, 0.1);
    border: 1px solid #10b981;
    color: #059669;
}
</style>
