@extends('layouts.app')

@section('title', 'Registrasi Career Talk - Inception 2026')

@section('content')
<section class="register-section">
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    <div class="blur-circle"></div>
    
    <div class="container-custom">
        <div class="register-wrapper">
            <!-- Left Side - Info -->
            <div class="register-info">
                <div class="info-header">
                    <a href="{{ route('career-talk') }}" class="back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Kembali
                    </a>
                    <h1>Daftar Career Talk</h1>
                    <p>Lengkapi formulir di samping untuk mendaftar</p>
                </div>

                <div class="event-details">
                    <h3>Detail Acara</h3>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <div>
                            <strong>Tanggal</strong>
                            <p>30 November 2025</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <div>
                            <strong>Waktu</strong>
                            <p>09:00 - 13:00 WIB</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <div>
                            <strong>Lokasi</strong>
                            <p>Zoom Online</p>
                        </div>
                    </div>
                </div>

                <div class="benefits-list">
                    <h3>Yang Akan Kamu Dapatkan</h3>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            E-Certificate
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Networking Session
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Free Lunch & Snacks
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Exclusive Materials
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Doorprize
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="register-form-wrapper">
                <form action="{{ route('career-talk.register.store') }}" method="POST" class="register-form">
                    @csrf
                    
                    @if($errors->any())
                    <div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <div>
                            <strong>Oops! Ada kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="form-section">
                        <h3>Data Pribadi</h3>
                        
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Masukkan nama lengkap">
                            @error('full_name')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email <span class="required">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                                @error('email')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">No. WhatsApp <span class="required">*</span></label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                                @error('phone')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Data Akademik</h3>
                        
                        <div class="form-group">
                            <label for="institution">Asal Institusi <span class="required">*</span></label>
                            <input type="text" id="institution" name="institution" value="{{ old('institution') }}" required placeholder="Universitas/Sekolah">
                            @error('institution')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="major">Program Studi <span class="required">*</span></label>
                                <input type="text" id="major" name="major" value="{{ old('major') }}" required placeholder="Teknik Perminyakan">
                                @error('major')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="semester">Semester <span class="required">*</span></label>
                                <select id="semester" name="semester" required>
                                    <option value="">Pilih Semester</option>
                                    @for($i = 1; $i <= 14; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                                    @endfor
                                </select>
                                @error('semester')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Motivasi</h3>
                        
                        <div class="form-group">
                            <label for="motivation">Kenapa Kamu Ingin Mengikuti Career Talk Ini? <span class="required">*</span></label>
                            <textarea id="motivation" name="motivation" rows="5" required placeholder="Ceritakan motivasimu mengikuti acara ini...">{{ old('motivation') }}</textarea>
                            <span class="char-count">
                                <span id="charCount">0</span>/1000 karakter
                            </span>
                            @error('motivation')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-button">
                            Kirim Pendaftaran
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    // Character counter
    const textarea = document.getElementById('motivation');
    const charCount = document.getElementById('charCount');
    
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            if (count > 1000) {
                charCount.style.color = 'var(--color-red)';
            } else {
                charCount.style.color = 'inherit';
            }
        });
        
        // Initialize count
        charCount.textContent = textarea.value.length;
    }
</script>
@endsection