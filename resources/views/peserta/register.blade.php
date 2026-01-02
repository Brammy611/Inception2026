@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-box" style="max-width: 700px;">
    <div class="auth-header">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="auth-logo">
      <h1>Pendaftaran Peserta</h1>
      <p>Lengkapi data tim Anda untuk mengikuti kompetisi</p>
    </div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('peserta.register.store') }}" class="auth-form" enctype="multipart/form-data">
      @csrf
      
      {{-- Team Information --}}
      <h3 class="form-section-title">Informasi Tim</h3>
      
      <div class="form-group">
        <label for="nama_tim">Nama Tim</label>
        <input 
          type="text" 
          id="nama_tim" 
          name="nama_tim" 
          value="{{ old('nama_tim') }}" 
          required 
          placeholder="Masukkan nama tim"
          class="@error('nama_tim') error @enderror"
        >
        @error('nama_tim')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="kategori">Kategori Lomba</label>
        <select 
          id="kategori" 
          name="kategori" 
          required
          class="@error('kategori') error @enderror"
        >
          <option value="">Pilih Kategori Lomba</option>
          @foreach($kategoriOptions as $value => $label)
            <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
        @error('kategori')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="asal_univ">Asal Universitas</label>
        <input 
          type="text" 
          id="asal_univ" 
          name="asal_univ" 
          value="{{ old('asal_univ') }}" 
          required 
          placeholder="Masukkan asal universitas"
          class="@error('asal_univ') error @enderror"
        >
        @error('asal_univ')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      {{-- Leader Information --}}
      <h3 class="form-section-title">Informasi Leader</h3>
      
      <div class="form-row">
        <div class="form-group">
          <label for="nama_leader">Nama Leader</label>
          <input 
            type="text" 
            id="nama_leader" 
            name="nama_leader" 
            value="{{ old('nama_leader', $user->nama) }}" 
            required 
            placeholder="Masukkan nama leader"
            class="@error('nama_leader') error @enderror"
          >
          @error('nama_leader')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="jurusan_leader">Jurusan Leader</label>
          <input 
            type="text" 
            id="jurusan_leader" 
            name="jurusan_leader" 
            value="{{ old('jurusan_leader') }}" 
            required 
            placeholder="Masukkan jurusan leader"
            class="@error('jurusan_leader') error @enderror"
          >
          @error('jurusan_leader')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      {{-- Member 1 Information --}}
      <h3 class="form-section-title" id="member1-title">Informasi Member 1</h3>
      <div id="member1-requirement-notice" style="display: none; background: #fff3e0; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #e65100; font-size: 14px;"></div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="nama_member_1">Nama Member 1</label>
          <input 
            type="text" 
            id="nama_member_1" 
            name="nama_member_1" 
            value="{{ old('nama_member_1') }}" 
            placeholder="Masukkan nama member 1"
            class="@error('nama_member_1') error @enderror"
          >
          @error('nama_member_1')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="jurusan_member_1">Jurusan Member 1</label>
          <input 
            type="text" 
            id="jurusan_member_1" 
            name="jurusan_member_1" 
            value="{{ old('jurusan_member_1') }}" 
            placeholder="Masukkan jurusan member 1"
            class="@error('jurusan_member_1') error @enderror"
          >
          @error('jurusan_member_1')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      {{-- Member 2 Information --}}
      <h3 class="form-section-title" id="member2-title">Informasi Member 2</h3>
      <div id="member2-requirement-notice" style="display: none; background: #fff3e0; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #e65100; font-size: 14px;"></div>
      
      <div class="form-row">
        <div class="form-group">
          <label for="nama_member_2">Nama Member 2</label>
          <input 
            type="text" 
            id="nama_member_2" 
            name="nama_member_2" 
            value="{{ old('nama_member_2') }}" 
            placeholder="Masukkan nama member 2"
            class="@error('nama_member_2') error @enderror"
          >
          @error('nama_member_2')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="jurusan_member_2">Jurusan Member 2</label>
          <input 
            type="text" 
            id="jurusan_member_2" 
            name="jurusan_member_2" 
            value="{{ old('jurusan_member_2') }}" 
            placeholder="Masukkan jurusan member 2"
            class="@error('jurusan_member_2') error @enderror"
          >
          @error('jurusan_member_2')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      {{-- Member 3 Information --}}
      <div id="member3-section" style="display: none;">
        <h3 class="form-section-title">Informasi Member 3 (Opsional)</h3>
        <div style="background: #e8f5e9; padding: 12px; border-radius: 6px; margin-bottom: 15px; color: #2e7d32; font-size: 14px;">
          <strong>Opsional:</strong> Member 3 opsional. Maksimal 4 anggota total (Leader + 3 members)
        </div>
        
        <div class="form-row">
          <div class="form-group">
            <label for="nama_member_3">Nama Member 3</label>
            <input 
              type="text" 
              id="nama_member_3" 
              name="nama_member_3" 
              value="{{ old('nama_member_3') }}" 
              placeholder="Masukkan nama member 3"
              class="@error('nama_member_3') error @enderror"
            >
            @error('nama_member_3')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="jurusan_member_3">Jurusan Member 3</label>
            <input 
              type="text" 
              id="jurusan_member_3" 
              name="jurusan_member_3" 
              value="{{ old('jurusan_member_3') }}" 
              placeholder="Masukkan jurusan member 3"
              class="@error('jurusan_member_3') error @enderror"
            >
            @error('jurusan_member_3')
              <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      {{-- Document Uploads --}}
      <h3 class="form-section-title">Upload Dokumen (Format PDF, Max 10MB)</h3>
      
      <div class="form-group">
        <label for="ktm">KTM (Kartu Tanda Mahasiswa)</label>
        <input 
          type="file" 
          id="ktm" 
          name="ktm" 
          accept=".pdf"
          required
          class="@error('ktm') error @enderror"
        >
        @error('ktm')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="follow_ig">Bukti Follow Instagram</label>
        <input 
          type="file" 
          id="follow_ig" 
          name="follow_ig" 
          accept=".pdf"
          required
          class="@error('follow_ig') error @enderror"
        >
        @error('follow_ig')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="share_poster">Bukti Share Poster</label>
        <input 
          type="file" 
          id="share_poster" 
          name="share_poster" 
          accept=".pdf"
          required
          class="@error('share_poster') error @enderror"
        >
        @error('share_poster')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="payment">Bukti Pembayaran</label>
        <input 
          type="file" 
          id="payment" 
          name="payment" 
          accept=".pdf"
          required
          class="@error('payment') error @enderror"
        >
        @error('payment')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn-submit">Daftar Sekarang</button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategori');
    const member1Title = document.getElementById('member1-title');
    const member2Title = document.getElementById('member2-title');
    const member1Notice = document.getElementById('member1-requirement-notice');
    const member2Notice = document.getElementById('member2-requirement-notice');
    const member3Section = document.getElementById('member3-section');
    
    const member1NameInput = document.getElementById('nama_member_1');
    const member1JurusanInput = document.getElementById('jurusan_member_1');
    const member2NameInput = document.getElementById('nama_member_2');
    const member2JurusanInput = document.getElementById('jurusan_member_2');
    
    function updateMemberRequirements() {
      const selectedKategori = kategoriSelect.value;
      
      if (selectedKategori === 'poster_paper') {
        // Poster Paper: min 2 (leader + 1), max 3 (leader + 2)
        member1Title.textContent = 'Informasi Member 1 (Opsional - Min 2 Anggota Total)';
        member2Title.textContent = 'Informasi Member 2 (Opsional - Max 3 Anggota Total)';
        
        member1Notice.style.display = 'block';
        member1Notice.innerHTML = '<strong>Poster & Paper Competition:</strong> Minimal 2 anggota (Leader + 1), Maksimal 3 anggota';
        
        member2Notice.style.display = 'block';
        member2Notice.innerHTML = '<strong>Opsional:</strong> Member 2 opsional (max 3 anggota total)';
        member2Notice.style.background = '#e3f2fd';
        member2Notice.style.color = '#1565c0';
        
        // Make member 1 optional
        member1NameInput.removeAttribute('required');
        member1JurusanInput.removeAttribute('required');
        member2NameInput.removeAttribute('required');
        member2JurusanInput.removeAttribute('required');
        
        // Hide member 3 section
        member3Section.style.display = 'none';
        
      } else if (selectedKategori === 'business_case' || selectedKategori === 'geothermal' || selectedKategori === 'well_stimulation') {
        // Other competitions: min 3 (leader + 2), max 4 (leader + 3)
        member1Title.textContent = 'Informasi Member 1 (Wajib)';
        member2Title.textContent = 'Informasi Member 2 (Wajib - Min 3 Anggota Total)';
        
        member1Notice.style.display = 'block';
        member1Notice.innerHTML = '<strong>Wajib:</strong> Member 1 wajib diisi (minimal 3 anggota)';
        
        member2Notice.style.display = 'block';
        member2Notice.innerHTML = '<strong>Wajib:</strong> Member 2 wajib diisi. Minimal 3 anggota (Leader + 2 members), Maksimal 4 anggota';
        member2Notice.style.background = '#fff3e0';
        member2Notice.style.color = '#e65100';
        
        // Make member 1 and 2 required
        member1NameInput.setAttribute('required', 'required');
        member1JurusanInput.setAttribute('required', 'required');
        member2NameInput.setAttribute('required', 'required');
        member2JurusanInput.setAttribute('required', 'required');
        
        // Show member 3 section
        member3Section.style.display = 'block';
        
      } else {
        // No kategori selected - hide all notices
        member1Notice.style.display = 'none';
        member2Notice.style.display = 'none';
        member3Section.style.display = 'none';
        member1Title.textContent = 'Informasi Member 1';
        member2Title.textContent = 'Informasi Member 2';
      }
    }
    
    // Update requirements when kategori changes
    kategoriSelect.addEventListener('change', updateMemberRequirements);
    
    // Initialize on page load
    updateMemberRequirements();
  });
</script>
@endsection
