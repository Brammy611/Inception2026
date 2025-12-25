@extends('layouts.app')

@section('content')
<div class="auth-container">
  <div class="auth-box">
    <div class="auth-header">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Inception" class="auth-logo">
      <h1>Register</h1>
      <p>Daftar akun Inception baru</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
      @csrf
      
      <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input 
          type="text" 
          id="nama" 
          name="nama" 
          value="{{ old('nama') }}" 
          required 
          autofocus
          placeholder="Masukkan nama lengkap Anda"
          class="@error('nama') error @enderror"
        >
        @error('nama')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          value="{{ old('email') }}" 
          required
          placeholder="Masukkan email Anda"
          class="@error('email') error @enderror"
        >
        @error('email')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input 
          type="password" 
          id="password" 
          name="password" 
          required
          placeholder="Minimal 8 karakter"
          class="@error('password') error @enderror"
        >
        @error('password')
          <span class="error-message">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input 
          type="password" 
          id="password_confirmation" 
          name="password_confirmation" 
          required
          placeholder="Ulangi password Anda"
        >
      </div>

      <button type="submit" class="btn-submit">Register</button>
    </form>

    <div class="auth-footer">
      <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>
  </div>
</div>
@endsection
