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
      <h3 class="form-section-title">Informasi Member 1 (Wajib)</h3>
      
      <div class="form-row">
        <div class="form-group">
          <label for="nama_member_1">Nama Member 1</label>
          <input 
            type="text" 
            id="nama_member_1" 
            name="nama_member_1" 
            value="{{ old('nama_member_1') }}" 
            required 
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
            required 
            placeholder="Masukkan jurusan member 1"
            class="@error('jurusan_member_1') error @enderror"
          >
          @error('jurusan_member_1')
            <span class="error-message">{{ $message }}</span>
          @enderror
        </div>
      </div>

      {{-- Member 2 Information --}}
      <h3 class="form-section-title">Informasi Member 2 (Opsional)</h3>
      
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
@endsection
