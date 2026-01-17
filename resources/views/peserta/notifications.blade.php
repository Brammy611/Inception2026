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
      <a href="{{ route('peserta.profile') }}" class="nav-item">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        <span>Profile</span>
      </a>
      <a href="{{ route('peserta.notifications') }}" class="nav-item active">
        <svg fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span>Notification</span>
      </a>
    </nav>
  </aside>

  {{-- Main Content --}}
  <main class="main-content">
    {{-- Notifications Header --}}
    <div class="competition-header" style="background: {{ $competition['color'] }};">
      <h1>NOTIFICATIONS</h1>
    </div>

    {{-- Notifications Section --}}
    <section class="section-team">
      <h2 class="section-title">YOUR NOTIFICATIONS</h2>
      
      @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 5px; color: #155724;">
          {{ session('success') }}
        </div>
      @endif

      <div class="notifications-container">
        @forelse($notifications as $notification)
          <div class="notification-card {{ $notification->is_read ? 'read' : 'unread' }}">
            <div class="notification-header">
              <div class="notification-icon" style="background: {{ $competition['color'] }};">
                @if($notification->type === 'verification')
                  <svg fill="white" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                @else
                  <svg fill="white" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                @endif
              </div>
              <div class="notification-meta">
                <h3 class="notification-title">{{ $notification->title }}</h3>
                <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
              </div>
            </div>
            
            <div class="notification-body">
              <p>{{ $notification->message }}</p>
              
              @if($notification->data)
                @php
                  $data = is_string($notification->data) ? json_decode($notification->data, true) : $notification->data;
                @endphp
                
                @if(isset($data['whatsapp_link']) && $data['whatsapp_link'])
                  <div class="notification-action" style="margin-top: 15px;">
                    <a href="{{ $data['whatsapp_link'] }}" target="_blank" class="btn-whatsapp" style="display: inline-block; background: #25D366; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: 600;">
                      <svg fill="white" viewBox="0 0 24 24" width="18" height="18" style="vertical-align: middle; margin-right: 8px;">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                      </svg>
                      Join Grup WhatsApp
                    </a>
                  </div>
                @endif
              @endif
            </div>
          </div>
        @empty
          <div class="empty-state" style="text-align: center; padding: 60px 20px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="80" height="80" style="margin: 0 auto 20px; color: #cbd5e0;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <h3 style="color: #4a5568; margin-bottom: 10px;">No notifications yet</h3>
            <p style="color: #718096;">You don't have any notifications at the moment.</p>
          </div>
        @endforelse
      </div>

      {{-- Pagination --}}
      @if($notifications->hasPages())
        <div class="pagination-container" style="margin-top: 30px;">
          {{ $notifications->links() }}
        </div>
      @endif
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
.notifications-container {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.notification-card {
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  border-left: 4px solid transparent;
}

.notification-card.unread {
  background: #f0f9ff;
  border-left-color: {{ $competition['color'] }};
}

.notification-card:hover {
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  transform: translateY(-2px);
}

.notification-header {
  display: flex;
  align-items: flex-start;
  gap: 15px;
  margin-bottom: 12px;
}

.notification-icon {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.notification-meta {
  flex: 1;
}

.notification-title {
  font-size: 18px;
  font-weight: 700;
  color: #1f2937;
  margin: 0 0 5px 0;
}

.notification-time {
  font-size: 13px;
  color: #6b7280;
}

.notification-body {
  padding-left: 63px;
}

.notification-body p {
  margin: 0;
  color: #4b5563;
  line-height: 1.6;
}

.btn-whatsapp:hover {
  background: #128C7E !important;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
}
</style>
@endsection
