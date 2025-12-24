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

@push('styles')
<style>
.auth-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.auth-box {
  background: #fff;
  padding: 2.5rem;
  border-radius: 20px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 420px;
}

.auth-header {
  text-align: center;
  margin-bottom: 2rem;
}

.auth-logo {
  width: 60px;
  height: 60px;
  margin-bottom: 1rem;
}

.auth-header h1 {
  font-family: 'Poppins', sans-serif;
  font-size: 1.75rem;
  font-weight: 700;
  color: #32477C;
  margin-bottom: 0.5rem;
}

.auth-header p {
  color: #666;
  font-size: 0.9rem;
}

.auth-form .form-group {
  margin-bottom: 1.25rem;
}

.auth-form label {
  display: block;
  font-family: 'Poppins', sans-serif;
  font-weight: 600;
  color: #333;
  margin-bottom: 0.5rem;
  font-size: 0.9rem;
}

.auth-form input[type="email"],
.auth-form input[type="password"],
.auth-form input[type="text"] {
  width: 100%;
  padding: 0.85rem 1rem;
  border: 2px solid #e1e1e1;
  border-radius: 10px;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  font-family: 'Poppins', sans-serif;
}

.auth-form input:focus {
  outline: none;
  border-color: #32477C;
  box-shadow: 0 0 0 3px rgba(50, 71, 124, 0.1);
}

.auth-form input.error {
  border-color: #B22A2A;
}

.error-message {
  color: #B22A2A;
  font-size: 0.8rem;
  margin-top: 0.35rem;
  display: block;
}

.btn-submit {
  width: 100%;
  padding: 0.9rem;
  background: #32477C;
  color: #fff;
  border: none;
  border-radius: 10px;
  font-family: 'Poppins', sans-serif;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 0.5rem;
}

.btn-submit:hover {
  background: #283a66;
  transform: translateY(-2px);
}

.auth-footer {
  text-align: center;
  margin-top: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid #eee;
}

.auth-footer p {
  color: #666;
  font-size: 0.9rem;
}

.auth-footer a {
  color: #B22A2A;
  font-weight: 600;
  text-decoration: none;
}

.auth-footer a:hover {
  text-decoration: underline;
}
</style>
@endpush
